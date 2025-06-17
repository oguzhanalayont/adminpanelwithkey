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

            {{-- Panel Yönlendirmesi --}}
                        @auth
                            @php
                $user = auth()->user();
                $isAdmin = $user->is_admin;
                $isManager = $user->is_manager ?? false;

                // Admin Panel butonu yönlendirmesi
                $panelRoute = $isAdmin
                    ? route('admin.dashboard')
                    : ($isManager
                        ? route('manager.dashboard')
                        : route('dashboard'));

                // Products yönlendirmesi
                $productRoute = $isAdmin
                    ? route('admin.products.index')
                    : route('products.index');
            @endphp


                <a class="navbar-brand" href="{{ $panelRoute }}">Admin Panel</a>
            @else
                <a class="navbar-brand" href="/">Admin Panel</a>
            @endauth

            {{-- Butonlar --}}
            <div class="d-flex">
                @auth
                    {{-- Products butonu (herkes görür, ama yönlendirme farklı) --}}
                    <a href="{{ $productRoute }}" class="btn btn-outline-dark me-2">Products</a>

                    {{-- My Licenses (admin olmayan herkes için) --}}
                    @if(!$isAdmin)
                        <a href="{{ route('licenses.index') }}" class="btn btn-outline-success me-2">My Licenses</a>
                    @endif


                    {{-- Reports (sadece admin) --}}
                    @if($isAdmin)
                        <a href="{{ route('admin.reports') }}" class="btn btn-outline-primary me-2">Reports</a>

                        {{-- Yetkilendirme (sadece admin) --}}
                        <a href="{{ route('admin.authorize') }}" class="btn btn-outline-warning me-2">Yetkilendirme</a>
                    @endif

                    {{-- Kullanım Yetkisi (sadece manager) --}}
                    @if($isManager)
                        <a href="{{ route('manager.permissions') }}" class="btn btn-outline-info me-2">Kullanım Yetkisi</a>
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
