@extends('admin.adminlayouts.app')
@section('content')
    <div id="content" class="p-4 p-md-5 pt-5">
        <h2 class="mb-4">Exam_type</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addsubjectmodel">
            Add Exam_type
        </button>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Type</th>
                    <th scope="col">Marks/qestion</th>
                    <th scope="col">Time</th>
                    <th scope="col">Attempt</th>
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
                @if (count($type))
                    @foreach ($type as $index => $type)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $type->type }}</td>
                            <td>{{ $type->marks }}</td>
                            <td>{{ $type->time }}</td>
                            <td>{{ $type->attempt }}</td>
                            <td><button type="button" data-subject="{{ $type->type }}" data-id="{{ $type->id }}"
                                    class="btn btn-primary edit-btn" data-toggle="modal"
                                    data-target="#editsubjectmodel">edit</button></td>
                            <td><a href="exam_type/{{ $type->id }}"><button type="button"
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
        <!-- Modal -->
        <div class="modal fade" id="addsubjectmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form id="addsubject" action="/addtype" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Type</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="type">type</label>
                            <input type="text" id="subject" name="type">
                        </div><br/><br/>
                        <input type="time" name="time" class="w-100" /><br/><br/>
                        <input type="text" name="marks" class="w-100" placeholder="enter marks per qeustion"><br/><br/>
                        <input type="text" name="attempt" class="w-100" placeholder="attempt"><br/><br/>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="editsubjectmodel" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form id="addsubject" method="post" action="{{ url('edittype') }}">
                    @csrf
                    {{-- @method('PUT') --}}
                    <input type="hidden" name="id" id="hiddeid">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">type</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="type">type</label>
                            <input type="text" id="edit-subject-input" name="type">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary update">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.edit-btn').click(function() {
                var subject = $(this).data('subject');
                var id = $(this).data('id');
                $('#hiddeid').val(id);
                $('#edit-subject-input').val(subject);
            });

        });
    </script>
@endsection



<!-- Button trigger modal -->
