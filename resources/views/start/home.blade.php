@extends('layouts.base')

@section('title', 'Accueil')
@section('content')

@if(Auth::user()->role=="Administrateur")
    @include('start.home-1')
@elseif(Auth::user()->role=="Collaborateur")
    @include('start.home-2')
@elseif(Auth::user()->role=="Assistant")
    @include('start.home-3')
@else
    @include('start.home-4')
@endif
@endsection
