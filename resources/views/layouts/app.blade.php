<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The Law Society of Singapore') }}</title>

    <!-- Scripts -->
<title>Law Society</title>	
	
		<link href="{{ asset('css/plugin.min.css') }}" rel="stylesheet" />
		<link href="{{ asset('css/main.min.css') }}" rel="stylesheet" />
</head>
<body>
    
        <div id="toppage" class="mm-page"> 			
			
            @include('inc.header')  
            
            @yield('content')<!-- //main -->
            
        </div><!-- //page -->
        
        @include('inc.footer')<!-- //footer container --> 
        
		<a href="#toppage" class="smoothscroll gotop fas fa-chevron-up">Go Top</a>
      
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/plugin.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        
    </body>
</html>
