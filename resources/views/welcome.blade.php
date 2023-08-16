<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
</head>


<body style="background-color: rgba(0, 255, 170, 0.438)">

    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
        <div class="container">
            
            <a class="navbar-brand" href="{{ url('/') }}" style="color: chartreuse">
                <img src="http://172.16.174.201:81/test_navision/test_mpdi/assets/img/ebm_icon.png"> MARCELA PHARMA DISTRIBUTION INC.
            </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    @if (Route::has('login'))
                        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                            @auth
                                <a href="{{ url('/home') }}" class="nav-link">Home</a>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}"> <i class="fas fa-sign-in-alt" style="color: chartreuse"></i> Log in</a>
                                </li>
                                {{-- <li class="nav-item">
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                                @endif
                                </li> --}}
                            @endauth
                        </div>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>


