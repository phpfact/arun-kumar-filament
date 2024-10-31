<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>MDI - Music Distribution India | @yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Musize - Music Band & Musician Website" />
  <meta name="author" content="jellythemes" />
  <link rel="icon" href="{{ asset('assets\images\resources\logo\favicon.png')}}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animate.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/all.min.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick-theme.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jplayer.blue.monday.min.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/swipebox.min.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css')}}" />
  <!-- Style Css -->
  <link rel="stylesheet" href="{{ asset('revolution/css/revolution.all.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/css/revolution/revolution3.css')}}" />
  <!-- Modernizr -->
  <script src="{{ asset('assets/js/revolution/vendor/modernizr.js')}}"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@200..900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Michroma&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Bakbak+One&display=swap" rel="stylesheet">
  @yield('style')
</head>

<body class="dark-version">
  <div class="preloader">
    <div class="loader-1 center"><span></span></div>
  </div>

  <div id="jquery_jplayer_2" class="jp-jplayer"></div>

  <div class="wrapper">
    @include('include.header')

    @yield('content')

    @include('include.footer')

  </div>
  <!--wrapper end-->

  <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{ asset('assets/js/jquery-migrate-1.4.1.min.js')}}"></script>

  <!-- Vendor -->
  <script src="{{ asset('assets/js/revolution/vendor.js')}}"></script>

  <!-- Revolution Slider -->
  <script src="{{ asset('revolution/js/jquery.themepunch.tools.min.js?rev=5.0')}}"></script>
  <script src="{{ asset('revolution/js/jquery.themepunch.revolution.min.js?rev=5.0')}}"></script>
  <script src="{{ asset('revolution/js/extensions/revolution.extensions.all.js')}}"></script>

  <!-- Custom scripts -->
  <script src="{{ asset('assets/js/revolution/main.js')}}"></script>

  <script src="{{ asset('assets/js/jquery.jplayer.min.js')}}"></script>
  <script src="{{ asset('assets/js/jplayer.playlist.min.js')}}"></script>
  <script src="{{ asset('assets/js/popper.js')}}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('assets/js/plugin/slick.min.js')}}"></script>
  <script src="{{ asset('assets/js/plugin/jquery.swipebox.min.js')}}"></script>
  <script src="{{ asset('assets/js/wow.min.js')}}"></script>
  <script src="{{ asset('assets/js/playlist.js')}}"></script>
  <script src="{{ asset('assets/js/script.js')}}"></script>

  @yield('script')
</body>

</html>
