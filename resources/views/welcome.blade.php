<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full font-sans antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ \Laravel\Nova\Nova::name() }}</title>

    <!-- Fonts -->
    <link href="{{ mix('google-font-nunito.css', 'vendor/novaweb') }}" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('app.css', 'vendor/nova') }}">

    <!-- Tool Styles -->
    @foreach(\Laravel\Nova\Nova::availableStyles(request()) as $name => $path)
        <link rel="stylesheet" href="/nova-api/styles/{{ $name }}">
    @endforeach

<!-- Custom Meta Data -->
    @include('nova::partials.meta')

</head>
<body class="bg-40 text-black">
<div id="novaweb">
    <div class="flex flex-col h-screen">
        @if (Route::has('login'))
            <div class="ml-auto px-4 py-4">
                @auth
                    <a class="px-8 py-2 rounded-lg font-bold text-black no-underline hover:bg-60" href="{{ url('admin') }}">Admin</a>
                    <a
                        class="ml-2 px-8 py-2 rounded-lg font-bold text-black no-underline hover:bg-60"
                        onclick="document.getElementById('logout-form').submit();"
                    >Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                @else
                    <a class="px-8 py-2 rounded-lg font-bold text-black no-underline hover:bg-60" href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a class="px-8 py-2 rounded-lg font-bold text-black no-underline hover:bg-60" href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif
        <div class="flex flex-grow">
            <div class="mx-auto my-auto">
                <span style="font-size: 10em;">Laravel</span>
            </div>
        </div>
    </div>
</div>

<script>
    window.config = @json(\Laravel\Nova\Nova::jsonVariables(request()));
</script>

<!-- Scripts -->
<script src="{{ mix('manifest.js', 'vendor/nova') }}"></script>
<script src="{{ mix('vendor.js', 'vendor/nova') }}"></script>
<script src="{{ mix('app.js', 'vendor/nova') }}"></script>

<!-- Build Nova Instance -->
<script>
    window.NovaWeb = new CreateNovaWeb(config)
</script>

<script>
    NovaWeb.liftOff()
</script>

</body>
</html>
