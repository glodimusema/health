
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- mes scripts -->
    <link rel="shortcut icon" href="./images/logo.png">
    <!-- fin mes scripts -->
    <title>Dashboard | Hopital</title>
    
</head>
<body>


	@if(isset(auth()->user()->email))
	<script type="text/javascript">
	  window.location="{{url('/login')}}" 
	</script>
	@endif

	<div id="app">
	    <app-init></app-init>
	</div>

	<script type="text/javascript">
	    window.school = {!! json_encode([
                'baseURL' => url('/'),
                'apiBaseURL' => url('/api'),
                'user' => auth()->user(),
                'roless' =>  $roless,
            ]) !!}
	</script>

	<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>