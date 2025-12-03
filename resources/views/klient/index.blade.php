@extends('layout')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Клиенты</h1>


            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                        data-bs-toggle="dropdown">
                    Показать: {{ request('perpage', 2) }}
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="?perpage=2&page=1">
                            2 записи
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="?perpage=3&page=1">
                            3 записи
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="?perpage=4&page=1">
                            4 записи
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="?perpage=5&page=1">
                            5 записей
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <table class="table table-bordered">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>Телефон</th>
                <th>Сеансы</th>
            </tr>
            </thead>
            <tbody>
            @foreach($klients as $klient)
                <tr>
                    <td>{{ $klient->id }}</td>
                    <td>{{ $klient->fio }}</td>
                    <td>{{ $klient->telefon }}</td>
                    <td>
                        @foreach($klient->seanss as $seans)
                            {{ $seans->id }} ({{ $seans->kosmetolog->fio ?? 'нет' }})<br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Показано {{ $klients->firstItem() }} - {{ $klients->lastItem() }} из {{ $klients->total() }}
            </div>

            <nav>
                {{ $klients->appends(['perpage' => request('perpage', 2)])->links('pagination::bootstrap-5') }}
            </nav>
        </div>
    </div>
@endsection
