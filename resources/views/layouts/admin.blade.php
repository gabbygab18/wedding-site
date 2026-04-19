<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>💍</text></svg>">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', 'Admin') — Wedding Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/scss/admin.scss', 'resources/js/admin.js'])
    {{-- <link rel="stylesheet" href="{{ asset('css/admin.css') }}"> --}}
    @stack('styles')
</head>

<body class="admin-body">

    <div class="admin-layout">

        {{-- Sidebar --}}
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <span class="brand-icon">✦</span>
                <span class="brand-text">Wedding Admin</span>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">⊞</span> Dashboard
                </a>
                <a href="{{ route('admin.wedding.edit') }}"
                    class="nav-item {{ request()->routeIs('admin.wedding.*') ? 'active' : '' }}">
                    <span class="nav-icon">✎</span> Wedding Details
                </a>
                <a href="{{ route('admin.photos.index') }}"
                    class="nav-item {{ request()->routeIs('admin.photos.*') ? 'active' : '' }}">
                    <span class="nav-icon">⊡</span> Photos
                </a>
                <a href="{{ route('admin.entourage.index') }}"
                    class="nav-item {{ request()->routeIs('admin.entourage.*') ? 'active' : '' }}">
                    <span class="nav-icon">♡</span> Entourage
                </a>
                <a href="{{ route('admin.rsvp.index') }}"
                    class="nav-item {{ request()->routeIs('admin.rsvp.*') ? 'active' : '' }}">
                    <span class="nav-icon">✉</span> RSVPs
                    @php $pending = \App\Models\Rsvp::where('notified', false)->count(); @endphp
                    @if ($pending > 0)
                        <span class="nav-badge">{{ $pending }}</span>
                    @endif
                </a>
            </nav>
            <div class="sidebar-footer">
                <a href="{{ route('invitation') }}" target="_blank" class="preview-btn">Preview Site →</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <main class="admin-main">
            <div class="admin-topbar">
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="admin-content">
                @yield('content')
            </div>
        </main>

    </div>

    {{-- <script src="{{ asset('js/admin.js') }}"></script> --}}
    @stack('scripts')
</body>

</html>
