@extends('layouts.master')

@section('movies')
    @foreach($movies as $movie)
        <li>
            <h4>{{ $movie->title }}</h4>
            <img src="{{ $movie->image }}" width="286" height="auto" alt="" />
            <div class="wrapper"><a href="#" class="link2"><span><span>Read More</span></span></a></div>
        </li>
    @endforeach
@stop
