@extends('layouts.base')

@section('title', 'Dashboard')

@section('back')
    <a href="{{ route('subject.show') }}" class="fa fa-arrow-left fa-xl"></a>
@endsection

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
                                        <span class="h2 font-weight-bold mb-0 enrolled">{{ $data->count() }}</span>
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
                                        <h5 class="card-title text-muted text-uppercase mb-0">Passed</h5>
                                        <span class="h2 font-weight-bold passed mb-0">{{ $passed }}</span>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-danger mr-2"></span>
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
                                        <h5 class="card-title text-muted text-uppercase mb-0">Failed</h5>
                                        <span class="h2 font-weight-bold failed mb-0">{{ $failed }}</span>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-danger mr-2"></span>
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
                                        <h5 class="card-title text-muted text-uppercase mb-0">No Grade</h5>
                                        <span class="h2 font-weight-bold mb-0 no-grade">{{ $no_grades }}</span>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-danger mr-2"></span>
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
                                        <h5 class="card-title text-muted text-uppercase mb-0">Dropped</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $dropped }}</span>
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
                        <h3 class="mb-0" style="float: left;">{{ $subject->subject_name }}</h3>
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
                                    <th style="text-align: center">Midterm</th>
                                    <th style="text-align: center">Final</th>
                                    <th style="text-align: center">Average</th>
                                    <th style="text-align: center">Remark</th>
                                    <th style="text-align: center">Status</th>
                                    <th style="text-align: center; width: 15%!important" class="th-sm w-25"
                                        style="width: 30%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    @php
                                        if ($d->midterm && $d->final) {
                                            $average =
                                                ($d->midterm + $d->final) / 2 ? ($d->midterm + $d->final) / 2 : 'N/A';
                                        } else {
                                            $average = 'N/A';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $d->name }}</td>
                                        <td style="text-align: center">{{ $d->midterm ? $d->midterm : 'N/A' }}</td>
                                        <td style="text-align: center">{{ $d->final ? $d->final : 'N/A' }}</td>
                                        <td style="text-align: center">{{ $average }}</td>
                                        <td style="text-align: center">
                                            @if (!$d->midterm || !$d->final)
                                                <b class="remark no_grade">NO GRADE</b>
                                            @else
                                                @if ($average == 'N/A')
                                                    N/A
                                                @elseif ($average > 3)
                                                    <b class="remark failing">FAILED</b>
                                                @else
                                                    <b class="remark passing">PASSED</b>
                                                @endif
                                            @endif
                                        </td>
                                        <td style="text-align: center">{{ $d->status }}</td>
                                        <td style="text-align: center">
                                            <a href="#updateStudent" class="btn btn-sm btn-flat btn-user-data"
                                                onclick="showUserData('{{ $d->student_id }}')">
                                                <i class="fa fa-gear" style="color:  white !important"></i>
                                            </a>
                                            <a class="btn btn-sm btn-flat btn-user-view"
                                                onclick='showGRade("{{ $d->student_id }}")'>
                                                <i class="fa fa-eye" style="color:  white !important"></i>
                                            </a>
                                            <a class="btn btn-sm btn-flat btn-danger delete"
                                                onclick="deleteF('{{ $d->id }}')">
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
        <div class="modal-dialog" role="document" id="addModal">
            <form action="#" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">NEW STUDENT</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group has-feedback">
                            @error('student_id')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="student_id">Fullname / Student ID:</label>
                            <select name="student_id" maxlength="50" class="form-control" required id="student_id">
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
            <form action="{{ route('grade.upload') }}" method="POST" enctype="multipart/form-data" id="formUpload">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">UPLOAD GRADESHEET</h5>
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
                        <div class="modal-body" id="add_progress" style="display: none;">
                            <p class="text-center" id="ajax_return"></p>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated active"
                                    role="progressbar" style="width: 2%" id="progress-bar"></div>
                            </div>
                        </div>
                        <input type="hidden" name="subject_id" id="subject_id" value="{{ $subject->id }}">
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
                        <h5 class="modal-title">UPDATE STUDENT DATA</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group has-feedback">
                            @error('fullname')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="fullname">Fullname:</label>
                            <input name="fullname" maxlength="50" readonly class="form-control" required id="fullname">
                        </div>
                        <div class="form-group has-feedback">
                            @error('status')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="status">Status:</label>
                            <select name="status" class="form-control" required id="status">
                                <option value="active">Active</option>
                                <option value="dropped">Dropped</option>
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="midterm">Midterm:</label>
                            <input type="text" name="midterm" maxlength="3" class="form-control" required
                            id="midterm">
                            <span class="text-danger" id="midterm-error"></span>
                        </div>
                        <div class="form-group has-feedback">
                            @error('final')
                                <span class="text-danger" id="final-error"> {{ $message }} </span>
                            @enderror
                            <label for="final">Final:</label>
                            <input type="text" name="final" maxlength="3" class="form-control" required
                                id="final">
                        </div>
                        <input type="hidden" name="grade_id" id="grade_id">
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
                        <h5 class="modal-title">DELETE STUDENT DATA</h5>
                    </div>
                    <div class="modal-body">
                        <h2>ARE YOU SURE YOU WANT TO DELETE THIS STUDENT DATA?</h2>
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


    <div class="modal fade" id="studentGrade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">STUDENT GRADE REPORT</h5>
                </div>
                <div class="modal-body student-data-container">
                    <div class="student-header">
                        <i class="fa-regular fa-user" style="color:black;">
                            <b> Student Information</b>
                        </i>
                    </div>
                    <div class="data-info">
                        <div class="left">
                            <p class="info-title">Name</p>
                            <b id="student-name"></b>
                        </div>
                        <div class="right">
                            <p class="info-title">Student ID</p>
                            <b id="student-id"></b>
                        </div>
                    </div>
                    <div class="data-info">
                        <div class="left">
                            <p class="info-title">Course</p>
                            <b id="student-course"></b>
                        </div>
                        <div class="right">
                            <p class="info-title">Year and Section</p>
                            <b id="student-year-sec"> </b>
                        </div>
                    </div>
                    <div class="student-header" style="margin-top: 40px">
                        <b class="acdmc"><span class="fa fa-book-open"></span> Academic Performance</b>
                    </div>
                    <table class="report-table">
                        <thead>
                            <tr class="report-tr">
                                <th class="report-th" style="text-align: left">Subject</th>
                                <th class="report-th">1st Sem</th>
                                <th class="report-th">2nd Sem</th>
                                <th class="report-th">Average</th>
                            </tr>
                        </thead>
                        <tbody id="grade-tbody">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer custom-footer" style="margin-top: 10px">
                    <button type="button" class="btn btn-danger btn-flat pull-left btn-close-c"
                        onclick="$('#studentGrade').modal('hide')"><i class="fa fa-close"></i> Close</button>
                </div>
            </div>
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
                    url: "{{ route('grade.destroy') }}",
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

            $("#formUpload").on("submit", function(e) {
                e.preventDefault();

                let formData = new FormData($('#formUpload')[0]);

                $.ajax({
                    url: "{{ route('grade.upload') }}",
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

            $("#addModal").on("submit", function(e) {
                e.preventDefault();
                let id = $("#student_id").val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('grade.store') }}",
                    dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}",
                        student_id: id,
                        subject_id: "{{ $subject->id }}"
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

            $("#status").on("change", function(e) {

                if ($(this).val() == "dropped") {
                    $("#final").attr('readonly', true);
                    $("#midterm").attr('readonly', true);
                } else {
                    $("#final").attr('readonly', false);
                    $("#midterm").attr('readonly', false);
                }

            })

            $("#update_form").on("submit", (e) => {
                e.preventDefault();
                midterm = $("#midterm").val()
                final = $("#final").val()
                status = $("#status").val()
                g_id = $("#grade_id").val()
                fullname = $("#fullname").val()

                if (!checkGrade(midterm) || !checkGrade(final)) {
                    if (!checkGrade(midterm)) {
                        console.log("HERE");

                        $("#midterm-error").text('Accepted: INC, 0, 1.0 - 5.0')
                    }

                    if (!checkGrade(midterm)) {

                    }
                } else {

                    $.ajax({
                        type: "PUT",
                        url: "{{ route('grade.update') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            fullname: fullname,
                            grade_id: g_id,
                            status: status,
                            midterm: midterm,
                            final: final
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
                }
            })

            $("#student_id").select2({
                width: "100%",
                placeholder: "Enter one or more character!",
                minimumInputLength: 1,
                ajax: {
                    url: "{{ route('student.api') }}",
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

        function checkGrade(grade) {
            const acceptedValues = ['INC', '0'];
            const numericPattern = /^(1(\.\d+)?|2(\.\d+)?|3(\.\d+)?|4(\.\d+)?|5(\.0+)?)$/;

            if (acceptedValues.includes(grade) || numericPattern.test(grade)) {
                return true
            }
            return false
        }

        function deleteF(id) {
            $("#delete_id").val(id)
            $('#deleteGrade').modal('show')
        }

        function showGRade(id) {
            if (id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('student.dataApi') }}",
                    dataType: "json",
                    data: {
                        id: id,
                        i_id: "{{ Auth::user()->id }}"
                    },
                    success: function(response) {
                        $("#student-name").html(response.personal.name)
                        $("#student-id").html(response.personal.student_id);
                        $("#student-course").html(
                            `<span class="fa fa-graduation-cap"></span > ${response.personal.course}`
                        );
                        $("#student-year-sec").html(
                            `<span class="fa fa-book-open"></span> ${response.personal.year}-${response.personal.section}`
                        )

                        tr_data = ""
                        response.grades.forEach(element => {
                            let final_g = "No Grade"

                            if (element.midterm && element.final) {
                                final_g = (element.midterm + element.final) / 2
                            }
                            tr_data += `
                                <tr class="report-tr">
                                    <td class="report-td" style="text-align: left">${element.subject_name}</td>
                                    <td class="report-td">${element.midterm ? element.midterm : "No grade"}</td>
                                    <td class="report-td">${element.final ? element.final : "No grade"}</td>
                                    <td class="report-td">${final_g}</td>
                                </tr>
                             `
                        });
                        $("#grade-tbody").html(tr_data)
                        $('#studentGrade').modal('show')
                    }
                })
            } else {
                swal({
                    title: "Error",
                    text: "Something went wrong!",
                    icon: "error",
                    button: "Close"
                }).then(() => {
                    window.location.reload();
                });
            }
        }

        function showUserData(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('grade.api') }}",
                dataType: "json",
                data: {
                    id: id,
                    s_id: "{{ $subject->id }}"
                },
                success: function(response) {
                    $("#fullname").val(response.name)
                    $("#midterm").val(response.midterm ? response.midterm : 0);
                    $("#final").val(response.final ? response.final : 0);
                    $("#grade_id").val(response.id)
                    $("#status").val(response.status)
                    if (response.status == "dropped") {
                        $("#final").attr('readonly', true);
                        $("#midterm").attr('readonly', true);
                    } else {
                        $("#final").attr('readonly', false);
                        $("#midterm").attr('readonly', false);
                    }
                    $('#updateStudent').modal('show')
                }
            })
        }

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

            const files = event.dataTransfer.files;


            const fileInput = document.getElementById("filedata");
            fileInput.files = files;

            $("#no_upload").css('display', 'none')
            $("#uploaded").css('display', 'block')
        }
    </script>
@endsection
