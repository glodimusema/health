<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{csrf_token() }} ">
    <script>window.Laravel={ csrfToken:'{{csrf_token() }}'} </script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <title>HOPITAL</title>

    {{-- debit --}}
    <meta name="author" content="HOPITAL">
    <meta name="description" content="Est une application de gestion de l'hôpital">
    {{-- <meta name="google-site-verification" content="jclbuIuA4j04YTsdGNxcSY890tNcQUnI4A4INwSPntQ" /> --}}

    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">


    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('/logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    
</head>
<body>

    @if(!isset(auth()->user()->email))
	<script type="text/javascript">
	  window.location="{{url('/login')}}" 
	</script>
	
	@endif

    {{-- {{ var_dump($rules) }} --}}
    <div id="app">
        <App />
    </div>

    <script type="text/javascript">
            window.school = {!! json_encode([
                'baseURL' => url('/'),
                'apiBaseURL' => url('/api'),
                'user' => auth()->user(),
                'roless' =>  $roless,
            ]) !!}
    </script>


    <script src="{{mix('/js/app.js')}}"></script>

    {{-- PWA scripts --}}
    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function (reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
    {{-- Fin PWA --}}
    
</body>
</html>