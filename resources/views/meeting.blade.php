<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Site</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('assets/css/icons.min.css') }}"  rel="stylesheet" type='text/css'>
    <style>
        .chrome-extension-banner {
            display: none !important;
        }

        #sideToolbarContainer {
            background-color: #4DC2C1 !important;
        }

        .vi {
            margin-top: 7px;
            position: absolute;
            margin-left: 6px;
            width: 15%;
        }

        .leftwatermark {
            left: 372px !important;
            top: 113px !important;
            background-position: center left !important;
            background-repeat: no-repea !important;
            background-size: contain !important;
        }

        .watermark {
            display: none !important;
            position: absolute !important;
            width: 300px !important;
            height: 120px !important;
            background-size: contain !important;
            background-repeat: no-repeat !important;
            z-index: 1 !important;
        }

        @media screen and (max-width:650px) {
            .leftwatermark {
                left: 84px !important;
                top: 260px !important;
                background-position: center left !important;
                background-repeat: no-repeat !important;
                background-size: contain !important;
            }

            .dispName {
                font-size: 16px !important;
            }

            .watermark {
                display: none !important;
                position: absolute !important;
                width: 145px !important;
                height: 88px !important;
                background-size: contain !important;
                background-repeat: no-repeat !important;
                z-index: 1 !important;
            }

            .vi {
                margin-top: 23px !important;
                margin-left: 24px !important;
                width: 54% !important;
            }
        }

        @media screen and (max-width:768px) {
            .disName {
                font-size: 32px !important;
            }
        }

        @media (min-width:652px) and (max-width:769px) {
            .leftwatermark {
                left: 218px !important;
                top: 112px !important;
                background-position: center left !important;
                background-repeat: no-repea !important;
                background-size: contain !important;
            }

            .vi {
                margin-top: 30px !important;
                margin-left: 24px !important;
                width: 19% !important;
            }

            .watermark {
                display: none !important;
                position: absolute !important;
                width: 210px !important;
                height: 100px !important;
                background-size: contain !important;
                background-repeat: no-repeat !important;
                z-index: 1 !important;
            }
        }

        .watermark__performanceStats {
            display: none;
        }

        .video-container {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            grid-gap: 10px;
        }

        #local-video,
        #remote-video {
            width: 100%;
            height: 360px;
            background-color: #fff;
            border-radius: 5px;
        }

        #local-video iframe,
        #remote-video iframe {
            border-radius: 5px;
            pointer-events:none;
        }

        #left-video-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            background-color: black;
        }

        #right-video-container {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background-color: black;
        }

        #left-video,
        #right-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        #left-video video,
        #right-video video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-10 mx-auto text-center mt-3">
                <h1 class="mb-3">Jitsi Meeting API</h1>
                <div id='joinMsg'></div>
                <div class="video-container" id="jitsi-meet">
                    <div id="local-video"></div>
                   
                </div>
               
                {{-- <div class="container mt-3 dk">
                    <div id='jitsi-meet-conf-container' style="width: 100%; height: 500px;">
                        <div class="watermark leftwatermark"
                            style="background: #474747;border-radius: 10px;box-shadow: 2px 2px 11px 4px lightgrey;">
                            <h3 class=" text-white text-center dispName my-auto mt-4"></h3>
                        </div>
                        <img class="vi" src="../backassets/images/Capture.png">
                    </div>
                </div> --}}
                <center>
                    <button id="btnCustomMic" type="button"
                        class=" btn-hover-shine btn btn-shadow btn-primary  mb-3 mt-3"><i class="mdi mdi-microphone"
                            aria-hidden="true"></i></button>
                    <button id="btnCustomCamera" type="button"
                        class=" btn-hover-shine btn btn-shadow btn-primary  mb-3 mt-3"><i class="mdi mdi-camera"
                            aria-hidden="true"></i></button>
                    <button id="btncancel" type="button"
                        class=" btn-hover-shine btn btn-shadow btn-danger  mb-3 mt-3"><i
                            class="mdi mdi-phone-hangup"></i></button>
                </center>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('assets/external_api.js') }}"></script>
    <!--<script src='https://meet.jit.si/external_api.js'></script>-->
    <script src="{{ asset('assets/meeting.js') }}"></script>
    <script>
        $(function() {
            const urlParams = new URLSearchParams(window.location.search);
            var meeting_id = "{{ $mid }}";
            if (!meeting_id) {
                swal.fire({
                    title: "Sorry!",
                    text: "meeting id is missing",
                    icon: "warning",
                    button: "OK",
                });
            }
            var dispNme = "{{ $username }}";
            if (!dispNme) {
                dispNme = "New User";
            }
            var email = "{{ $useremail }}";
            if (!email) {
                email = "email@gmail.com";
            }
            var azurlinguist = "https://avatars0.githubusercontent.com/u/3671647";
            $(".dispName").text(dispNme);
            $("#joinMsg").text("Joining...");
            BindEvent();
            StartMeeting(meeting_id, dispNme, email, azurlinguist);
        });
    </script>
</body>

</html>
