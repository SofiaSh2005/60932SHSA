<h1>Оказанные услуги</h1>

<table border="1" cellpadding="8" cellspacing="0">
    <tr style="background-color:#f3f3f3;">
        <th>ID</th>
        <th>Услуга</th>
        <th>Клиент</th>
        <th>Косметолог</th>
        <th>Дата и время сеанса</th>
        <th>Количество</th>
        <th>Стоимость</th>
    </tr>
    @foreach($okazannyeUslugi as $ok)
        <tr>
            <td>{{ $ok->id }}</td>
            <td>{{ $ok->usluga->nazvanie ?? '—' }}</td>
            <td>{{ $ok->seans->klient->fio ?? '—' }}</td>
            <td>{{ $ok->seans->kosmetolog->fio ?? '—' }}</td>
            <td>{{ $ok->seans->data_vremya ?? '—' }}</td>
            <td>{{ $ok->kolichestvo ?? '1' }}</td>
            <td>{{ $ok->stoimost ?? ($ok->usluga->stoimost ?? '—') }}</td>
        </tr>
    @endforeach
</table>
