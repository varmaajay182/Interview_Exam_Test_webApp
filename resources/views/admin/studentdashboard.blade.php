@extends('admin.adminlayouts.app')
@section('content')
    <div id="content" class="p-4 p-md-5 pt-5">
        <h2 class="mb-4">Student</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addstudentmodal">
            Add Student
        </button>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Student</th>
                    <th scope="col">Email</th>
                    <th scope="col">Number</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @if (session()->has('errors'))
                        <div class="alert alert-danger">
                            {{ session()->get('errors') }}
                        </div>
                    @endif

                </tr>
                {{-- {{dd($questions)}} --}}
                @if (count($student))
                    @foreach ($student as $index => $student)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $student->name }}</td>

                            <td>{{ $student->email }}</td>
                            <td>{{ $student->number }}</td>
                            <td><button type="button" class="btn btn-primary edit-btn" data-toggle="modal"
                                    data-id="{{ $student->id }}" data-name="{{ $student->name }}"
                                    data-email="{{ $student->email }}" data-target="#updateModal">Edit</button></td>
                            <td><a href="/student/delete/{{ $student->id }}"><button type="button"
                                        class="btn btn-danger">Delete</button></a></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th> Student not be found</th>
                    </tr>
                @endif


            </tbody>
        </table>


        <div class="modal fade" id="addstudentmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form id="addexam" action="/addstudent" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add student</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><br />
                        <div class="modal-body">
                            <input type="text" name="name" placeholder="enter student name" class="w-100 mb-3">
                            <input type="text" name="email" placeholder="enter student email" class="w-100">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form id="addexam" action="/updatestudent" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Update student</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><br />
                        <input type="hidden" id="id" name="id">
                        <div class="modal-body">
                            <input type="text" name="name" id="name" placeholder="enter student name"
                                class="w-100 mb-3">
                            <input type="text" name="email" id="email" placeholder="enter student email"
                                class="w-100">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $('.edit-btn').click(function() {
                $('#id').val($(this).attr('data-id'))
                $('#name').val($(this).attr('data-name'))
                $('#email').val($(this).attr('data-email'))
            });
        });
    </script>
@endsection
