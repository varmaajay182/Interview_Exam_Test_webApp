@extends('admin.adminlayouts.app')
@section('content')
    <div id="content" class="p-4 p-md-5 pt-5">
        <h2 class="mb-4">Exams</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addexammodal">
            Add Exams
        </button>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Exam_Name</th>
                    <th scope="col">Technology</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Logo</th>
                  
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

                </tr>
                {{-- {{dd($exams)}} --}}
                @if (count($exams))
                    @foreach ($exams as $index => $exam)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $exam->name }}</td>
                            <td>{{ $exam->technology->technology }}</td>
                            <td>{{ $exam->date }}</td>
                            <td>{{ $exam->time }}hrs</td>
                            <td><img src="{{asset('public/img/'.$exam->logo)}}" alt=""></td>
                           
                            <td><button type="button" class="btn btn-primary edit-btn" data-toggle="modal"
                                    data-target="#editexammodel">edit</button></td>
                            <td><a href="/exam/delete/{{ $exam->id }}"><button type="button"
                                        class="btn btn-danger">Delete</button></a></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th> Not Data Found</th>
                    </tr>
                @endif


            </tbody>
        </table>

        <div class="modal fade" id="addexammodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form id="addexam" action="/addexam" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Exams</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><br />
                        <div class="modal-body">
                            <label for="exam_name">Exam_Name</label>
                            <input type="text" id="exam_name" name="exam_name" autocomplete="off">
                            <br /><br />
                            <select name="technology" id="" required class="w-100">
                                <option value="">Technology</option>
                                @if (count($technology) > 0)
                                    @foreach ($technology as $technology)
                                        <option value="{{ $technology->id }}">{{ $technology->technology }}</option>
                                    @endforeach
                                @endif
                            </select><br /><br />
                            <label for="exam_file">Upload File</label>
                            <input type="file" id="exam_file" name="logo">
                            <br /><br />
                         
                            <input type="date" name="date" class="w-100" placeholder="Start Date"
                                min="<?php echo date('Y-m-d'); ?>" /><br /><br />
                            <input type="time" name="time" class="w-100" />

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- {{dd($subject)}} --}}

        <div class="modal fade" id="editexammodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form id="addexam" action="/addexam" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Exams</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><br />
                        <div class="modal-body">
                            <label for="exam_name">exam_name</label>
                            <input type="text" id="exam_name" name="exam_name">
                            <br /><br />
                          
                            <select name="subject_id" id="" required class="w-100">
                                <option value="">subject_name</option>

                                {{-- @foreach ($subject as $subj)
                                    <option value="{{ $subj->id }}">{{ $subj->subject }}</option>
                                @endforeach --}}


                            </select><br /><br />
                          
                                <label for="exam_file">Upload File</label>
                                <input type="file" id="exam_file" name="exam_file">
                                <br /><br />
                            
                            <input type="date" name="date" class="w-100" placeholder="Start Date"
                                min="<?php echo date('Y-m-d'); ?>" /><br /><br />
                            <input type="time" name="time" class="w-100" />

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
