<h1>Добавить сеанс</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('seans.store') }}" method="POST">
    @csrf
    <label>Клиент:</label>
    <select name="klient_id">
        <option value="">Выберите клиента</option>
        @foreach($klients as $klient)
            <option value="{{ $klient->id }}" {{ old('klient_id') == $klient->id ? 'selected' : '' }}>
                {{ $klient->fio }}
            </option>
        @endforeach
    </select>
    <br>

    <label>Косметолог:</label>
    <select name="kosmetolog_id">
        <option value="">Выберите косметолога</option>
        @foreach($kosmetologs as $kosmetolog)
            <option value="{{ $kosmetolog->id }}" {{ old('kosmetolog_id') == $kosmetolog->id ? 'selected' : '' }}>
                {{ $kosmetolog->fio }}
            </option>
        @endforeach
    </select>
    <br>

    <label>Дата и время:</label>
    <input type="datetime-local" name="data_vremya" value="{{ old('data_vremya') }}">
    <br>

    <button type="submit">Добавить</button>
</form>
