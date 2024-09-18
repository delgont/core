<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Schoolviser - Login</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.3.0/css/font-awesome.min.css') }}">
    
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    <!-- Page Level Css -->
    @yield('requiredCss')

    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />

    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Page Level Js -->
    @yield('requiredJs')
    
  </head>
  <body>
    <div class="container-scroller">
     
      <div class="container page-body-wrapper ">
        
        <div class="main-panel ">
          <div class="content-wrapper border border-light">
            @yield('content')
          </div>
          
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->

    </div>
   
  </body>
</html>