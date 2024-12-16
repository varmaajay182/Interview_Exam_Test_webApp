<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Replace this with your own image styles -->
    <style>
        .illustration {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6 offset-md-3 text-center">
                <h2>Thank You! {{ session()->get('name') }}</h2>
                <p>Congratulations on completing the quiz! Your dedication and effort are commendable, and we appreciate
                    your participation. Whether you aced it or faced challenges, your commitment to learning is what
                    truly matters.</p>
                <!-- Replace this with your own image -->
                <img src="{{ asset('img/thankyou.jpg') }}" alt="Illustration" class="illustration">
                <h6>Basic level Marks: {{ $basic_marks }}</h6>
                <h6>Medium level Marks: {{ $medium_marks }}</h6>
                <h6>Hard level Marks:{{ $hard_marks }} </h6>

                <h6><b>Total Marks : {{ $get_total_marks . '/' . $total_marks }}</b></h6>
                <h6><b>Percentage : {{ ($get_total_marks / $total_marks) * 100 }}</b></h6>
                <h6><b>Result: @if (($get_total_marks / $total_marks) * 100 < 37)
                          <p style="color:red">Fail</p>  
                        @else
                            pass
                        @endif
                    </b></h6>
                    {{-- <a href="/wrongquestion">show wrong Question</a> --}}
                <a href="/back" class="btn btn-primary">Go back</a>

            </div>
        </div>
    </div>
</body>

</html>
