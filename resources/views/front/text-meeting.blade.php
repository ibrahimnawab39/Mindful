@extends('layouts.app')
@section('pagename', 'Text Meeting')
@php
    $interest_count = 0;
    $interests = explode(',', $user->interest);
@endphp
@section('styles')
    <link href="{{ asset('assets/css/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .chat-input-group .chat-input {
            /*bottom: 60px;*/
            /* width: 88%; */
        }
        button.chat-btn {
            /*bottom: 67px;*/
            right: 20px;
        }
        .skip-video .myVideo .videoActions {
            left: 50%;
            transform: translateX(-50%);
        }
        .chat-header.card-header h6 {
            width: 100%;
        }
        .chat-box .card-body {
            height: 500px;
            overflow: hidden;
        }
        #chat-messages {
            list-style: none;
            margin: 0;
            padding: 0;
            position: relative;
            height: 485px;
        }
        #chat-messages li:last-child {
            margin-bottom: 20px
        }
    </style>
@endsection
@section('content')
    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row justify-content-between mb-3 align-items-center m-0 gap-10">
                    <a class="btn btn-dark rounded gotodashboard Goback-Btn" href="{{ route('front.main') }}">
                        <img src="{{ asset('assets/images/svg/arrowleft.svg') }}" class='showLight'>
                        <img src="{{ asset('assets/images/svg/arrowleftDark.svg') }}" class='showdark'>
                        Go Back to Dashboard
                    </a>
                    <h4 class="room-number"></h4>
                    <div class='col-md-4'>
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
                    <button class="btn skip-video-btn rounded btn-small m-0" type="button" id="skip_call">
                        <i class="mdi mdi-24px mdi-reload"></i> Skip</button>
                </div>
                <div class="chat-box card">
                    <div class="chat-header card-header ">
                        <h6 class=" ">Live Chat</h6>
                    </div>
                    <div class="card-body chat-body">
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
                                    placeholder="Type your message" type="text" name="message">
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
        var clearinterval = setInterval(updateOnlineTime, 2000);
        var statusconntion = null;
        $("#skip_call").on("click", function() {
            var icon = $(this).find(".mdi");
            icon.addClass("mdi-spin");
            clearinterval = setInterval(updateOnlineTime, 2000);
            SkipQuery();
        });
        $(function() {
            SkipQuery();
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
            let msgText = $.trim($("input[name='message']").val());
            console.log(msgText + ' + ' + AItext);
            $(".sfcraerffadferfadwedascdfvrwascfrgwasd").val(msgText + ' ' + AItext);
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
        function SkipQuery() {
            $("#chat-messages").html("");
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
                        if (result["res"] == "success") {
                            if (result["room"] != null) {
                                myid = result["room"]["my_id"];
                                otherid = result["room"]["other_id"];
                                room = result["room"]["room_name"];
                                $(".room-number").html(result["other_username"]);
                                chat_list(room);
                                clearInterval(clearinterval);
                                statusconntion = setInterval(ChangeStatus, 2000)
                            } else {
                                SkipQuery();
                            }
                        }
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
                        if (result["res"] == "success") {
                            if (result["room"] != null) {
                                myid = result["room"]["my_id"];
                                otherid = result["room"]["other_id"];
                                room = result["room"]["room_name"];
                                chat_list(room);
                                $(".room-number").html(result["other_username"]);
                                clearInterval(clearinterval);
                                statusconntion = setInterval(ChangeStatus, 2000)
                            } else {
                                SkipQuery();
                            }
                        }
                    }
                })
            }
        }
        function ChangeStatus() {
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
                        toastr["success"]("Status Change To Connected Successfully!")
                        clearInterval(statusconntion);
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
        function updateOnlineTime() {
            $.ajax({
                url: "{{ route('front.change-time') }}",
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            })
        }
    </script>
@endsection
