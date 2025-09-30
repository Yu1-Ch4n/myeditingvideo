<!doctype html>
<html lang="en">

<head>
    @include('layouts.frontend.head')
    @include('layouts.frontend.style')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-screen bg-gray-100">
        @include('layouts.frontend.navbar')

        @yield('content')

        <hr class="mt-5 mb-0 text-secondary">

        @include('layouts.frontend.footer')

        @include('layouts.frontend.script')
    </div>
</body>

</html>
