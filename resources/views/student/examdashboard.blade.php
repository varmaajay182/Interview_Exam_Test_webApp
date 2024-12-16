@extends('student.layouts.app')
@section('css')
    <style>
        body,
        html {
            background-color: #fbfbfb;
            height: 100%;
            /* background-color: red; */
        }


        .header {
            width: 12%;
            height: 77%;
            width: 100%;
            /* background-color: red; */
        }

        .sidebar {
            padding: 58px 0 0;
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
            width: 11%;
            height: 100%;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                width: 100%;
            }
        }

        .sidebar .active {
            border-radius: 5px;
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: 0.5rem;
            overflow-x: hidden;
            overflow-y: auto;

        }

        .container {
            padding: 0% !important;
        }
    </style>
@endsection
@section('content')
    @php
        $suc = $success;
        $abc =0;
        $time = 0;
    @endphp
    @if ($success == true)
        <div class="outside-navbar bg-primary d-flex justify-content-center" style="height: 150px; width: 100%;">
            <div style="height: 100%; width: 60%;  color: white;" class="">
                <h1 style="margin: 2% 0%;">{{ $question[0]->examtype->type }} Level MCQ</h1>
                <h3 style="color: rgb(217, 218, 219);">{{ $question[0]->exam->name }}</h3>
            </div>
        </div>
        {{-- {{dd(count($question))}} --}}
        <header class="header d-flex">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
                <div class="position-sticky">
                    <div class="list-group list-group-flush mx-3 mt-4">
                        <!-- Collapse 1 -->
                        <a class="list-group-item list-group-item-action py-2 ripple" aria-current="true"
                            data-mdb-toggle="collapse" href="#collapseExample1" aria-expanded="true"
                            aria-controls="collapseExample1">
                            <i class="fa-solid fa-hashtag"></i> <span>Question Number</span>
                        </a>

                        @for ($i = 0; $i < count($question); $i++)
                            <ul id="collapseExample1" class="collapse show list-group list-group-flush">
                                <li class="list-group-item py-1">
                                    <a href="" class="text-reset">{{ $i + 1 }}</a>
                                </li>
                            </ul>
                        @endfor
                    </div>
                </div>
            </nav>

            <main style="width: 89%;" class="d-flex justify-content-center align-items-center">
                <div class="container mt-4">

                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p>Student Name: <strong>{{ session()->get('name') }}</strong></p>
                            </div>
                            @if ($success == true)
                                <div>
                                    <p class="time">Time remaining: <span
                                            class="timer">{{ $question[0]->examtype->time }}</span></p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <form action="/saveanswer" method="post" id="form">
                        @csrf
                        <div class="card mb-4">
                            @php
                                $q = 1;
                                $abc = $question;
                                $time = explode(':', $question[0]->examtype->time);
                                // dd($time);
                            @endphp
                            <input type="hidden" name="exam_id" value="{{ $question[0]->exam->id }}">
                            <input type="hidden" name="type" value="{{ $question[0]->examtype->id }}">
                            @foreach ($question as $question)
                                <div class="card-body" id="question{{ $q }}"
                                    @if ($q !== 1) style="display:none;" @endif>

                                    <h5>Question {{ $q++ }}</h5>
                                    <p>{{ $question->question }}?</p>
                                    <input type="hidden" name="q[]" value="{{ $question->id }}">

                                    @foreach ($question->answers as $key => $ans)
                                        <div class="form-check">
                                            {{-- <input type="hidden" name="ans[]" value="{{$ans->id}}"> --}}
                                            <input class="form-check-input" type="radio"
                                                name="answer_{{ $question->id }}" id="q1option1"
                                                value="{{ $ans->id }} " data-question="{{ $question->id }}">
                                            <label class="form-check-label" for="answer1">
                                                {{ $ans->answer }}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            @endforeach

                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button"class="btn btn-primary" id="Previous" onclick="showPrevious()"
                                disabled>Previous</button>
                            <a href="#" class="btn btn-primary" id="nextbutton" style="display: block;"
                                onclick="showNext()">Next</a>
                            <button type="submit" class="btn btn-primary" id="save" style="display: none;">Save
                                All</button>
                        </div>
                    </form>




                </div>
            </main>
        </header>
    @else
        <h1 style="color:red; text-align:center">Not Avaible Question for this Exam, Sorry</h1>
    @endif
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // console.log("hello")
        var success = @json($suc);
        if(success === 'false'){
      
        } else {
            let currentQuestion = 1;
            var question = @json($abc);

            var length = question.length;
            // console.log(length)
            if (currentQuestion === length) {
                save.style.display = 'block';
                nextButton.style.display = 'none';
            } else {

                function showNext() {
                    const current = document.getElementById('question' + currentQuestion);

                    current.style.display = 'none';

                    var question = @json($abc);

                    currentQuestion++;
                    const next = document.getElementById('question' + currentQuestion);

                    next.style.display = 'block';

                    const Previous = document.getElementById('Previous');
                    const save = document.getElementById('save');
                    const nextbutton = document.getElementById('nextbutton');
                    Previous.removeAttribute('disabled');
                    if (next == document.getElementById('question' + question.length)) {
                        save.style.display = 'block';
                        nextbutton.style.display = 'none';
                    }

                }

                function showPrevious(event) {
                    // event.preventDefault(); // Prevent form submission

                    const current = document.getElementById('question' + currentQuestion);
                    current.style.display = 'none';

                    currentQuestion--;

                    const previous = document.getElementById('question' + currentQuestion);
                    previous.style.display = 'block';

                    const prevButton = document.getElementById('Previous');
                    const save = document.getElementById('save');
                    const nextButton = document.getElementById('nextbutton');

                    var question = @json($abc);
                    var length = question.length;
                    var index = length - 1;


                    if (currentQuestion === 1) {
                        prevButton.setAttribute('disabled', 'true');
                    } else {
                        prevButton.removeAttribute('disabled');
                    }


                    if (currentQuestion === 0) {
                        save.style.display = 'block';
                        nextButton.style.display = 'none';
                    }
                    if (currentQuestion === index) {
                        save.style.display = 'none';
                        nextButton.style.display = 'block';
                    }


                }
            }

            document.addEventListener("DOMContentLoaded", function() {
                const radioButtons = document.querySelectorAll('input[type="radio"]');

                radioButtons.forEach(function(radio) {
                    radio.addEventListener('click', function() {
                        const answerId = this.value;
                        const questionId = this.getAttribute('data-question');
                        const hiddenInput = document.querySelector(
                            `input[name="q[]"][value="${questionId}"]`);

                        if (hiddenInput) {
                            const answerInput = document.createElement('input');
                            answerInput.type = 'hidden';
                            answerInput.name = `answer_id_${questionId}`;
                            answerInput.value = answerId;

                            const existingInput = document.querySelector(
                                `input[name="answer_id_${questionId}[]"]`);
                            if (existingInput) {
                                existingInput.parentNode.removeChild(existingInput);
                            }
                            hiddenInput.parentNode.appendChild(answerInput);
                        }
                    });
                });
            });

            $(document).ready(function() {

                var time = @json($time);
                console.log(time)
                var hours = time[0];
                var minutes = time[1];
                var seconds = time[2];

                var countdown = setInterval(function time() {
                    if (hours == 0 && minutes == 0 && seconds == 0) {
                        clearInterval(countdown);
                        $('#form').submit();
                    } else {
                        if (seconds == 0) {
                            minutes--
                            seconds = 9
                        }
                        if (minutes == 0 && hours != 0) {
                            hours--
                            minutes = 1
                        }
                    }
                    $('.time').text(hours + ':' + minutes + ':' + seconds + ' left time');
                    seconds--
                }, 1000);

            });
        }
    </script>
@endsection
