@extends('layout')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Оказанные услуги</h1>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Услуга</th>
                    <th>Клиент</th>
                    <th>Косметолог</th>
                    <th>Дата и время</th>
                    <th>Кол-во</th>
                    <th>Стоимость</th>
                </tr>
                </thead>
                <tbody>
                @foreach($okazannyeUslugi as $ok)
                    <tr>
                        <td>{{ $ok->id }}</td>
                        <td>{{ $ok->usluga->nazvanie ?? '—' }}</td>
                        <td>{{ $ok->seans->klient->fio ?? '—' }}</td>
                        <td>{{ $ok->seans->kosmetolog->fio ?? '—' }}</td>
                        <td>{{ $ok->seans->data_vremya ?? '—' }}</td>
                        <td class="text-center">{{ $ok->kolichestvo ?? '1' }}</td>
                        <td class="text-end">{{ $ok->stoimost ?? ($ok->usluga->stoimost ?? '—') }} ₽</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if(method_exists($okazannyeUslugi, 'links'))
            <div class="mt-3">
                {{ $okazannyeUslugi->links() }}
            </div>
        @endif
    </div>
@endsection
