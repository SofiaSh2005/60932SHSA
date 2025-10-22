<h1>Сеансы</h1>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Клиент</th>
        <th>Косметолог</th>
        <th>Услуги</th>
    </tr>
    @foreach($seanss as $seans)
        <tr>
            <td>{{ $seans->id }}</td>
            <td>{{ $seans->klient->fio ?? 'нет' }}</td>
            <td>{{ $seans->kosmetolog->fio ?? 'нет' }}</td>
            <td>
                @foreach($seans->uslugis as $usluga)
                    {{ $usluga->nazvanie }}<br>
                @endforeach
            </td>
        </tr>
    @endforeach
</table>
