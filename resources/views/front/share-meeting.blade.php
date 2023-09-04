@extends('layouts.app')
@section('pagename', 'Share Meeting')
@php
    $interest_count = 0;
    $interests = explode(',', $user->interest);
@endphp
@section('styles')
    <link href="{{ asset('assets/css/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-flat.css" />
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

        .chat-box .card-body {
            padding-right: 0;
        }

        #chat-messages {
            list-style: none;
            margin: 0;
            padding: 0;
            height: 420px;
            position: relative;
            margin-bottom: 40px;
            padding-right: 20px;
        }

        #chat-messages li:last-child {
            margin-bottom: 20px
        }

        .watermaker-logo {
            position: absolute;
            background: #000;
            padding: 10px;
            width: 166px;
            left: 0%;
            border-radius: 5px;
        }

        @media screen and (max-width:786px) {
            .watermaker-logo {
                width: 125px;
                height: 65px;
                left: 0%;
                display: flex;
                align-items: center;
                justify-content: center;
                top: 3px;
            }

            #local-video,
            #remote-video,
            #localVideo,
            #remoteVideo {
                height: 185px;
            }
        }

        main.py-4 {
            padding: 0 !important;
        }

        .jssocials-share-link {
            border-radius: 10%;
        }
    </style>
@endsection
@section('content')
    <section class="meeting-section">
        <div class="row">
            <div class="col-lg-8 col-md-7 videolefttt">
                <div class="row mx-0 justify-content-between">
                    <a class="btn btn-dark rounded gotodashboard Goback-Btn" href="{{ route('front.main') }}"
                        style="width:fit-content">
                        <img src="{{ asset('assets/images/svg/arrowleft.svg') }}" class='showLight'>
                        <img src="{{ asset('assets/images/svg/arrowleftDark.svg') }}" class='showdark'>
                        Go Back to Dashboard
                    </a>
                    <div id="video-message">
                    </div>
                </div>
                <div class="  myVideo connected-video">
                    <div class="watermaker-logo">
                        <img src="{{ asset('assets/images/logo/logo-dark.png') }}" class="img-fluid" />
                    </div>
                    <div id="local-video"></div>
                    <div class='videoActions'>
                        <button class='actionIcon' id="btnCustomMic">
                            <i class="mdi mdi-microphone" aria-hidden="true"></i>
                        </button>
                        <button class='actionIcon' id="btnCustomCamera">
                            <i class="mdi mdi-video" aria-hidden="true"></i>
                        </button>
                        @if ($user->ismoderator == 1)
                            <button class='actionIcon' id="btnHangup">
                                <i class="mdi mdi-phone-hangup" aria-hidden="true"></i>
                            </button>
                        @endif
                    </div>
                </div>
                <div class="justify-content-center justify-content-md-start row skip-video d-none">
                    <div class="col-md-6   pr-md-2 myVideo">
                        <video id="localVideo" autoplay muted></video>
                        <div class='videoActions'>
                            <button class='actionIcon' id="skip_mic">
                                <i class="mdi mdi-microphone" aria-hidden="true"></i>
                            </button>
                            <button class='actionIcon' id="skip_video">
                                <i class="mdi mdi-video" aria-hidden="true"></i>
                            </button>
                            <button class='actionIcon' id="btnHangup">
                                <i class="mdi mdi-video" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6  pl-md-2 oponentVideo">
                        <video id="remoteVideo" autoplay muted></video>
                    </div>
                </div>
                <div class=' align-items-center row'>
                    <div class='col-md-7  '>
                        <div id="share"></div>
                        {{-- <div class="form-group ijosc">
                            <p>Search for interests <span class='text-muted'> (Optional)</span></p>
                            <input type='text' class='form--control w-100' id="intrest-input">
                        </div>
                        <div class=" " id="multiple-intrest">
                            @if (!empty($interests) && !empty($user->interest))
                                @foreach ($interests as $interest)
                                    <div
                                        class='btn btn-small rounded-pill btn-light-dark interest-{{ $interest_count }} mb-1 mr-1'>
                                        {{ $interest }} <span
                                            onClick="remove_intrest({{ $interest_count }},'{{ $interest }}')"
                                            class="px-2">&times;</span>
                                    </div>
                                    @php
                                        $interest_count = count($interests) - 1;
                                    @endphp
                                @endforeach
                            @endif
                        </div> --}}
                    </div>
                    {{-- <div class='col-md-5 '>
                        <div class="d-flex justify-content-end">
                            <button class="btn skip-video-btn rounded btn-small" type="button" id="skip_call"><i
                                    class="mdi mdi-24px mdi-reload"></i> Skip</button>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="col-lg-4 col-md-5 pt-3 videochattright">
                <div class=" chat-box card h-100">
                    <div class="chat-header card-header ">
                        <h6 class=" ">Live Chat</h6>
                    </div>
                    <div class="card-body chat-body">
                        <div class="oppentent-detail"></div>
                        <ul id="chat-messages" class="chat-conversation-box">
                        </ul>
                    </div>
                    <div class="card-footer  chat-footer">
                        <div class="chatbotbox" style="display:none">
                            <ul>
                            </ul>
                            <form id="chat-bot">
                                <div class="chat-input-group">
                                    <textarea id="messageInput" class="chat-input" name="botmessage" placeholder="Type your message"></textarea>
                                    <button type="submit" class="chat-btn ssesxa">
                                        <img src="{{ asset('assets/images/svg/send_msg.svg') }}">
                                    </button>
                                    <button disabled="disabled" type="button" class="chat-btn fa-spin fa fa-spinner"
                                        style="display:none">
                                    </button>
                                </div>
                            </form>
                        </div>
                        <form id="chat-from">
                            <div class="chat-input-group nnasnejca">
                                <img src="{{ asset('assets/images/icons/chatbot.png') }}" class="aichat"
                                    style="display:none">
                                <span class="ai-badge">AI Prompt</span>
                                <button class="closeGpt" type="button"><i class="fa-regular fa-keyboard"></i></button>
                                <input class="chat-input sfcraerffadferfadwedascdfvrwascfrgwasd"
                                    placeholder="Type '/gpt' followed by your question. Try it now!" type="text"
                                    name="message">
                                <button class="chat-btn">
                                    <img src="{{ asset('assets/images/svg/send_msg.svg') }}">
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/external_api.js') }}"></script>
    <script src="{{ asset('assets/js/meeting.js') }}"></script>
    <script src="{{ asset('assets/js/perfect-scrollbar.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>
    <script>
        var mic = true;
        var room = "{{ $meeting_id }}";
        var myid = "{{ $user->id }}";
        var otherid = 0;
        var video = true;
        var dispNme = "{{ $user->username }}";
        var meeting_id = "585689757";
        $(function() {
            skip_query();
        });

        function skip_query() {
            $("#chat-messages").html("");
            BindEvent();
            StartMeeting(room, dispNme, video, mic);
            chat_list(room);
        }

        function chat_list(room) {
            socket.on("connection");
            socket.emit('joinRoom', room);
            socket.on('sendChatToClient', (message) => {
                const messageLi = document.createElement('li');
                // Add the message content to the list item
                messageLi.innerHTML = message.content;
                console.log(message.senderID);
                // Determine if the message was sent by the current user or another user
                if (message.senderID === user_id) {
                    // The message was sent by the current user
                    messageLi.classList.add('my-message'); // add a CSS class to style the message
                } else {
                    // The message was sent by another user
                    messageLi.classList.add('other-message'); // add a CSS class to style the message
                }
                // Add the list item to the chat window
                document.getElementById('chat-messages').appendChild(messageLi);
                const getScrollContainer = document.querySelector('.chat-conversation-box');
                getScrollContainer.scrollTop = getScrollContainer.scrollHeight;
            });
        }
        const ps = new PerfectScrollbar('.chat-conversation-box', {
            suppressScrollX: true
        });
        const getScrollContainer = document.querySelector('.chat-conversation-box');
        getScrollContainer.scrollTop = 0;
        $("#chat-from").on("submit", function(e) {
            e.preventDefault();
            var message = $(this).find("input[name='message']");
            if ($('.nnasnejca').attr('prompt') == 'true') {
                $(".closeGpt").hide();
                $(".nnasnejca").removeClass('gptprompt').attr('prompt', false);
                $.ajax({
                    url: "{{ route('front.chat-gpt') }}",
                    type: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    data: JSON.stringify({
                        val: message.val(),
                        user_id: user_id
                    }),
                    success: function(result) {
                        message.val("");
                        if (result.completion) {
                            const conent = {
                                content: decode_utf8((result.completion)),
                                room: room,
                                sender: user_id // where currentUserID is the unique ID of the current user
                            };
                            socket.emit('sendChatToServer', conent);
                            const getScrollContainer = document.querySelector('.chat-conversation-box');
                            getScrollContainer.scrollTop = getScrollContainer.scrollHeight;
                        }
                    }
                });
            } else {
                if (message.val() != "") {
                    const conent = {
                        content: message.val(),
                        room: room,
                        sender: user_id // where currentUserID is the unique ID of the current user
                    };
                    socket.emit('sendChatToServer', conent);
                    message.val("");
                    const getScrollContainer = document.querySelector('.chat-conversation-box');
                    getScrollContainer.scrollTop = getScrollContainer.scrollHeight;
                }
            }
        });
        const blockedWords = [{!! '"' . implode('","', $blockwords) . '"' !!}];

        function hasBlockedWords(input) {
            for (let i = 0; i < blockedWords.length; i++) {
                const blockedWord = blockedWords[i];
                const regex = new RegExp(`\\b${blockedWord}\\b`,
                    'gi'); // Create a case-insensitive word boundary regular expression
                if (regex.test(input)) {
                    return true; // Return true if a blocked word is found
                }
            }
            return false; // Return false if no blocked words are found
        }
        $("input[name='message']").on("input", function() {
            const userInput = $(this).val();
            const inputValue = $(this).val();
            const searchTerm = "/gpt";
            const searchTerm1 = " /gpt Query";
            if (inputValue.includes(searchTerm) || inputValue.includes(searchTerm1)) {
                $(".closeGpt").show();
                $(".aichat").show();
                // $(".chatbotbox").show();
                $(".nnasnejca").addClass('gptprompt').attr('prompt', true);
                $(this).val('');
            }
            const containsBlockedWords = hasBlockedWords(userInput.toLowerCase());
            if (containsBlockedWords) {
                $("#chat-from button").attr("disabled", true);
                toastr["warning"]("If You Are Using illegal, nudity/sexual any kind of words!");
                //   console.log("Input contains blocked words. Please revise your message.");
            } else {
                $("#chat-from button").attr("disabled", false);
                console.log("Input is clean. Proceed with further processing.");
            }
        });
        $(document).on('click', '.aichat', function() {
            $('.chatbotbox').toggle();
        })
        $(document).on('submit', '#chat-bot', function(event) {
            event.preventDefault();
            let chatList = $('.chatbotbox ul');
            let val = $.trim($("textarea[name='botmessage']").val());
            if (val == '') {
                return;
            }
            $('.ssesxa').hide();
            $('.chat-btn.fa').show();
            $("textarea[name='botmessage']").val(' ');
            $.ajax({
                url: "{{ route('front.chat-gpt') }}",
                type: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                data: JSON.stringify({
                    val: val,
                    user_id: user_id
                }),
                success: function(result) {
                    if (result.completion) {
                        chatList.append(`
                            <li>
                                <span></span>
                                <div class="botquestion">${val}</div>
                                <div class="botanswer">${decode_utf8((result.completion))}</div>
                            </li>
                        `);
                        chatList.scrollTop(chatList[0].scrollHeight);
                    }
                }
            });
            $('.ssesxa').show();
            $('.chat-btn.fa').hide();
        });
        $(document).on('click', '.chatbotbox ul span', function() {
            let AItext = $.trim($(this).parent().find('.botanswer').text());
            let msgText = $.trim($(this).parent().find('.botquestion').text());
            console.log(msgText + ' + ' + AItext);
            $(".sfcraerffadferfadwedascdfvrwascfrgwasd").val(msgText + '<br>' + AItext);
            $('.chatbotbox').hide();
        });

        function decode_utf8(s) {
            return decodeURIComponent(escape(s));
        }
        $(document).on('click', '.closeGpt', function() {
            $(".closeGpt").hide();
            $(".aichat").hide();
            $(".chatbotbox").hide();
            $(".nnasnejca").removeClass('gptprompt').attr('prompt', false);
            $(this).val('');
        })
        $("#share").jsSocials({
            url: "{{ $currentUrl }}",
            showLabel: false,
            showCount: false,
            shares: ["email", "twitter", "facebook", "linkedin", "pinterest", "whatsapp"]
        });

        function hangup() {
            $.ajax({
                url: "{{ route('front.hangup', [$user->id,$meeting_id]) }}",
                type: "GET",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                success:function(res){
                    window.open("{{ route('front.welcome') }}","_self");
                }
            })
        }
    </script>
@endsection
