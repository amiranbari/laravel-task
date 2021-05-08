<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('tasks/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tasks/css/styles.css') }}">
    <title>Tasks</title>
</head>
<body>
    <div class="container center margin-top-50">
        @yield('contents')
    </div>
    <script src="{{ asset('tasks/js/jquery.min.js') }}"></script>
    <script src="{{ asset('tasks/js/popper.min.js') }}"></script>
    <script src="{{ asset('tasks/js/bootstrap.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
