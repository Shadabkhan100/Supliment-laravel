@extends('layout.Main')

@section('content')
   
 <main class="main-wrapper">
   <h1 style="color:white">{{ $deal->title }}  {{ $deal->image }}</h1>
   <img src="{{ $deal->image }}">
 </main>

@endsection