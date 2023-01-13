<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<!-- CSRF Token -->
    	<meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Premier Training</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>

    <body class="sb-nav-fixed">
        @include('inc.navbar')
        <!-- Page Content -->
        <div id="layoutSidenav">   
            @include('inc.sidebar')          
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid mb-3">
                @include('inc.messages')
                @yield('content')
                    </div>
                </main>
            </div>
        </div>
        <!-- Bootstrap core JavaScript -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="{{ URL::asset('js/dragdrop.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
                    <!-- Menu Toggle Script -->
                    <script>
                        $("#sidebarToggle").on("click", function(e) {
                            e.preventDefault();
                            $("body").toggleClass("sb-sidenav-toggled");
                        });
                    </script>
                    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
                    <script>
                        CKEDITOR.replace( 'article-ckeditor' );
                    </script>
</body>
</html>
