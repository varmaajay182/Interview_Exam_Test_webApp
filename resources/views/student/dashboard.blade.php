@extends('student.layouts.app')
@section('content')
<div class="outside-navbar bg-primary d-flex justify-content-center" style="height: 150px; width: 100%;">
    <div style="height: 100%; width: 60%;  color: white;" class="">
        <h1 style="margin: 2% 0%;">Welcome {{session()->get('name')}}</h1>
        <p style="color: rgb(217, 218, 219);">We are here to help you get your dream job. Let’s get started with
            your interview preparation.</p>
    </div>
</div>

<div class=" d-flex justify-content-center">
    <div class="w-75">
        <h4 class="mt-2 mb-4 text-center">Choose the exam </h4>
        <hr>
        <div class=" w-100 d-flex justify-content-between flex-wrap">
            @foreach ($exams as $exam)
                
            <div class="card mt-4 card-text border custom-card" style="width: 19rem;">
                <div class="card-body custom-laravel">
                    <h1 class="card-title">{{$exam->technology->technology}}</h1>
                    <h2 class="card-subtitle mb-2 text-body-secondary">{{$exam->name}}</h2>
                    
                    <a href="/student/level/{{$exam->slug}}" class="card-link btn btn-primary" style="margin-right: 32%;">Next</a>
                    <img src="{{asset('public/img/'.$exam->logo)}}" style="height: 120px; width: 120px;"  alt="">
                  
                </div>
            </div>
            @endforeach
            
           
        </div>
    </div>
</div>
@endsection