@extends('layouts.app')
@section('pagename', 'Video')
@section('styles')
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
        #remote-video,
        #localVideo,
        #remoteVideo {
            width: 100%;
            height: 360px;
            background-color: #000;
            border-radius: 5px;
            object-fit: cover;
        }

        #local-video iframe,
        #remote-video iframe {
            border-radius: 5px;
            pointer-events: none;
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

        .skip-video .myVideo .videoActions {
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
@endsection
@section('content')
    <section class="meeting-section">
        <div class="row">
            <div class="col-md-8">
                <a class="btn btn-dark rounded Goback-Btn" href="{{ route('front.main') }}">Go Back to Dashboard</a>
                <div class="mt-4 myVideo connected-video">
                    <div id="local-video"></div>
                    <div class='videoActions'>
                        <button class='actionIcon' id="btnCustomMic">
                            <i class="mdi mdi-microphone" aria-hidden="true"></i>
                        </button>
                        <button class='actionIcon' id="btnCustomCamera">
                            <i class="mdi mdi-video" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="justify-content-center justify-content-md-start mt-4 row skip-video d-none">
                    <div class="col-md-6 col-6 pr-2 myVideo">
                        <video id="localVideo" autoplay muted></video>
                        <div class='videoActions'>
                            <button class='actionIcon' id="skip_mic">
                                <i class="mdi mdi-microphone" aria-hidden="true"></i>
                            </button>
                            <button class='actionIcon' id="skip_video">
                                <i class="mdi mdi-video" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 col-6 pl-2 oponentVideo">
                        <video id="remoteVideo" autoplay muted></video>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <button class="btn skip-btn rounded btn-small" type="button" id="skip_call"><i
                            class="mdi mdi-24px mdi-reload"></i> Skip</button>
                </div>
                <div class='row mt-4'>
                    <div class='col-md-7'>
                        <p>Search for interests <span class='text-muted'> (Optional)</span></p>
                        <input type='text' class='form--control w-100'>
                    </div>
                    <div class='col-md-7 mt-4'>
                        <div class='btn btn-small rounded-pill btn-light-dark '>
                            Joining interest-based groups <span onClick='(()=>{alert("Action Call..")})()'
                                class='px-2'>&times;</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/external_api.js') }}"></script>
    <script src="{{ asset('assets/js/meeting.js') }}"></script>
    <script>
        var mic = true;
        var video = true;
        var dispNme = "{{ $user->username }}";
        var meeting_id = "585689757";
        $("#skip_mic").on("click", function() {
            var icon = $(this).find(".mdi");
            if (icon.hasClass("mdi-microphone")) {
                icon.addClass("mdi-microphone-off").removeClass("mdi-microphone");
                mic = false;
                skiping_video(video, mic);
            } else {
                icon.removeClass("mdi-microphone-off").addClass("mdi-microphone");
                mic = true;
                skiping_video(video, mic);
            }
        });
        $("#skip_video").on("click", function() {
            var icon = $(this).find(".mdi");
            if (icon.hasClass("mdi-video")) {
                icon.addClass("mdi-video-off").removeClass("mdi-video");
                video = false;
                skiping_video(video, mic);
            } else {
                icon.removeClass("mdi-video-off").addClass("mdi-video");
                video = true;
                skiping_video(video, mic);
            }
        });
        $("#skip_call").on("click", function() {
            var icon = $(this).find(".mdi");
            icon.addClass("mdi-spin");
            skip_query();
        });
        $(function() {
            skip_query();
        });

        function skiping_video(video, audio) {
            $("#local-video").empty();
            $(".connected-video").addClass("d-none");
            $(".skip-video").removeClass("d-none");
            const configuration = {
                iceServers: [{
                    urls: 'stun:stun.l.google.com:19302'
                }]
            };
            const peerConnection = new RTCPeerConnection(configuration);
            navigator.mediaDevices.getUserMedia({
                    video: video,
                    audio: audio
                })
                .then(stream => {
                    const localVideo = document.querySelector('#localVideo');
                    localVideo.srcObject = stream;
                    stream.getTracks().forEach(track => peerConnection.addTrack(track, stream));
                })
                .catch(error => console.log(error));
        }

        function skip_query() {
            var icon = $("#skip_call").find(".mdi");
            skiping_video(video, mic);
            $.ajax({
                url: "{{ route('front.skipping') }}",
                type: "GET",
                data: {},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "JSON",
                success: function(result) {
                    if (result["res"] == "success") {
                        icon.removeClass("mdi-spin");
                        BindEvent();
                        StartMeeting(result["room"]["room_name"], dispNme, video, mic);
                    }
                }
            })
        }
    </script>
@endsection
