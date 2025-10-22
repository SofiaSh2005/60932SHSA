<h1>Косметологи</h1>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>ФИО</th>
        <th>Сеансы</th>
    </tr>
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
</table>
