@extends('layouts.base')

@section('title', 'Student')

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
                                        <h5 class="card-title text-muted text-uppercase mb-0">Enrolled Student</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $students->count() }}</span>
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
                        <h3 class="mb-0" style="float: left;">Students</h3>
                        <a onclick="$('#addStudent').modal('show')" class="button-34 button-35"><i class="fa fa-plus"></i>
                            ADD STUDENT</a>
                        <a onclick="$('#uploadStudent').modal('show')" class="button-34"
                            style="margin-right: 10px">UPLOAD</a>
                    </div>
                    <div style="padding: 1%;">
                        <table id="subjects" class="table table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th class="th-sm">Name</th>
                                    <th style="text-align: center">Course</th>
                                    <th style="text-align: center">Year</th>
                                    <th style="text-align: center">Section</th>
                                    <th style="text-align: center; width: 15%!important" class="th-sm w-25"
                                        style="width: 30%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $s)
                                    <tr>
                                        <td>{{ $s->name }}</td>
                                        <td style="text-align: center">{{ $s->course }}</td>
                                        <td style="text-align: center">{{ $s->year }}</td>
                                        <td style="text-align: center">{{ $s->section }}</td>
                                        <td>
                                            <a href="#updateStudent" class="btn btn-sm btn-flat btn-user-data"
                                                data-id="{{ $s->id }}">
                                                <i class="fa fa-pen" style="color:  white !important"></i>
                                            </a>
                                            <a class="btn btn-sm btn-flat btn-danger delete" data-id="{{ $s->id }}">
                                                <i class="fa fa-trash" style="color:  white !important"></i>
                                            </a>
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

    <div class="modal fade " id="addStudent">
        <div class="modal-dialog" role="document">
            <form action="{{ route('student.store') }}" method="POST" id="addModal">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">NEW STUDENT</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group has-feedback">
                            @error('name')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="name">Fullname:</label>
                            <input type="text" name="name" maxlength="50" class="form-control" required id="name"
                                placeholder="Fullname">
                        </div>
                        <div class="form-group has-feedback">
                            @error('student_id')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="student_id">Student ID:</label>
                            <input type="text" name="student_id" maxlength="8" minlength="8" class="form-control"
                                required id="student_id" placeholder="Student ID">
                        </div>
                        <div class="form-group has-feedback">
                            @error('course')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="course">Course:</label>
                            <input type="text" name="course" maxlength="50" class="form-control" required id="course"
                                placeholder="Course">
                        </div>
                        <div class="form-group has-feedback">
                            @error('year')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="year">Year Level:</label>
                            <select name="year" maxlength="50" class="form-control" required id="year"
                                placeholder="Year Level">
                                <option value="" selected>-----------</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            @error('section')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="section">Section:</label>
                            <select name="section" class="form-control" required id="section" placeholder="Section">
                                <option value="" selected>-------</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-flat btn-add" name="add"><i
                                class="fa fa-plus"></i>
                            ADD</button>
                        <button type="button" class="btn btn-danger btn-flat pull-left btn-close-c"
                            onclick="$('#addStudent').modal('hide')"><i class="fa fa-close"></i> Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" data-bs-backdrop='static' id="uploadStudent">
        <div class="modal-dialog" role="document">
            <form action="{{ route('student.upload') }}" method="POST" enctype="multipart/form-data" id="formUpload">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">UPLOAD STUDENT</h5>
                    </div>
                    <div class="modal-body">
                        <div id="form-div">
                            <label for="filedata">
                                <div class="student-upload" ondrop="handleDrop(event)"
                                    ondragover="handleDragOver(event)">
                                    <img src="{{ asset('images/upload.png') }}" width="100px" height="100px"
                                        id="no_upload">
                                    <img src="{{ asset('images/uploaded.png') }}" width="100px" height="100px"
                                        id="uploaded" style="display: none">
                                </div>
                            </label>
                            <input onchange="changeUploadicon()" type="file" accept=".csv, .xlsx" name="filedata"
                                id="filedata" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-flat btn-add" name="add"><i
                                class="fa fa-plus"></i>
                            UPLOAD</button>
                        <button type="button" class="btn btn-danger btn-flat pull-left btn-close-c"
                            onclick="$('#uploadStudent').modal('hide')"><i class="fa fa-close"></i> Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="updateStudent">
        <div class="modal-dialog" role="document">
            <form action="#" method="POST" id="update_form">
                @csrf
                @method('put')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">UPDATE STUDENT</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="s_id" id="s_id">
                        <div class="form-group has-feedback">
                            @error('name')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="update_name">Fullname:</label>
                            <input type="text" name="update_name" maxlength="50" class="form-control" required
                                id="update_name" placeholder="Fullname">
                        </div>
                        <div class="form-group has-feedback">
                            @error('student_id')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="update_student_id">Student ID:</label>
                            <input type="text" name="update_student_id" maxlength="8" minlength="8"
                                class="form-control" required id="update_student_id" placeholder="Student ID">
                        </div>
                        <div class="form-group has-feedback">
                            @error('course')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="update_course">Course:</label>
                            <input type="text" name="update_course" maxlength="50" class="form-control" required
                                id="update_course" placeholder="Course">
                        </div>
                        <div class="form-group has-feedback">
                            @error('year')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="update_year">Year Level:</label>
                            <select name="update_year" maxlength="50" class="form-control" required id="update_year"
                                placeholder="Year Level">
                                <option value="" selected>-----------</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            @error('section')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="update_section">Section:</label>
                            <select name="update_section" class="form-control" required id="update_section"
                                placeholder="Section">
                                <option value="" selected>-------</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-flat btn-add" name="add"><i
                                class="fa fa-plus"></i>
                            UPDATE</button>
                        <button type="button" class="btn btn-danger btn-flat pull-left btn-close-c"
                            onclick="$('#updateStudent').modal('hide')"><i class="fa fa-close"></i> Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="deleteGrade">
        <div class="modal-dialog" role="document">
            <form action="#" method="POST" id="deleteModal">
                @csrf
                @method('delete')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">DELETE STUDENT</h5>
                    </div>
                    <div class="modal-body">
                        <h2>ARE YOU SURE YOU WANT TO DELETE THIS STUDENT?</h2>
                        <input type="hidden" name="delete_id" id="delete_id">
                    </div>
                    <div class="modal-footer custom-footer" style="margin-top: 10px">
                        <button type="submit" class="btn btn-danger btn-flat" name="add"
                            style="background-color: red">
                            DELETE</button>
                        <button type="button" class="btn btn-danger btn-flat pull-left btn-close-c"
                            onclick="$('#deleteGrade').modal('hide')"><i class="fa fa-close"></i> Close</button>
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

            $("#deleteModal").on("submit", function(e) {
                e.preventDefault();
                id = $("#delete_id").val()
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('student.destroy') }}",
                    dataType: "json",
                    data: {
                        _token: '{{ csrf_token() }}',
                        delete_id: id
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
                    }
                })

            })

            $("#student_id").on("keypress", function(event) {
                const key = event.key
                if (/^[0-9]$/.test(key) || key === '-') {} else {
                    event.preventDefault()
                }
            })

            $("#formUpload").on("submit", function(e) {
                e.preventDefault();

                let formData = new FormData($('#formUpload')[0]);

                $.ajax({
                    url: "{{ route('student.upload') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        error_m = ""
                        if (response.errors.length >= 1) {
                            error_m =
                                `Success but student error below:\n${response.errors.join(', ')}.`
                        }
                        swal({
                            title: "Success",
                            text: `${response.message}\n${error_m}`,
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

            $(".btn-user-data").on("click", function(e) {
                e.preventDefault()
                id = $(this).data('id')
                $.ajax({
                    type: "GET",
                    url: "{{ route('student.all') }}",
                    dataType: "json",
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        $("#update_name").val(response.personal.name)
                        $("#update_student_id").val(response.personal.student_id);
                        $("#update_course").val(response.personal.course);
                        $("#update_year").val(response.personal.year)
                        $("#update_section").val(response.personal.section)
                        $("#s_id").val(id)
                        $('#updateStudent').modal('show')
                    }
                })
            })

            $("#addModal").on("submit", function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('student.store') }}",
                    dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: $("#name").val(),
                        student_id: $("#student_id").val(),
                        course: $("#course").val(),
                        year: $("#year").val(),
                        section: $("#section").val()
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
                    error: function(errr) {
                        swal({
                            title: "Error",
                            text: errr.responseJSON.message,
                            icon: "error",
                            button: "Close"
                        })
                    }

                })
            })

            $('.delete').on('click', function() {
                id = $(this).data('id')
                $("#delete_id").val(id)
                $('#deleteGrade').modal('show')
            })

            $("#update_form").on("submit", (e) => {
                e.preventDefault();
                update_name = $("#update_name").val()
                update_student_id = $("#update_student_id").val()
                update_course = $("#update_course").val()
                update_year = $("#update_year").val()
                update_section = $("#update_section").val()
                s_id = $("#s_id").val()

                $.ajax({
                    type: "PUT",
                    url: "{{ route('student.update') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        update_name: update_name,
                        update_student_id: update_student_id,
                        update_course: update_course,
                        update_year: update_year,
                        update_section: update_section,
                        id: s_id
                    },
                    success: function(response) {
                        swal({
                            title: "Success",
                            text: "Data Updated",
                            icon: "success",
                            button: "OK"
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(errr) {
                        swal({
                            title: "Error",
                            text: errr.responseJSON.message,
                            icon: "error",
                            button: "Close"
                        })

                    }
                })
            })
        })

        function changeUploadicon() {
            $("#no_upload").css('display', 'none')
            $("#uploaded").css('display', 'block')
        }


        function handleDragOver(event) {
            event.preventDefault()
            event.dataTransfer.dropEffec = "copy"
        }


        function handleDrop(event) {
            event.preventDefault()
            console.log(event.dataTransfer);

            const files = event.dataTransfer.files;


            const fileInput = document.getElementById("filedata");
            fileInput.files = files;

            $("#no_upload").css('display', 'none')
            $("#uploaded").css('display', 'block')
        }
    </script>
@endsection
