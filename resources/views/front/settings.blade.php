<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" theme='lightTheme'>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mindful | Get Started</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/favicon/apple-touch-icon.png')}} ">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png')}} ">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png')}} ">
    <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest')}} ">
    <link rel="mask-icon" href="{{ asset('assets/favicon/safari-pinned-tab.svg')}} " color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#f1f1f1">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>
<body>
    <div class="main-wrapper" style="max-width:100%">
        <div class="getstartedWizard">
            <section class="signup-step-container">
                <div class="wizard">
                    <div class="wizard-inner">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active "  data-count="1">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab"
                                    aria-expanded="true"><span class="round-tab">1 </span>
                                    <p>Alias</p>
                                </a>
                            </li>
                            <li role="presentation" class="disabled"  data-count="2">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab"
                                    aria-expanded="false"><span class="round-tab">2</span>
                                    <p>Belief</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <form role="form" action="{{route('front.get-started-store')}}" method="post" class="login-box">
                        @csrf
                        <div class="tab-content" id="main_form">
                            <div class="tab-pane active" role="tabpanel" id="step1">
                                <h2 class="">If you like to use a nickname for yourself, what would that be?
                                </h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input class="form-control" type="text" value='' name="nickname"
                                                placeholder="Tell us your nickname">
                                        </div>
                                    </div>
                                </div>
                                <ul class="list-inline">
                                    <li class="pull-right"><button type="button"
                                            class="default-btn btn btn-dark next-step  ">Next</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step2">
                                <h2>Which thought / belief system do you follow?</h2>
                                <div class="row flex-column">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="radio" id="Christianity" value="Christianity" name="religion" />
                                            <label for="Christianity">Christianity</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="radio" id="Islam" value="Islam" name="religion" />
                                            <label for="Islam">Islam</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="radio" id="Atheism" value="Atheism" name="religion" />
                                            <label for="Atheism">Atheism</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="radio" id="Other" value="Other" name="religion" />
                                            <label for="Other">Other</label>
                                        </div>
                                    </div>
                                </div>
                                <ul class="action">
                                    <li>
                                        <button type="button" class="default-btn btn btn-light-dark prev-step">Go
                                            Back</button>
                                    </li>
                                    <li class='d-flex' style='gap:10px;'>
                                        <button type="button"
                                            class="default-btn next-step  btn btn-transparent skip-btn">Cancel</button>
                                        <button type="submit" class="default-btn  btn btn-dark next-step">Save</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
