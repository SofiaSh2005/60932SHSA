@extends('layout')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Добавить сеанс</h1>

        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('seans.store') }}" method="POST" class="border p-4 rounded bg-light">
            @csrf

            <div class="mb-3">
                <label class="form-label">Клиент:</label>
                <select name="klient_id" class="form-control">
                    <option value="">Выберите клиента</option>
                    @foreach($klients as $klient)
                        <option value="{{ $klient->id }}" {{ old('klient_id') == $klient->id ? 'selected' : '' }}>
                            {{ $klient->fio }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Косметолог:</label>
                <select name="kosmetolog_id" class="form-control">
                    <option value="">Выберите косметолога</option>
                    @foreach($kosmetologs as $kosmetolog)
                        <option value="{{ $kosmetolog->id }}" {{ old('kosmetolog_id') == $kosmetolog->id ? 'selected' : '' }}>
                            {{ $kosmetolog->fio }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Дата и время:</label>
                <input type="datetime-local" name="data_vremya" value="{{ old('data_vremya') }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>
    </div>
@endsection
