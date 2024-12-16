<!doctype html>
<html lang="en">

<head>
    @include('admin.adminlayouts.header')
    @yield('css')
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('admin.adminlayouts.sidebar')
        @yield('content')
    </div>
    @include('admin.adminlayouts.footer')
    @yield('script')
</body>

</html>
