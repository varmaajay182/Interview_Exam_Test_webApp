@extends('student.layouts.app')
@section('content')
<div class="outside-navbar bg-primary d-flex justify-content-center" style="height: 150px; width: 100%;">
    <div style="height: 100%; width: 60%;  color: white;" class="">
        <h1 style="margin: 2% 0%;">{{$exam->technology->technology}}</h1>
        <h3 style="color: rgb(217, 218, 219);">{{$exam->name}}</h3>
    </div>
</div>

<div class=" d-flex justify-content-center">
    <div class="w-75">
        <h4 class="mt-2 mb-4 text-center">Choose Difficulty</h4>
        <hr>
        <div class=" w-100 d-flex justify-content-between flex-wrap">
            @foreach ($level as $level)
            <div class="card mt-4 card-text border custom-card" style="width: 19rem;">
                    
                <div class="card-body custom-laravel">
                    <h1 class="card-title">{{$level->type}} level MCQ</h1>
                    <p class="card-subtitle mb-2 text-body-secondary">Marks/question: {{$level->marks}}</p>
                    <p class="card-subtitle mb-2 text-body-secondary">Time: {{$level->time}} hrs</p>
                    <p class="card-subtitle mb-2 text-body-secondary">Attempt:{{$level->attempt}}</p>
                    <a href="/student/exam/{{$level->slug}}/{{$exam->slug}}" class="card-link btn btn-primary" style="margin-right: 32%; @if ($level->id > 1) display:none @endif " >Start</a>
                    <img src="{{asset ('public/img/'.$exam->logo)}}" style="height: 120px; width: 120px;"  alt="">
                </div>
            </div>
            @endforeach
          
        </div>
    </div>
</div>
@endsection