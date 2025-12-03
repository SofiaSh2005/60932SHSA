@extends('layout')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Сеансы</h1>

        <div class="mb-3">
            <a href="{{ route('seans.create') }}" class="btn btn-primary btn-sm">
                + Добавить сеанс
            </a>
        </div>

        <table class="table table-bordered">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Клиент</th>
                <th>Косметолог</th>
                <th>Дата и время</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($seansy as $seans)
                <tr>
                    <td>{{ $seans->id }}</td>
                    <td>{{ $seans->klient->fio ?? '-' }}</td>
                    <td>{{ $seans->kosmetolog->fio ?? '-' }}</td>
                    <td>{{ $seans->data_vremya }}</td>
                    <td>
                        <a href="{{ route('seans.edit', $seans->id) }}" class="btn btn-sm btn-outline-primary">
                            Редактировать
                        </a>
                        <form action="{{ route('seans.destroy', $seans->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Удалить сеанс?')">
                                Удалить
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
