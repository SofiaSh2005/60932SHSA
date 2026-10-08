<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usluga;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UslugaApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response(
            Usluga::limit($request->perpage ?? 5)
                ->offset(($request->perpage ?? 5) * ($request->page ?? 0))
                ->get()
        );
    }

    public function total()
    {
        return response(Usluga::all()->count());
    }

    public function bookable()
    {
        return response()->json(
            Usluga::whereHas('kosmetologi')->orderBy('nazvanie')->get()
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Проверка прав
        if (Gate::denies('create-usluga')) {
            return response()->json([
                'code' => 1,
                'message' => 'У вас нет прав на добавление услуги',
            ], 403);
        }

        // 2. Валидация данных
        $validated = $request->validate([
            'nazvanie' => 'required|max:255',
            'stoimost' => 'required|integer',
            'prodolzhitelnost' => 'required|integer|min:30|max:480',
            'image' => 'nullable|file|image|max:2048',
        ]);

        // 3. Получение файла
        $file = $request->file('image');
        $fileUrl = null;

        // Генерация уникального имени файла
        if ($file) {
          $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
          try {
            // 4. Загрузка файла в S3
            $path = Storage::disk('s3')->putFileAs('usluga_pictures', $file, $fileName);
            $fileUrl = Storage::disk('s3')->url($path);
          } catch (\Exception $e) {
            return response()->json([
                'code' => 2,
                'message' => $e->getMessage(),
            ]);
          }
        }

        // 5. Создание услуги
        $usluga = Usluga::create([
            'nazvanie' => $validated['nazvanie'],
            'stoimost' => $validated['stoimost'],
            'prodolzhitelnost' => $validated['prodolzhitelnost'],
            'image' => $fileUrl,
        ]);

        // 6. Успешный ответ
        return response()->json([
            'code' => 0,
            'message' => 'Услуга успешно добавлена',
            'data' => $usluga,
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response(Usluga::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_unless($request->user()->isAdmin(), 403, 'Доступно только администратору');
        $usluga = Usluga::findOrFail($id);
        $validated = $request->validate([
            'nazvanie' => 'required|string|max:255',
            'stoimost' => 'required|numeric|min:0',
            'prodolzhitelnost' => 'required|integer|min:30|max:480',
        ]);
        $usluga->update($validated);
        return response()->json($usluga);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_unless(request()->user()->isAdmin(), 403, 'Доступно только администратору');
        $usluga = Usluga::findOrFail($id);
        abort_if($usluga->seans()->exists(), 409, 'Нельзя удалить услугу, которая используется в записях');
        $usluga->delete();
        return response()->json(['success' => true]);
    }
}



