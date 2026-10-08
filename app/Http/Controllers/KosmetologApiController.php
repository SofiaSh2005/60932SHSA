<?php

namespace App\Http\Controllers;

use App\Models\Kosmetolog;
use Illuminate\Http\Request;

class KosmetologApiController extends Controller
{
    public function index()
    {
        return response()->json(
            Kosmetolog::with(['seanss', 'uslugi'])->orderBy('fio')->get()
        );
    }

    public function store(Request $request)
    {
        $this->admin($request);
        $data = $this->validated($request);
        $services = $data['usluga_ids'];
        unset($data['usluga_ids']);
        $master = Kosmetolog::create($data);
        $master->uslugi()->sync($services);
        return response()->json($master->load('uslugi'), 201);
    }

    public function update(Request $request, Kosmetolog $kosmetolog)
    {
        $this->admin($request);
        $data = $this->validated($request);
        $services = $data['usluga_ids'];
        unset($data['usluga_ids']);
        $kosmetolog->update($data);
        $kosmetolog->uslugi()->sync($services);
        return response()->json($kosmetolog->load('uslugi'));
    }

    public function destroy(Request $request, Kosmetolog $kosmetolog)
    {
        $this->admin($request);
        abort_if($kosmetolog->seanss()->exists(), 409, 'Нельзя удалить мастера, у которого есть записи');
        $kosmetolog->delete();
        return response()->json(['success' => true]);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'fio' => 'required|string|max:255',
            'specialnost' => 'nullable|string|max:255',
            'telefon' => 'nullable|string|max:30',
            'nachalo_raboty' => 'required|date_format:H:i',
            'konec_raboty' => 'required|date_format:H:i|after:nachalo_raboty',
            'usluga_ids' => 'required|array|min:1',
            'usluga_ids.*' => 'exists:usluga,id',
        ]);
    }

    private function admin(Request $request): void
    {
        abort_unless($request->user()->isAdmin(), 403, 'Доступно только администратору');
    }
}
