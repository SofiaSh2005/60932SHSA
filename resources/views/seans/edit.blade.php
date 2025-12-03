@extends('layout')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Редактировать сеанс</h1>

        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('seans.update', $seans->id) }}" method="POST" class="border p-4 rounded bg-light">
            @csrf

            <div class="mb-3">
                <label class="form-label">Клиент:</label>
                <select name="klient_id" class="form-control">
                    @foreach($klients as $klient)
                        <option value="{{ $klient->id }}" {{ $seans->klient_id == $klient->id ? 'selected' : '' }}>
                            {{ $klient->fio }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Косметолог:</label>
                <select name="kosmetolog_id" class="form-control">
                    @foreach($kosmetologs as $kosmetolog)
                        <option value="{{ $kosmetolog->id }}" {{ $seans->kosmetolog_id == $kosmetolog->id ? 'selected' : '' }}>
                            {{ $kosmetolog->fio }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Дата и время:</label>
                <input type="datetime-local" name="data_vremya" value="{{ $seans->data_vremya }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
@endsection
