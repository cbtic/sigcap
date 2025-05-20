<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ appName() }} | @yield('title')</title>
    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
    @yield('meta')

    @stack('before-styles')
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ mix('css/frontend.css') }}" rel="stylesheet">
    
    <style>
        .close-heading{
            position: relative;
        }

        button.close{
            background:#1C77B9!important;
            padding:0px 6px 2px 6px!important;
            -moz-border-radius: 30px 30px 30px 30px!important; /* Firefox */
            -webkit-border-radius: 30px 30px 30px 30px!important; /* Google Chrome y Safari */
            border-radius: 30px 30px 30px 30px!important; /* CSS3 (Opera 10.5 e Internet Explorer 9) */
        }

        .close{
            color:#FFFFFF!important;
            opacity:1!important;
            font-size:25px!important;

            position: absolute;
            z-index: 1000;
            display:block;
            right: 3px;
            top:3px
        }
    </style>

    <livewire:styles />
    @stack('after-styles')
</head>
<body>
    @include('includes.partials.read-only')
    @include('includes.partials.logged-in-as')

    <div id="app">
        @include('frontend.includes.nav_carrito')
        @include('includes.partials.messages')

        <main>
            @yield('content')
        </main>
    </div><!--app-->

    @stack('before-scripts')
    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/select2/dist/css/select2.min.css">
	<script src="<?php echo URL::to('/') ?>/bower_components/select2/dist/js/select2.full.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
	<script src="<?php echo URL::to('/') ?>/js/js.util.grid.js"></script>
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.es.min.js" charset="UTF-8"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker3.css" />
	
    <livewire:scripts />
    @stack('after-scripts')
</body>
</html>
