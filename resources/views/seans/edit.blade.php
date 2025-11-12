<h1>Редактировать сеанс</h1>

@if ($errors->any()) {{--проверяет ошибки валидации--}}
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('seans.update', $seans->id) }}" method="POST">
    @csrf

    <label>Клиент:</label>
    <select name="klient_id">
        @foreach($klients as $klient)
            <option value="{{ $klient->id }}" {{ $seans->klient_id == $klient->id ? 'selected' : '' }}>
                {{ $klient->fio }}
            </option>
        @endforeach
    </select>
    <br>

    <label>Косметолог:</label>
    <select name="kosmetolog_id"> {{--выпадающий список--}}
        @foreach($kosmetologs as $kosmetolog) {{--перебор всех клиентов которых контроллер передал в шаблон--}}
            <option value="{{ $kosmetolog->id }}" {{ $seans->kosmetolog_id == $kosmetolog->id ? 'selected' : '' }}>
                {{ $kosmetolog->fio }}
            </option>
        @endforeach
    </select>
    <br>

    <label>Дата и время:</label>
    <input type="datetime-local" name="data_vremya" value="{{ $seans->data_vremya }}">
    <br>

    <button type="submit">Сохранить</button>
</form>
