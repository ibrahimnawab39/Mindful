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
                emphasis on religion and science. Users can engage in random video or text chats to challenge their
                perspectives, promote critical thinking, and foster common understanding to build a community of passionate
                and intellectually curious individuals.</p>
            <button class='btn btn-light-dark rounded-pill btn-small'>Start Chatting</button>
            <div class='dashboardbtngrp'>
                <a class='btn btn-light-dark rounded ' href="{{route('front.text')}}">
                    <img src="{{asset('assets/images/svg/envelope.svg')}}" class='showLight'>
                    <img src="{{asset('assets/images/svg/envelope-dark.svg')}}" class='showdark'>
                    Text</a>
                <a class='btn btn-dark rounded ' href="{{ route('front.video') }}"> 
                    <img src="{{asset('assets/images/svg/video.svg')}}" class=''>
                    Video</a>
            </div>
            <div class="row">
                <div class="col-md-12 mt-4">
                    <label for="">Connect to <span class='text-muted'>(Optional)</span></label>
                    <select id="connect-dropdown"  >
                        <option value="" selected disabled>Select from drop down</option>
                        <option value="Everyone">Everyone</option>
                        <option value="Jews">Jews</option>
                        <option value="Christians">Christians</option>
                        <option value="Muslims">Muslims</option>
                        <option value="Atheists">Atheists</option>
                    </select>
                </div>
            </div>
        </div>
        <div class='deahboardSecRight col-md-5 col-lg-6 '>
            <div class='dashpoardslider'>
                <img src="{{ asset('assets/images/slider/02.svg') }}">
                <img src="{{ asset('assets/images/slider/02.svg') }}">
                <img src="{{ asset('assets/images/slider/02.svg') }}">
            </div>
            <p>
                Chat GPT: Generative Pre-trained Transformer for Open-Domain Conversational AI
            </p>
            <button class='btn btn-dark rounded '>
            <img src="{{asset('assets/images/svg/openai.svg')}}" class=''>
                Open GPT</button>
        </div>
    </section>
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
                        if(result["res"] == "success"){
                            toastr["success"]("Connect Added Successfully!")
                        }
                    }
                })
            }
        });
    </script>
@endsection
