<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">

            {{-- Admin Panel logosu yönlendirme --}}
            @auth
                @php
                    $isAdmin = auth()->user()->is_admin;
                    $panelRoute = $isAdmin ? route('admin.dashboard') : route('dashboard');
                @endphp
                <a class="navbar-brand" href="{{ $panelRoute }}">Admin Panel</a>
            @else
                <a class="navbar-brand" href="/">Admin Panel</a>
            @endauth

            <div class="d-flex">
                @auth
                    @php
                        $productRoute = $isAdmin ? route('admin.products.index') : route('products.index');
                    @endphp

                    {{-- Products --}}
                    <a href="{{ $productRoute }}" class="btn btn-outline-dark me-2">Products</a>

                    {{-- My Licenses (sadece kullanıcılar için) --}}
                    @if(!$isAdmin)
                        <a href="{{ route('licenses.index') }}" class="btn btn-outline-success me-2">My Licenses</a>
                    @endif

                    {{-- Raporlar (sadece admin için) --}}
                    @if($isAdmin)
                        <a href="{{ route('admin.reports') }}" class="btn btn-outline-primary me-2">Reports</a>
                    @endif

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger me-2">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>
</body>
</html>
