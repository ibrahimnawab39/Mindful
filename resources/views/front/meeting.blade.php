@extends('layouts.app')
@section('pagename', 'Video')
@php
    $interest_count = 0;
    $interests = explode(',', $user->interest);
@endphp
@section('styles')
    <link href="{{ asset('assets/css/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                height: 70vh;
            }
        }

        main.py-4 {
            padding: 0 !important;
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
                    </div>
                    <div class="reportuser">
                        <button class="report-btn">Report</button>
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
                        </div>
                    </div>
                    <div class="col-md-6  pl-md-2 oponentVideo">
                        <video id="remoteVideo" autoplay muted></video>
                    </div>
                </div>
                <div class=' align-items-center row'>
                    <div class='col-md-7  '>
                        <div class="form-group ijosc">
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
                        </div>
                    </div>
                    <div class='col-md-5 '>
                        <div class="d-flex justify-content-end">
                            <button class="btn skip-video-btn rounded btn-small" type="button" id="skip_call">
                                <i
                                    class="mdi mdi-24px mdi-reload"></i> Skip</button>
                        </div>
                    </div>
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
    <script>
        var mic = true;
        var room = "0";
        var myid = 0;
        var otherid = 0;
        var video = true;
        var dispNme = "{{ $user->username }}";
        var meeting_id = "585689757";
        var skipStatus = 'finding' // connected, finding, confirm

        function changeSkipButton(data) {

            if (data == 'confirm') {
                $("#skip_call").addClass('btn-primaryyy').removeClass('skip-video-btn').html('Are you sure?');
            } else if (data == 'finding') {
                $("#skip_call").addClass('btn-primaryyy').removeClass('skip-video-btn').html(
                    '<p class="mb-0 dotloading">Finding a stranger</p>');
            } else if (data == 'connected') {
                $("#skip_call").addClass('skip-video-btn').removeClass('btn-primaryyy').html(
                    '<i class="mdi mdi-24px mdi-reload"></i> Skip')
            }
            skipStatus = data
        }

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

            if (skipStatus == 'connected') {
                changeSkipButton('confirm')
            } else if (skipStatus == 'confirm') {
                changeSkipButton('finding')
                skip_query();
            } else {
                skip_query();
            }

        });
        $(function() {
            skip_query();
            changeSkipButton('finding')
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
            $("#chat-messages").html("");
            $(".room-number,.oppentent-detail").html("");
            skiping_video(video, mic);
            if (myid != 0 && otherid != 0) {
                socket.emit('leaveRoom', room);
                $.ajax({
                    url: "{{ route('front.skipping') }}",
                    type: "POST",
                    data: {
                        myid: myid,
                        otherid: otherid
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "JSON",
                    success: function(result) {
                        if (result["res"] == "ipblocked") {
                            window.open("{{ route('front.blocked') }}", '_self')
                        } else if (result["res"] == "success") {
                            if (result["room"] != null) {
                                icon.removeClass("mdi-spin");
                                BindEvent();
                                myid = result["room"]["my_id"];
                                otherid = result["room"]["other_id"];
                                room = result["room"]["room_name"];
                                $(".room-number,.oppentent-detail").html(result["other_username"]);
                                StartMeeting(room, dispNme, video, mic);
                                chat_list(room);
                            } else {
                                skip_query();
                            }
                        }
                        changeSkipButton('connected')
                    }
                })
            } else {
                $.ajax({
                    url: "{{ route('front.skipping') }}",
                    type: "POST",
                    data: {
                        myid: 0,
                        otherid: 0
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "JSON",
                    success: function(result) {
                        if (result["res"] == "ipblocked") {
                            window.open("{{ route('front.blocked') }}", '_self')
                        }
                        if (result["res"] == "success") {
                            if (result["room"] != null) {
                                icon.removeClass("mdi-spin");
                                BindEvent();
                                myid = result["room"]["my_id"];
                                otherid = result["room"]["other_id"];
                                room = result["room"]["room_name"];
                                $(".room-number,.oppentent-detail").html(result["other_username"]);
                                StartMeeting(room, dispNme, video, mic);
                                chat_list(room);
                            } else {
                                skip_query();
                            }
                        }
                        changeSkipButton('connected')
                    }
                })
            }
        }

        function change_status() {
            $.ajax({
                url: "{{ route('front.change-status') }}",
                type: "POST",
                data: {
                    myid: myid,
                    otherid: otherid
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "JSON",
                success: function(result) {
                    if (result["res"] == "success") {
                        $("#video-message").html(result["message"]);
                    }
                }
            })
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
        var intrest_count = {{ count($interests) }};
        var intrest = [{!! !empty($user->interest) && $user->interest != null && !empty($interests)
            ? "'" . implode("','", $interests) . "'"
            : null !!}];
        $("#intrest-input").on("change", function() {
            var value = $(this).val();
            if (value != "") {
                const newLength = intrest.push(value);
                intrest_count = newLength - 1;
                $("#multiple-intrest").append(`<div class='btn btn-small rounded-pill btn-light-dark interest-${intrest_count} mb-1 mr-1'>
                            ${value} <span onClick="remove_intrest(${intrest_count},'${value}')"
                                class="px-2">&times;</span>
                        </div>`);
                $(this).val("");
                $.ajax({
                    url: "{{ route('front.change-intrest') }}",
                    type: "POST",
                    data: {
                        intrest: intrest.join(","),
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "JSON",
                    success: function(result) {
                        if (result["res"] == "success") {
                            toastr["success"]("Intrest Added Successfully!")
                        }
                    }
                })
            }
        })

        function remove_intrest(idd, value) {
            const index = intrest.indexOf(value);
            if (index !== -1) {
                intrest.splice(index, 1);
            }
            $(`.interest-${idd}`).remove();
            console.log(intrest);
            $.ajax({
                url: "{{ route('front.change-intrest') }}",
                type: "POST",
                data: {
                    intrest: intrest.join(","),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "JSON",
                success: function(result) {
                    if (result["res"] == "success") {
                        toastr["success"]("Interest Remove Successfully!")
                    }
                }
            })
        }
        setInterval(updateTime, 2000);

        function updateTime() {
            $.ajax({
                url: "{{ route('front.change-time') }}",
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            })
        }
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
                    console.log(result);
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
        $(document).on('click', '.report-btn', function() {
            if (myid != 0 && otherid != 0) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to report him/her ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, report it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('front.report') }}",
                            type: "POST",
                            data: {
                                otherid: otherid,
                                myid: myid
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(result) {
                                if (result['res'] == 'success') {
                                    skip_query();
                                    toastr["success"]("Report successfully submited");
                                }
                            }
                        })
                    }
                })
            }
        })
    </script>
@endsection
