@extends('layouts.app')
@section('pagename','Dashboard')
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
 
    <section class='dashboard-section'>
        <div class='deahboardSecLeft col-md-5 col-lg-6 '>
            <h1>Connecting  Minds</h1>
            <p>Mindful is a social networking application that encourages lively debates on a range of topics, with an emphasis on religion and science. Users can engage in random video or text chats to challenge their perspectives, promote critical thinking, and foster common understanding to build a community of passionate and intellectually curious individuals.</p>
            
            <button class='btn btn-light-dark rounded-pill btn-small'>Start Chatting</button>
            <div class='dashboardbtngrp'>
                <button class='btn btn-light-dark rounded '>Text</button>
                <a class='btn btn-dark rounded ' href="{{route('front.video')}}">Video</a>
            </div>
        </div>
        <div class='deahboardSecRight col-md-5 col-lg-6 '>
            
            <div class=' dashpoardslider'>
                <img src="{{asset('assets/images/slider/02.svg')}}" >
                <img src="{{asset('assets/images/slider/02.svg')}}" >
                <img src="{{asset('assets/images/slider/02.svg')}}" > 
            </div>
            <p>
                Chat GPT: Generative Pre-trained Transformer for Open-Domain Conversational AI
            </p>
             <button class='btn btn-dark rounded '>Open GPT</button>
        </div>
    </section>
   
@endsection