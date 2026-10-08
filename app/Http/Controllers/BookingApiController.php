<?php

namespace App\Http\Controllers;

use App\Models\Kosmetolog;
use App\Models\Seans;
use App\Models\Usluga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingApiController extends Controller
{
    public function masters(Usluga $usluga)
    {
        return response()->json($usluga->kosmetologi()->orderBy('fio')->get());
    }

    public function slots(Request $request)
    {
        $validated = $request->validate([
            'usluga_id' => 'required|exists:usluga,id',
            'kosmetolog_id' => 'required|exists:kosmetolog,id',
            'date' => 'required|date|after_or_equal:today',
        ]);

        $date = Carbon::parse($validated['date']);
        if ($date->isWeekend()) {
            return response()->json([]);
        }

        $usluga = Usluga::findOrFail($validated['usluga_id']);
        $master = Kosmetolog::findOrFail($validated['kosmetolog_id']);
        abort_unless($master->uslugi()->whereKey($usluga->id)->exists(), 422, 'Мастер не выполняет эту услугу');

        $cursor = Carbon::parse($date->toDateString() . ' ' . $master->nachalo_raboty);
        $workEnd = Carbon::parse($date->toDateString() . ' ' . $master->konec_raboty);
        $slots = [];

        while ($cursor->copy()->addMinutes($usluga->prodolzhitelnost)->lte($workEnd)) {
            $end = $cursor->copy()->addMinutes($usluga->prodolzhitelnost);
            $busy = Seans::where('kosmetolog_id', $master->id)
                ->where('status', '!=', 'cancelled')
                ->where('data_vremya', '<', $end)
                ->where('data_okonchaniya', '>', $cursor)
                ->exists();

            if (!$busy && $cursor->isFuture()) {
                $slots[] = $cursor->format('H:i');
            }
            $cursor->addMinutes(30);
        }

        return response()->json($slots);
    }

    public function store(Request $request)
    {
        abort_unless($request->user()->klient_id, 422, 'Аккаунт не связан с клиентом');
        $validated = $request->validate([
            'usluga_id' => 'required|exists:usluga,id',
            'kosmetolog_id' => 'required|exists:kosmetolog,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ]);

        $usluga = Usluga::findOrFail($validated['usluga_id']);
        $master = Kosmetolog::findOrFail($validated['kosmetolog_id']);
        abort_unless($master->uslugi()->whereKey($usluga->id)->exists(), 422, 'Мастер не выполняет эту услугу');

        $start = Carbon::parse($validated['date'] . ' ' . $validated['time']);
        $end = $start->copy()->addMinutes($usluga->prodolzhitelnost);
        abort_if($start->isWeekend(), 422, 'В выходные мастер не работает');
        $workStart = Carbon::parse($validated['date'] . ' ' . $master->nachalo_raboty);
        $workEnd = Carbon::parse($validated['date'] . ' ' . $master->konec_raboty);
        abort_unless($start->minute % 30 === 0 && $start->gte($workStart) && $end->lte($workEnd), 422, 'Выберите доступное рабочее время');

        $seans = DB::transaction(function () use ($request, $validated, $master, $usluga, $start, $end) {
            $busy = Seans::where('kosmetolog_id', $master->id)
                ->where('status', '!=', 'cancelled')
                ->where('data_vremya', '<', $end)
                ->where('data_okonchaniya', '>', $start)
                ->lockForUpdate()->exists();
            abort_if($busy, 409, 'Это время уже занято');

            return Seans::create([
                'klient_id' => $request->user()->klient_id,
                'kosmetolog_id' => $validated['kosmetolog_id'],
                'usluga_id' => $validated['usluga_id'],
                'data_vremya' => $start,
                'data_okonchaniya' => $end,
                'status' => 'new',
            ]);
        });

        return response()->json($seans->load(['klient', 'kosmetolog', 'vybrannayaUsluga']), 201);
    }

    public function mine(Request $request)
    {
        return response()->json(
            Seans::with(['kosmetolog', 'vybrannayaUsluga'])
                ->where('klient_id', $request->user()->klient_id)
                ->orderByDesc('data_vremya')->get()
        );
    }

    public function adminIndex(Request $request)
    {
        $this->admin($request);
        return response()->json(Seans::with(['klient', 'kosmetolog', 'vybrannayaUsluga'])->orderByDesc('data_vremya')->get());
    }

    public function adminStore(Request $request)
    {
        $this->admin($request);
        $validated = $request->validate([
            'klient_id' => 'required|exists:klient,id',
            'usluga_id' => 'required|exists:usluga,id',
            'kosmetolog_id' => 'required|exists:kosmetolog,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ]);

        $usluga = Usluga::findOrFail($validated['usluga_id']);
        $master = Kosmetolog::findOrFail($validated['kosmetolog_id']);
        abort_unless($master->uslugi()->whereKey($usluga->id)->exists(), 422, 'Мастер не выполняет эту услугу');

        $start = Carbon::parse($validated['date'] . ' ' . $validated['time']);
        $end = $start->copy()->addMinutes($usluga->prodolzhitelnost);
        $workStart = Carbon::parse($validated['date'] . ' ' . $master->nachalo_raboty);
        $workEnd = Carbon::parse($validated['date'] . ' ' . $master->konec_raboty);
        abort_if($start->isWeekend(), 422, 'В выходные мастер не работает');
        abort_unless($start->minute % 30 === 0 && $start->gte($workStart) && $end->lte($workEnd), 422, 'Выберите доступное рабочее время');

        $seans = DB::transaction(function () use ($validated, $master, $start, $end) {
            $busy = Seans::where('kosmetolog_id', $master->id)
                ->where('status', '!=', 'cancelled')
                ->where('data_vremya', '<', $end)
                ->where('data_okonchaniya', '>', $start)
                ->lockForUpdate()->exists();
            abort_if($busy, 409, 'Это время уже занято');

            return Seans::create([
                'klient_id' => $validated['klient_id'],
                'kosmetolog_id' => $validated['kosmetolog_id'],
                'usluga_id' => $validated['usluga_id'],
                'data_vremya' => $start,
                'data_okonchaniya' => $end,
                'status' => 'confirmed',
            ]);
        });

        return response()->json($seans->load(['klient', 'kosmetolog', 'vybrannayaUsluga']), 201);
    }

    public function setStatus(Request $request, Seans $seans)
    {
        $this->admin($request);
        $validated = $request->validate(['status' => 'required|in:new,confirmed,completed,cancelled']);
        $seans->update($validated);
        return response()->json($seans);
    }

    private function admin(Request $request): void
    {
        abort_unless($request->user()->isAdmin(), 403, 'Доступно только администратору');
    }
}
