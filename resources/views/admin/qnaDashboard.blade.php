@extends('admin.adminlayouts.app')
@section('content')
    <div id="content" class="p-4 p-md-5 pt-5">
        <h2 class="mb-4">Qna&Ans</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addexammodal">
            Add Quetions
        </button>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Question</th>
                    <th scope="col">Correct_Answer</th>
                    <th scope="col">Exam_name</th>
                    <th scope="col">Level</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    @if (session()->has('success'))
                        <div class="alert alert-success success">
                            {{ session()->get('success') }}
                            <script>
                                setTimeout(() => {
                                    $('.success').text('');
                                }, 3000);
                            </script>
                        </div>
                    @endif

                </tr>
                {{-- {{dd($questions)}}   --}}
                @if (count($questions))
                    @foreach ($questions as $index => $question)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $question->question }}</td>

                            <td>{{ $question->answers[0]->answer }}</td>
                            <td>{{ $question->exam->name }}</td>
                            <td>{{ $question->examtype->type }} level</td>
                            <td><button type="button" class="btn btn-primary edit-btn" data-toggle="modal"
                                    data-target="#editModal" onclick="editQuestion({{ $question->id }})"">Edit</button></td>
                            <td><a href="/q&a/delete/{{ $question->id }}"><button type="button"
                                        class="btn btn-danger">Delete</button></a></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th> Question not be added</th>
                    </tr>
                @endif


            </tbody>
        </table>


        <div class="modal fade" id="addexammodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <form action="/addquestion" id="addexam" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mb-4 mr-3" id="exampleModalLongTitle"> Add Exams</h5>
                            <button onclick="addInputField(event)" class="btn btn-primary add">Add answer Field</button>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><br />
                        <div class="modal-body">
                            <select name="exam_id" id="" required class="w-100">
                                <option value="">Select Exam</option>
                                @if (count($exam) > 0)
                                    @foreach ($exam as $exam)
                                        <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                    @endforeach
                                @endif
                            </select><br /><br />
                            <select name="type_id" id="" required class="w-100">
                                <option value="">Select Level</option>
                                @if (count($type) > 0)
                                    @foreach ($type as $type)
                                        <option value="{{ $type->id }}">{{ $type->type }}</option>
                                    @endforeach
                                @endif
                            </select><br /><br />
                            <div id="inputFieldsContainer" class="question">
                                <input type="text" name="question" class="w-100" placeholder="enter the question">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <span class="error" style="color:red"></span>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit" class="btn btn-primary addbutton">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Question and Answers</h5>
                        <button type="button" onclick="addAnswerField()">Add Answer</button>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input type="text" name="question" class="form-control mb-3 ">
                        <div class="answers "></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        let counter = 1;


        function addInputField(event) {
            event.preventDefault();
            const container = document.getElementById('inputFieldsContainer');
            const wrapper = document.createElement('div');
            wrapper.className = 'd-flex mt-2';

            const numAnswerFields = $('.answerInput').length;
            // console.log(numAnswerFields);

            if (numAnswerFields < 4) {
                const inputField = document.createElement('input');
                inputField.type = 'text';
                inputField.id = `inputField_${counter}`;
                inputField.placeholder = `Answer ${counter}`;
                inputField.name = `answer[]`;
                inputField.className = `w-100 ml-2 answerInput`;

                const radioBtn = document.createElement('input');
                radioBtn.type = 'radio';
                radioBtn.name = 'is_correct';
                radioBtn.className = 'radio-btn';


                const removeButton = document.createElement('button');
                removeButton.textContent = 'Remove';
                removeButton.className = 'btn btn-danger ml-2';
                removeButton.addEventListener('click', function() {
                    container.removeChild(wrapper);
                });


                wrapper.appendChild(radioBtn);
                wrapper.appendChild(inputField);
                wrapper.appendChild(removeButton);
                container.appendChild(wrapper);

                inputField.addEventListener('input', function() {
                    radioBtn.value = this.value;
                });

                counter++;
            } else {
                $('.error').text('You cannot add more than 4 answer fields');
                setTimeout(() => {
                    $('.error').text('');
                }, 3000);
            }


        }

        function getRadioInputPairs() {
            const radioInputPairs = [];
            const radioButtons = document.querySelectorAll('input[type="radio"]');
            const inputFields = document.querySelectorAll('input[type="text"]');

            radioButtons.forEach((radio, index) => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        const pair = {
                            radioValue: this.value,
                            inputValue: inputFields[index].value,
                        };
                        radioInputPairs.push(pair);
                        // console.log(radioInputPairs);
                    }
                });
            });
        }


        getRadioInputPairs();


        $(document).ready(function() {
            $('#addexam').on('submit', function(e) {
                e.preventDefault();
                const numAnswerFields = $('.answerInput').length;
                const radioButton = $("input[name='is_correct']:checked").length;

                if (numAnswerFields < 2) {
                    $('.error').text('Please require minimum 2 answer');
                    setTimeout(() => {
                        $('.error').text('');
                    }, 3000);
                } else if (numAnswerFields >= 2 && radioButton == 0) {
                    $('.error').text('please check currect answer');
                    setTimeout(() => {
                        $('.error').text('');
                    }, 3000);
                } else {
                    // console.log('submit')
                    $(this).unbind('submit').submit();
                }

            });


        });
    </script>


    <script>
        function editQuestion(id) {
            $.ajax({
                url: `/questions/${id}/edit`,
                type: 'GET',
                success: function(data) {
                    $('#editModal input[name="question"]').val(data.question);
                    $('#editModal .answers').empty();

                    data.answers.forEach(answer => {
                        let input = `<input type="radio" name="correct_answer" value="${answer.id}" `;
                        if (answer.is_correct === 1) {
                            input += `checked`;
                        }
                        input += `>${answer.answer}<br>`;
                        $('#editModal .answers').append(input);
                    });

                    $('#editModal').modal('show');
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function addAnswerField() {
            const newAnswerField = `
            <input type="radio" name="correct_answer" value="new_answer" class="form-check-input" />
            <input type="text" name="new_answer[]" class="form-control mb-2" placeholder="Enter Answer" />
            <br>
        `;
            $('#editModal .answers').append(newAnswerField);
        }
    </script>
@endsection
