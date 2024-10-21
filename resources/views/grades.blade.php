@extends('layouts.base')

@section('title', 'Dashboard')


@section('main')
    <div class="header bg-gradient-primary pb-8 pt-5">
        <div class="container-fluid">
            <!-- HTML !-->
            <div class="header-body">
                <!-- Card stats -->
                <div class="row">
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Enrolled Student</h5>
                                        <span class="h2 font-weight-bold mb-0">0</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                            <i class="fa fa-layer-group"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-success mr-2"></span>
                                    <span class="text-nowrap"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Passed</h5>
                                        <span class="h2 font-weight-bold mb-0">0</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-danger mr-2"></span>
                                    <span class="text-nowrap"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Failed</h5>
                                        <span class="h2 font-weight-bold mb-0">0</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-danger mr-2"></span>
                                    <span class="text-nowrap"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--7">

        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0" style="float: left;">Subjects</h3>
                        <a onclick="$('#addStudent').modal('show')" class="button-34">Add Student</a>
                    </div>
                    <div style="padding: 1%;">
                        <table id="subjects" class="table table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th class="th-sm">Name</th>
                                    <th style="text-align: center">First Semester</th>
                                    <th style="text-align: center">Second Semester</th>
                                    <th style="text-align: center">Final Grade</th>
                                    <th class="th-sm" style="width: 30%">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addStudent">
        <div class="modal-dialog" role="document">
            <form action="{{ route('grade.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Enroll Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" onclick="$('#addStudent').modal('hide')">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group has-feedback">
                            @error('student_id')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="student_id">Student:</label>
                            <select name="student_id" maxlength="50" class="form-control" required id="student_id">
                            </select>
                        </div>

                        <input type="hidden" name="subject_id" id="subject_id" value="{{$id}}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-flat pull-left"
                            onclick="$('#addStudent').modal('hide')"><i class="fa fa-close"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat" name="add"><i class="fa fa-save"></i>
                            Enroll</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="updateSubejct">
        <div class="modal-dialog" role="document">
            <form action="{{ route('subject.update') }}" method="POST">
                @csrf
                @method('put')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Subject</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" onclick="$('#updateSubejct').modal('hide')">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_id" id="edit_id">
                        <div class="form-group has-feedback">
                            @error('subject_name')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="edit_subject_name">Subject:</label>
                            <input type="text" name="edit_subject_name" maxlength="50" class="form-control"
                                required="" id="edit_subject_name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-flat pull-left"
                            onclick="$('#updateSubejct').modal('hide')"><i class="fa fa-close"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat" name="add"><i
                                class="fa fa-save"></i>
                            Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="deleteSubejct">
        <div class="modal-dialog" role="document">
            <form action="{{ route('subject.destroy') }}" method="POST">
                @csrf
                @method('delete')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Subject</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" onclick="$('#deleteSubejct').modal('hide')">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h2>Are you sure you want to delete this subject?</h2>
                        <input type="hidden" name="delete_id" id="delete_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-flat pull-left"
                            onclick="$('#deleteSubejct').modal('hide')"><i class="fa fa-close"></i> Close</button>
                        <button type="submit" class="btn btn-danger btn-flat" name="add"><i class="fa fa-save"></i>
                            Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let table = new DataTable("#subjects");


            $('.edit').on('click', function() {
                name = $(this).data('name')
                id = $(this).data('id')
                $("#edit_subject_name").val(name)
                $("#edit_id").val(id)
                $('#updateSubejct').modal('show')
            })

            $('.delete').on('click', function() {
                id = $(this).data('id')
                $("#delete_id").val(id)
                $('#deleteSubejct').modal('show')
            })

            $("#student_id").select2({
                width: "100%",
                placeholder: "Enter one or more character!",
                minimumInputLength: 1,
                ajax: {
                    url: "{{ route('user.api') }}",
                    dataType: 'json',
                    data: function(data) {
                        return {
                            q: $.trim(data.term)
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            })
        })
    </script>
@endsection
