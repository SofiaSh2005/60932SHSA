@if (Auth::check())
    <div class="d-flex align-items-center">
        <span class="text-black me-3">
            <i class="fa fa-user me-1"></i>{{ Auth::user()->name }}
        </span>
        <a href="{{ url('logout') }}" class="btn btn-outline-black btn-sm">
            <i class="fa fa-sign-out me-1"></i>Выйти
        </a>
    </div>
@else
    <form method="post" action="{{ url('auth') }}" class="d-flex align-items-center" style="gap: 10px;">
        @csrf

        <div style="min-width: 200px;">
            <input type="email" name="email" value="{{ old('email') }}"
                   class="form-control form-control-sm"
                   placeholder="Email" required>
        </div>

        <div style="min-width: 200px;">
            <input type="password" name="password"
                   class="form-control form-control-sm"
                   placeholder="Пароль" required>
        </div>

        <button type="submit" class="btn btn-primary btn-sm px-3">
            <i class="fa fa-sign-in me-1"></i>Войти
        </button>
    </form>
@endif
