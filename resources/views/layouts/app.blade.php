<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 0; color: #222; display: flex; flex-direction: column; min-height: 100vh; }
        header, footer { background: #1f2937; color: #fff; padding: 12px 24px; }
        header { display: flex; justify-content: space-between; align-items: center; }
        header a, footer a { color: #fff; text-decoration: none; margin-left: 16px; }
        .logo { font-size: 1.25rem; font-weight: bold; margin: 0; }
        main { flex: 1; max-width: 900px; width: 100%; margin: 24px auto; padding: 0 16px; box-sizing: border-box; }
        label { display: block; margin-top: 12px; font-weight: 600; }
        input, textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        .error { color: #b91c1c; font-size: .9rem; margin: 4px 0 0; }
        .alert-success { background: #dcfce7; border: 1px solid #16a34a; padding: 10px 14px; border-radius: 6px; margin-bottom: 16px; }
        .alert-danger { background: #fee2e2; border: 1px solid #b91c1c; padding: 10px 14px; border-radius: 6px; margin-bottom: 16px; }
        button { margin-top: 16px; padding: 10px 20px; cursor: pointer; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: top; }
        th { background: #f3f4f6; }
        .pagination { display: flex; gap: 6px; list-style: none; padding: 0; }
        .pagination a, .pagination span { padding: 4px 10px; border: 1px solid #ccc; text-decoration: none; color: inherit; display: inline-block; }
        .pagination .active span { background: #1f2937; color: #fff; }
        .badge { background: #e5e7eb; padding: 2px 8px; border-radius: 10px; font-size: .8rem; margin-right: 4px; }
        .card { border: 1px solid #ddd; border-radius: 6px; padding: 12px 16px; margin-bottom: 12px; }
        .btn-danger { background: #b91c1c; color: #fff; border: 0; }
        select { padding: 8px; }
    </style>
    @stack('styles')
</head>
<body>
    @include('partials.header')

    <main>
        @include('partials.flash')
        @yield('content')
    </main>

    @include('partials.footer')
    @stack('scripts')
</body>
</html>