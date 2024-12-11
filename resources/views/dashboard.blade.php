@extends('layouts.base')

@section('title', 'Dashboard')


@section('main')
    <div class="header pb-8 pt-5">
        <div class="container-fluid">
            <!-- HTML !-->
            <div class="header-body">
                <!-- Card stats -->
                <div class="row">
                    <div class="col-xl-2">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase mb-0" style="color:green !important;">Subjects
                                        </h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $subjects->count() }}</span>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-success mr-2"></span>
                                    <span class="text-nowrap"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase  mb-0" style="color:green !important;">Enrolled
                                            Student</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $uniqueStudents }}</span>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-success mr-2"></span>
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
                        <a id="add-button-modal" class="button-34">NEW SUBJECT</a>
                    </div>
                    <div style="padding: 1%;">
                        <table id="subjects" class="table" width="100%">
                            <thead>
                                <tr>
                                    <th class="th-sm">Subject</th>
                                    <th style="text-align: center">Enrolled Student</th>
                                    <th style="text-align: center">School Year</th>
                                    <th style="text-align: center">Semester</th>
                                    <th class="th-sm" style="width: 30%;text-align: center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subjects as $sb)
                                    <tr>
                                        <td>{{ $sb->subject_name }}</td>
                                        <td style="text-align: center">{{ $sb->student_count }}</td>
                                        <td style="text-align: center">{{ $sb->school_year }}</td>
                                        <td style="text-align: center">{{ $sb->semester }}</td>
                                        <td style="text-align: center">
                                            <a href="{{ route('grade.show', ['id' => $sb->id]) }}"
                                                class="btn btn-success btn-sm btn-flat">View</a>
                                            <a class="btn edit btn-secondary btn-sm btn-flat" data-id="{{ $sb->id }}"
                                                data-name="{{ $sb->subject_name }}" data-sem="{{ $sb->semester }}"
                                                data-sy="{{ $sb->school_year }}">Edit</a>
                                            <a class="btn btn-danger btn-sm btn-flat delete"
                                                data-id="{{ $sb->id }}">Delete</a>
                                            <a href="{{ route('subject.report', ['id' => $sb->id]) }}"
                                                class="btn btn-info sheet btn-sm btn-flat" data-action="2">Generate</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addSubejct">
        <div class="modal-dialog" role="document">
            <form action="{{ route('subject.store') }}" method="POST" id="addSub">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Subject</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group has-feedback">
                            @error('subject_name')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="subject_name">Subject Name:</label>
                            <input type="text" name="subject_name" maxlength="50" class="form-control" required=""
                                id="subject_name" placeholder="Enter Subject Name">
                        </div>
                        <div class="form-group has-feedback">
                            @error('sem')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="sem">Semester:</label>
                            <select name="sem" class="form-control" required="" id="sem"
                                placeholder="Select Semester">
                                <option value="" selected>--------</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            @error('sy')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="sy">School Year:</label>
                            <select name="sy" class="form-control" required="" id="sy"
                                placeholder="Select School Year">
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer custom-footer">
                        <button type="submit" class="btn btn-success btn-flat btn-add" name="add"><i
                                class="fa fa-save"></i>
                            Save</button>
                        <button type="button" class="btn btn-danger btn-flat pull-left btn-close-c"
                            onclick="$('#addSubejct').modal('hide')"><i class="fa fa-close"></i> Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="updateSubejct">
        <div class="modal-dialog" role="document">
            <form action="{{ route('subject.update') }}" method="POST" id="updateSub">
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
                        <div class="form-group has-feedback">
                            @error('sem')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="edit_sem">Semester:</label>
                            <select name="edit_sem" class="form-control" required="" id="edit_sem"
                                placeholder="Select Semester">
                                <option value="" selected>--------</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            @error('sy')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="edit_sy">School Year:</label>
                            <select name="edit_sy" class="form-control" required="" id="edit_sy"
                                placeholder="Select School Year">
                            </select>
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
            <form action="{{ route('subject.destroy') }}" method="POST" id="deleteSub">
                @csrf
                @method('delete')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Subject</h5>
                    </div>
                    <div class="modal-body">
                        <h2>Are you sure you want to delete this subject?</h2>
                        <input type="hidden" name="delete_id" id="delete_id">
                    </div>
                    <div class="modal-footer custom-footer" style="margin-top: 10px">
                        <button type="submit" class="btn btn-danger btn-flat" name="add"
                            style="background-color: red">
                            DELETE</button>
                        <button type="button" class="btn btn-danger btn-flat pull-left btn-close-c"
                            onclick="$('#deleteSubejct').modal('hide')"><i class="fa fa-close"></i> Close</button>
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

            const dropdown = document.getElementById("sy");
            const edit_dropdown = document.getElementById("edit_sy");
            const currentYear = new Date().getFullYear();
            const range = 3;
            opt = `<option value="" selected>--------</option>`

            for (let i = 0; i < range; i++) {
                const startYear = currentYear + i;
                const endYear = startYear + 1;
                const schoolYear = `${startYear}-${endYear}`;

                opt += `<option value="${schoolYear}">${schoolYear}</option>`
            }

            $("#sy").html(opt)
            $("#edit_sy").html(opt)

            $("#deleteSub").on("submit", function(e) {
                e.preventDefault()

                $.ajax({
                    url: "{{ route('subject.destroy') }}",
                    method: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}",
                        delete_id: $("#delete_id").val(),
                    },
                    success: function(response) {
                        swal({
                            title: "Success",
                            text: response.message,
                            icon: "success",
                            button: "Close"
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(err) {
                        swal({
                            title: "Error",
                            text: err.responseJSON.message,
                            icon: "error",
                            button: "Close"
                        })
                    }
                })
            })

            $(".sheet").on("click", function() {
                id = $(this).data("id")
                action = $(this).data("action")
                console.log(id, action);

            })

            $("#updateSub").on("submit", function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('subject.update') }}",
                    method: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        edit_subject_name: $("#edit_subject_name").val(),
                        edit_semester: $("#edit_sem").val(),
                        edit_sy: $("#edit_sy").val(),
                        edit_id: $("#edit_id").val()
                    },
                    success: function(response) {
                        swal({
                            title: "Success",
                            text: response.message,
                            icon: "success",
                            button: "Close"
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(err) {
                        swal({
                            title: "Error",
                            text: err.responseJSON.message,
                            icon: "error",
                            button: "Close"
                        })
                    }
                })
            })

            $("#addSub").on("submit", function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('subject.store') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        subject_name: $("#subject_name").val(),
                        semester: $("#sem").val(),
                        sy: $("#sy").val()
                    },
                    success: function(response) {
                        swal({
                            title: "Success",
                            text: response.message,
                            icon: "success",
                            button: "Close"
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(err) {
                        swal({
                            title: "Error",
                            text: err.responseJSON.message,
                            icon: "error",
                            button: "Close"
                        })
                    }
                })
            })

            $('.edit').on('click', function() {
                name = $(this).data('name')
                sem = $(this).data('sem')
                sy = $(this).data('sy')
                id = $(this).data('id')
                $("#edit_subject_name").val(name)
                $("#edit_sy").val(sy)
                $("#edit_sem").val(sem)
                $("#edit_id").val(id)
                $('#updateSubejct').modal('show')
            })

            $('.delete').on('click', function() {
                id = $(this).data('id')
                $("#delete_id").val(id)
                $('#deleteSubejct').modal('show')
            })

            $("#add-button-modal").on("click", function() {
                $('#addSubejct').modal('show')
                date = new Date()
                $("#sy").val(`${date.getFullYear()}-${date.getFullYear() + 1}`)
            })
        })
    </script>
@endsection
