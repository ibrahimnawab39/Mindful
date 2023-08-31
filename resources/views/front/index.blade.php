@extends('layouts.app')
@section('pagename', 'Dashboard')
@section('styles')
    <style>
        :root {
            --background-body: #fff;
        }

        [theme="darkTheme"] {
            --background-body: #121212;
        }
    </style>
@endsection
@section('content')
    <section class='dashboard-section standard'>
        <div class='deahboardSecLeft col-md-5 col-lg-6 pr-0'>
            <h1>Connecting Minds</h1>
            <p>Mindful is a social networking application that encourages lively debates on a range of topics, with an
                emphasis on politics, religion and science. Users can engage in random video or text chats to challenge
                their perspectives, promote critical thinking, and foster common understanding to build a community of
                passionate and intellectually curious individuals.</p>
            <button class='btn btn-light-dark rounded-pill btn-small'>Start Chatting</button>
            <div class='dashboardbtngrp'>
                <a class='btn btn-light-dark rounded ' href="{{ route('front.text') }}">
                    <img src="{{ asset('assets/images/svg/envelope.svg') }}" class='showLight'>
                    <img src="{{ asset('assets/images/svg/envelope-dark.svg') }}" class='showdark'>
                    Text</a>
                <a class='btn btn-primary rounded ' href="{{ route('front.share') }}">
                    <img src="{{ asset('assets/images/svg/video.svg') }}" class=''>
                    Share Meeting</a>
                <a class='btn btn-dark rounded ' href="{{ route('front.video') }}">
                    <img src="{{ asset('assets/images/svg/video.svg') }}" class=''>
                    Video</a>
            </div>
            <div class="row w-100">
                <div class="col-md-12 mt-4">
                    <label for="">Connect to <span class='text-muted'>(Optional)</span></label>
                    <select id="connect-dropdown">
                        <option value="" selected disabled>Select from drop down</option>
                        <option value="Everyone">Everyone</option>
                        <option value="Jews">Jews</option>
                        <option value="Christians">Christians</option>
                        <option value="Muslims">Muslims</option>
                        <option value="Atheists">Atheists</option>
                    </select>
                </div>
            </div>
            <a href="#deahboardSecRight" class="sendToBottomBtn" style="display: none">
                <img src="{{asset('assets/images/dashboard/mouse-cursor.png')}}">
            </a>
        </div>
        <div class='deahboardSecRight col-md-5 col-lg-6 ' id="deahboardSecRight">
            <img src="{{ asset('assets/images/dashboard/gpt-icon-black.png') }}" class='img-fluid w-50 showLight'>
            <img src="{{ asset('assets/images/dashboard/gpt-icon-white.png') }}" class='img-fluid w-50 showdark'>
            {{-- <div class='dashpoardslider'>
                <img src="{{ asset('assets/images/slider/02.svg') }}">
                <img src="{{ asset('assets/images/slider/02.svg') }}">
                <img src="{{ asset('assets/images/slider/02.svg') }}">
            </div> --}}
            <p>
                Chat GPT: Generative Pre-trained Transformer for Open-Domain Conversational AI
            </p>
            <button class='btn btn-dark rounded ' type="button" data-toggle="modal" data-target="#exampleModal">
                <img src="{{ asset('assets/images/svg/openai.svg') }}" class=''>
                Instructions</button>
        </div>

    </section>

    <!-- Modal -->
    <div class=" fade modal  instruction-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Instructions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Mindful GPT, powered by OpenAI, is an advanced language model designed to generate human-like text
                        based
                        on the input it receives. It's trained on vast amounts of data, enabling it to respond to a wide
                        range
                        of queries, assisting in debates and discussions.
                    </p>
                    <p>
                        Tip: Type <strong>‘/gpt YourQuery’</strong> in a text or video chat to use this tool mid-discussion!
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-small btn-success rounded " data-dismiss="modal">Got it!</button>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $("#connect-dropdown").on("change", function() {
            var value = $(this).val();
            if (value != "" && value != null) {
                $.ajax({
                    url: "{{ route('front.connect-with') }}",
                    type: "POST",
                    data: {
                        connect_with: value
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "JSON",
                    success: function(result) {
                        if (result["res"] == "success") {
                            toastr["success"]("Connect Added Successfully!")
                        }
                    }
                })
            }
        });
    </script>
@endsection
