<h1>Сеансы</h1>

<a href="{{ route('seans.create') }}">Добавить новый сеанс</a>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Клиент</th>
        <th>Косметолог</th>
        <th>Дата и время</th>
        <th>Действия</th>
    </tr>
    @foreach($seansy as $seans)
        <tr>
            <td>{{ $seans->id }}</td>
            <td>{{ $seans->klient->fio ?? '-' }}</td> {{-- если клиента нет, то - --}}
            <td>{{ $seans->kosmetolog->fio ?? '-' }}</td>
            <td>{{ $seans->data_vremya }}</td>
            <td>
                <a href="{{ route('seans.edit', $seans->id) }}">Редактировать</a> |  {{--открывает форму редактирования (edit() контроллера--}}
                <a href="{{ route('seans.destroy', $seans->id) }}" onclick="return confirm('Удалить сеанс?')">🗑Удалить</a> {{--вызывает destroy() и спрашивает подтверждение перед удалением--}}
            </td>
        </tr>
    @endforeach
</table>
