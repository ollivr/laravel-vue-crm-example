<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="//stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <script>
        window.Laravel = {!! json_encode([
           'csrfToken' => csrf_token(),
           'oauth' => [
               'clientId' => config('auth.passport_grant_client_id'),
               'clientSecret' => config('auth.passport_client_secret'),
           ]
       ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <main>
            <div id="wrapper">
                <main-block></main-block>
            </div>
        </main>
        <v-dialog/>

        <modals-container />
    </div>
</body>
</html>
