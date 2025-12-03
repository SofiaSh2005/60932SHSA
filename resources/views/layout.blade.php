<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Salon</title>
</head>
<body>


<nav class="navbar navbar-expand-sm navbar-light bg-light border-bottom">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            <i class="fa fa-spa text-primary"></i> Salon
        </a>

        <div class="navbar-nav">
            <a class="nav-link" href="/klient">Клиенты</a>
            <a class="nav-link" href="/kosmetolog">Косметологи</a>
            <a class="nav-link" href="/seans">Сеансы</a>
            <a class="nav-link" href="/usluga">Услуги</a>
            <a class="nav-link" href="/okazannaya_usluga">Оказанные услуги</a>
        </div>

        <div class="ms-3">
            @include('login')
        </div>
    </div>
</nav>

@include('error')

<main class="container py-4">
    @yield('content')
</main>

</body>
</html>
