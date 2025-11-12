<h1>Клиенты</h1>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>ФИО</th>
        <th>Телефон</th>
        <th>Сеансы</th>
    </tr>
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
</table>


{{ $klients->links() }}
