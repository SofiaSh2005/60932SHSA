<h1>Услуги</h1>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Название услуги</th>
        <th>Сеансы</th>
    </tr>
    @foreach($uslugas as $usluga)
        <tr>
            <td>{{ $usluga->id }}</td>
            <td>{{ $usluga->nazvanie }}</td>
            <td>
                @foreach($usluga->seanss as $seans)
                    {{ $seans->id }} (Клиент: {{ $seans->klient->fio ?? 'нет' }})<br>
                @endforeach
            </td>
        </tr>
    @endforeach
</table>
