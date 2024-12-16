@extends('admin.adminlayouts.app')
@section('content')
    <div id="content" class="p-4 p-md-5 pt-5">
        <h2 class="mb-4">Techonology</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addsubjectmodel">
            Add Techonology
        </button>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Techonology</th>
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
                @if (count($technology))
                    @foreach ($technology as $index => $technology)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $technology->technology }}</td>
                            <td><button type="button" data-subject="{{ $technology->technology }}" data-id="{{ $technology->id }}"
                                    class="btn btn-primary edit-btn" data-toggle="modal"
                                    data-target="#editsubjectmodel">edit</button></td>
                            <td><a href="delete/{{ $technology->id }}"><button type="button"
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
                <form id="addsubject" action="/addtechnology" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Technology</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="technology">Technology</label>
                            <input type="text" id="subject" name="technology">
                        </div>
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
                            <h5 class="modal-title" id="exampleModalLongTitle">Technology</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="subject">Technology</label>
                            <input type="text" id="edit-subject-input" name="techonology">
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
