@extends('layout')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Услуги</h1>

        <table class="table table-bordered">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Название услуги</th>
                <th>Стоимость</th>
                <th>Клиенты</th>
            </tr>
            </thead>
            <tbody>
            @foreach($uslugas as $usluga)
                <tr>
                    <td>{{ $usluga->id }}</td>
                    <td>{{ $usluga->nazvanie }}</td>
                    <td class="text-end">{{ $usluga->stoimost }} ₽</td>
                    <td>
                        @foreach($usluga->seans as $seans)
                            {{ $seans->id }} (Клиент: {{ $seans->klient->fio ?? 'нет' }})<br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
