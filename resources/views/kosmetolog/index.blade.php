@extends('layout')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Косметологи</h1>

        <table class="table table-bordered">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>Сеансы</th>
            </tr>
            </thead>
            <tbody>
            @foreach($kosmetologs as $kosmetolog)
                <tr>
                    <td>{{ $kosmetolog->id }}</td>
                    <td>{{ $kosmetolog->fio }}</td>
                    <td>
                        @foreach($kosmetolog->seanss as $seans)
                            {{ $seans->id }} (Клиент: {{ $seans->klient->fio ?? 'нет' }})<br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
