@extends('layouts.app')
@section('pagename', 'Video')
@section('styles')
    <link href="{{asset('assets/css/perfect-scrollbar.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .chat-input-group .chat-input {
            /*bottom: 60px;*/
            width:98%;
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
            width:100%;
        }
        .chat-box .card-body {
            height: 500px;
            overflow: hidden;
        }
        #chat-messages {
            list-style: none;
            margin: 0;
            padding: 0;
            height:485px;
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
                <div class="row justify-content-between mb-3 align-items-center m-0">
                <a class="btn btn-dark rounded gotodashboard Goback-Btn" href="{{ route('front.main') }}">
                    <img src="{{ asset('assets/images/svg/arrowleft.svg') }}" class='showLight'>
                    <img src="{{ asset('assets/images/svg/arrowleftDark.svg') }}" class='showdark'>
                    Go Back to Dashboard
                </a>
                <button class="btn skip-video-btn rounded btn-small m-0" type="button" id="skip_call"><i class="mdi mdi-24px mdi-reload"></i> Skip</button>
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
                        <form id="chat-from">
                            <div class="chat-input-group">
                                <input class="chat-input" placeholder="Type your message" type="text" name="message"> 
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
    <script src="{{asset('assets/js/perfect-scrollbar.min.js')}}"></script>
    <script>
        var mic = true;
        var room ="0";
        var myid = 0;
        var otherid = 0;
        var video = true;
        var dispNme = "{{ $user->username }}";
        var meeting_id = "585689757";
        
        $("#skip_call").on("click", function() {
            skip_query();
        });
        $(function() {
            skip_query();
        });
        function skip_query() {
            if (myid != 0 && otherid != 0) {
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
                                chat_list(room);
                            } else {
                                skip_query();
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
                            } else {
                                skip_query();
                            }
                        }
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
                        toastr["success"]("Status Change To Connected Successfully!")
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
                getScrollContainer.scrollTop = 0;
            });
        }
        const ps = new PerfectScrollbar('.chat-conversation-box', {
    suppressScrollX : true
  });

  const getScrollContainer = document.querySelector('.chat-conversation-box');
  getScrollContainer.scrollBottom = 0;
        $("#chat-from").on("submit", function(e) {
            e.preventDefault();
            var message = $(this).find("input[name='message']");
            if (message.val() != "") {
                const conent = {
                    content: message.val(),
                    room: room,
                    sender: user_id // where currentUserID is the unique ID of the current user
                };
                socket.emit('sendChatToServer', conent);
                message.val("");
                const getScrollContainer = document.querySelector('.chat-conversation-box');
  getScrollContainer.scrollBottom = 0;
            }
        });
        var intrest_count = 0;
        var intrest  = [];
        $("#intrest-input").on("change",function(){
            var value =$(this).val();
            if(value !=""){
               const newLength =  intrest.push(value);
               intrest_count = newLength-1;
                $("#multiple-intrest").append(`<div class='btn btn-small rounded-pill btn-light-dark interest-${intrest_count} mb-1 mr-1'>
                            ${value} <span onClick="remove_intrest(${intrest_count},'${value}')"
                                class="px-2">&times;</span>
                        </div>`);
                $(this).val("");
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
                        toastr["success"]("Intrest Added Successfully!")
                    }
                }
            })
                
            }
        })
        function remove_intrest(idd,value){
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
                        toastr["success"]("Interest Added Successfully!")
                    }
                }
            })
        }
    </script>
@endsection
