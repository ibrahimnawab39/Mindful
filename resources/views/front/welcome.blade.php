<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" theme='lightTheme'>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mindful | Welcome</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body>
    <div class="main-content welcome-page">
        <div class="row">
            <div class="col-md-6">
                <div class="left-content">
                    <div class="logo-container pt-2">
                        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="" class="img-fluid top-logo">
                    </div>
                    <div class="content-container">
                        <h3>Connecting Minds</h3>
                        <p>Mindful is a social networking application that encourages lively debates on a range of
                            topics, with an emphasis on religion and science. Users can engage in random video or text
                            chats to challenge their perspectives, promote critical thinking, and foster common
                            understanding to build a community of passionate and intellectually curious individuals.</p>
                        <a href="{{ route('front.get-started') }}" class="btn btn-block button-dark">Setup your preferences <img src="{{ asset('assets/images/svg/arrowRight.svg') }}" class=" ml-2"></a>
                        <button type="button" class="btn btn-block button-ouline-dark switch-icon-button">
                            Switch to dark mode
                            <img src="{{ asset('assets/images/svg/moon.svg') }}" class="light ml-2">
                            <img src="{{ asset('assets/images/svg/moonDark.svg') }}" class="dark ml-2">
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="right-images-slider">
                    <img src="{{ asset('assets/images/slider/01.png') }}" alt="">
                    <img src="{{ asset('assets/images/slider/01.png') }}" alt="">
                    <img src="{{ asset('assets/images/slider/01.png') }}" alt="">
                    <img src="{{ asset('assets/images/slider/01.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
