<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en" class="">
<!--<![endif]-->

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <title>@yield('title')</title>

    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Base URL -->
    <meta name="base-url" content="{{ url('/') }}" />

    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.3.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/basic.css') }}">

    <!-- Page Level Css -->
    @yield('requiredCss')

    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />

    <script>
        // Immediately check and apply the dark mode before the page content is rendered
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <script src="{{ asset('js/basic.js') }}" defer></script>
    <!-- Page Level Js -->
    @yield('requiredJs')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body style="background-color: rgb(241,250,248)">
    <button onclick="topFunction()" id="goToTopBtn" title="Go to top"><i class="fa fa-chevron-up" aria-hidden="true"></i></button>

    <script>
        var mybutton = document.getElementById("goToTopBtn");
        window.onscroll = function() {scrollFunction()};
        function scrollFunction() {
            if (document.body.scrollTop > 1000 || document.documentElement.scrollTop > 1000) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
        function topFunction() {
            window.scrollTo({ top: 0, behavior: 'smooth' })
            document.documentElement.scrollTo({ top: 0, behavior: 'smooth' })
        }

        // Function to toggle dark mode and save the preference
        function toggleDarkMode() {
            document.querySelector('html').classList.toggle('dark');
            // Save the current mode in localStorage
            if (document.querySelector('html').classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        }

        // Apply the saved theme when the page loads
        document.addEventListener("DOMContentLoaded", () => {
            // Check if 'theme' is stored in localStorage
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.querySelector('html').classList.add('dark');
                const tables = document.querySelectorAll('table');
                tables.forEach(table => {
                    if (document.documentElement.classList.contains('dark')) {
                        table.classList.add('table-dark');
                    } else {
                        table.classList.remove('table-dark');
                    }
                });
            }

            // Toggle the dark mode when the button is clicked
            document.querySelector('#mode').addEventListener('click', toggleDarkMode);
        });


    </script>

    <div id="wrapper">

        <div id="mode" class="d-none">
            <div class="dark">
                <svg aria-hidden="true" viewBox="0 0 512 512">
                    <title>lightmode</title>
                    <path fill="currentColor" d="M256 160c-52.9 0-96 43.1-96 96s43.1 96 96 96 96-43.1 96-96-43.1-96-96-96zm246.4 80.5l-94.7-47.3 33.5-100.4c4.5-13.6-8.4-26.5-21.9-21.9l-100.4 33.5-47.4-94.8c-6.4-12.8-24.6-12.8-31 0l-47.3 94.7L92.7 70.8c-13.6-4.5-26.5 8.4-21.9 21.9l33.5 100.4-94.7 47.4c-12.8 6.4-12.8 24.6 0 31l94.7 47.3-33.5 100.5c-4.5 13.6 8.4 26.5 21.9 21.9l100.4-33.5 47.3 94.7c6.4 12.8 24.6 12.8 31 0l47.3-94.7 100.4 33.5c13.6 4.5 26.5-8.4 21.9-21.9l-33.5-100.4 94.7-47.3c13-6.5 13-24.7.2-31.1zm-155.9 106c-49.9 49.9-131.1 49.9-181 0-49.9-49.9-49.9-131.1 0-181 49.9-49.9 131.1-49.9 181 0 49.9 49.9 49.9 131.1 0 181z"></path>
                </svg>
            </div>
            <div class="light">
                <svg aria-hidden="true" viewBox="0 0 512 512">
                    <title>darkmode</title>
                    <path fill="currentColor" d="M283.211 512c78.962 0 151.079-35.925 198.857-94.792 7.068-8.708-.639-21.43-11.562-19.35-124.203 23.654-238.262-71.576-238.262-196.954 0-72.222 38.662-138.635 101.498-174.394 9.686-5.512 7.25-20.197-3.756-22.23A258.156 258.156 0 0 0 283.211 0c-141.309 0-256 114.511-256 256 0 141.309 114.511 256 256 256z"></path>
                </svg>
            </div>
        </div>

        <section id="topBar" class="topbar-section bg-primary">
           <div class="container">
            <div class="row py-2">
                <div class="col-lg-3">
                  <img src="{{ asset(config('schoolviser.logo', 'images/logo.svg')) }}" alt="logo" class="img-fluid" />
                </div>
                <div class="col-lg-7">
                    <nav class="nav justify-content-end">
                        <a class="nav-link m-0 p-0" href="#">Link</a>
                    </nav>
                    
                </div>
                <div class="col-lg-2 text-end">
                    <a class="nav-link cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#userOffCanvas" aria-controls="accountQuickLinksOffCanvas">
                    <div class="nav-profile-text text-capitalize px-3 d-inline">{{ auth()->user()->name }} </div>
                    <img src="{{ asset(auth()->user()->avator ?? 'images/avator.png') }}" alt="" class="rounded-circle d-inline" style="width: 35px;">
                    </a>
                </div>
            </div>
           </div>
        </section>

        <section>
            <div class="container-xl container-lg">
                <div class="row">
                 <div class="col-md-3" style="padding-top: 25px;">
                    @php
                        $modules = config('schoolviser.modules', []);
                        $modulesCount = count($modules); // Get the number of modules
                    @endphp

                    @switch(true)
                        @case($modulesCount > 1)
                            <nav class="docs-sidebar mb-5" data-spy="affix" data-offset-top="300" data-offset-bottom="200" role="navigation">
                                <ul class="nav">
                                    <li><a href="{{ route('home') }}">Dashboard</a></li>
                                    
                                    @foreach ($modules as $module)
                                        @includeIf($module.'::includes.navitems.main', ['some' => 'data'])
                                    @endforeach
                                    
                                    <li class="">
                                    <a href="#contentId" data-bs-toggle="collapse" aria-expanded="false" aria-controls="contentId">Reports and Analyticals</a>
                                        <ul class="nav collapse" id="contentId">
                                            <li><a href="#line7_1">General Options</a></li>
                                            <li><a href="#line7_2">Style Options</a></li>
                                            <li><a href="#line7_3">Header Options</a></li>
                                            <li><a href="#line7_4">Font Options</a></li>
                                            <li><a href="#line7_5">Slider Options</a></li>
                                            <li><a href="#line7_6">Page Options</a></li>
                                            <li><a href="#line7_7">Import & Export</a></li>
                                        </ul>
                                    </li>
                                
                                    <li><a href="{{ route('settings') }}" class="">Settings</a></li>
                                    <li class="w-100">
                                        <a class="" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <span class="">{{ __('Logout') }}</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </nav >
                            @break

                        @case($modulesCount === 1)
                            @includeIf($modules['0'].'::includes.sidebar', ['some' => 'data'])
                            @break

                        @case($modulesCount === 0)
                            {{-- Handle the case where the modules array is empty --}}
                            @break

                        @default
                            {{-- Handle any other case --}}
                    @endswitch
                    <div class="below-sidebar">
                        @yield('below-sidebar')
                    </div>
                 </div>
                 <div class="col-md-9" style="padding-top: 30px;">
                   <div class="row p-0">
                     <div class="col-lg-6">
                        <h2 class="text-capitalize p-0" style="font-weight: 500;">@yield('module-page-heading')</h2>
                     </div>
                     <div class="col-lg-6 text-lg-end module-links module-quick-links">
                       @yield('module-links')
                     </div>
                     <div class="col-lg-12">
                        <small>@yield('module-page-description')</small>
                     </div>
                   </div>
                   <div class="content"  id="content">@yield('content')</div>
                 </div>
                </div>
             </div>
        </section>

       
        <!-- // end container -->

    </div>
    <!-- end wrapper -->

    <footer>
        @yield('footer')
    </footer>

@include('admin.includes.offcanvas.user')


</body>

</html>
