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
                                    <th style="text-align: center">First Semester</th>
                                    <th style="text-align: center">Second Semester</th>
                                    <th style="text-align: center">Final Grade</th>
                                    <th style="text-align: center">Remark</th>
                                    <th style="text-align: center">Status</th>
                                    <th style="text-align: center; width: 15%!important" class="th-sm w-25"
                                        style="width: 30%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    @php
                                        if ($d->first_sem && $d->second_sem) {
                                            $average =
                                                ($d->first_sem + $d->second_sem) / 2
                                                    ? ($d->first_sem + $d->second_sem) / 2
                                                    : 'N/A';
                                        } else {
                                            $average = 'N/A';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $d->last_name }}, {{ $d->first_name }}</td>
                                        <td style="text-align: center">{{ $d->first_sem ? $d->first_sem : 'N/A' }}</td>
                                        <td style="text-align: center">{{ $d->second_sem ? $d->second_sem : 'N/A' }}</td>
                                        <td style="text-align: center">{{ $average }}</td>
                                        <td style="text-align: center">
                                            @if (!$d->first_sem || !$d->second_sem)
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
                                                data-id="{{ $d->student_id }}">
                                                <i class="fa fa-gear" style="color:  white !important"></i>
                                            </a>
                                            <a class="btn btn-sm btn-flat btn-user-view" data-id="{{ $d->student_id }}">
                                                <i class="fa fa-eye" style="color:  white !important"></i>
                                            </a>
                                            <a class="btn btn-sm btn-flat btn-danger delete"
                                                data-id="{{ $d->id }}">
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

    <div class="modal fade " id="uploadStudent">
        <div class="modal-dialog" role="document">
            <form action="{{ route('grade.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">UPLOAD STUDENT</h5>
                    </div>
                    <div class="modal-body">
                        <div id="drop-area">
                            <div class="my-form">
                                <p>Upload file with the file dialog or by dragging and dropping csv file onto the
                                    dashed region.</p>
                                <input type="file" id="fileElem" accept=".csv">
                                <label class="button" for="fileElem">Select some files</label>
                                <div id="file-name"></div>
                            </div>
                        </div>
                        <input type="hidden" name="subject_id" id="subject_id" value="{{ $subject->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-flat btn-add" name="add"><i
                                class="fa fa-plus"></i>
                            ADD</button>
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
                        <h5 class="modal-title">NEW STUDENT</h5>
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
                            @error('first_sem')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="first_sem">First Semester:</label>
                            <input name="first_sem" maxlength="50" class="form-control" required id="first_sem">
                        </div>
                        <div class="form-group has-feedback">
                            @error('second_sem')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="second_sem">Second Semester:</label>
                            <input name="second_sem" maxlength="50" class="form-control" required id="second_sem">
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
                        <tbody>
                            <tr class="report-tr">
                                <td class="report-td" style="text-align: left">DAA</td>
                                <td class="report-td">1.1</td>
                                <td class="report-td">3.5</td>
                                <td class="report-td">2.3</td>
                            </tr>
                            <tr class="report-tr">
                                <td class="report-td" style="text-align: left">SE</td>
                                <td class="report-td">1.1</td>
                                <td class="report-td">3.5</td>
                                <td class="report-td">2.3</td>
                            </tr>
                            <tr class="report-tr">
                                <td class="report-td" style="text-align: left">Programming 1</td>
                                <td class="report-td">1.1</td>
                                <td class="report-td">3.5</td>
                                <td class="report-td">2.3</td>
                            </tr>
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
            const dropArea = document.getElementById('drop-area');
            const fileInput = document.getElementById('fileElem');
            const fileNameDisplay = document.getElementById('file-name');


            ;
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false)
            })

            ;
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false)
            })

            function highlight(e) {
                dropArea.classList.add('highlight')
            }

            function unhighlight(e) {
                dropArea.classList.remove('highlight')
            }

            fileInput.addEventListener('change', handleFileSelect);

            dropArea.addEventListener('dragover', (event) => {
                event.preventDefault();
                dropArea.classList.add('dragging');
            });

            dropArea.addEventListener('dragleave', () => {
                dropArea.classList.remove('dragging');
            });

            dropArea.addEventListener('drop', (event) => {
                event.preventDefault();
                dropArea.classList.remove('dragging');
                const files = event.dataTransfer.files;
                console.log(files);

                if (files.length > 0) {
                    updateFileName(files[0]);
                }
            });

            function updateFileName(file) {
                fileNameDisplay.textContent = `Selected file: ${file.name}`;
            }

            function handleFileSelect(event) {
                const files = event.target.files;
                if (files.length > 0) {
                    updateFileName(files[0]);
                }
            }


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
                    }, error: function(errr) {
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

            $("#status").on("change", function(e) {
                console.log($(this).val());

                if ($(this).val() == "dropped") {
                    $("#second_sem").attr('readonly', true);
                    $("#first_sem").attr('readonly', true);
                } else {
                    $("#second_sem").attr('readonly', false);
                    $("#first_sem").attr('readonly', false);
                }

            })

            $(".btn-user-view").on("click", function() {
                id = $(this).data('id')
                if (id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('grade.api') }}",
                        dataType: "json",
                        data: {
                            id: id,
                            s_id: "{{ $subject->id }}"
                        },
                        success: function(response) {
                            $("#student-name").html(response.first_name + " " + response
                                .middle_name +
                                " " + response.last_name)
                            $("#student-id").html(response.student_id);
                            $("#student-course").html(
                                `<span class="fa fa-graduation-cap"></span > ${response.course}`
                            );
                            $("#student-year-sec").html(
                                `<span class="fa fa-book-open"></span> ${response.year}-${response.section}`
                            )
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

            })

            $(".btn-user-data").on("click", function() {

                id = $(this).data('id')
                $.ajax({
                    type: "GET",
                    url: "{{ route('grade.api') }}",
                    dataType: "json",
                    data: {
                        id: id,
                        s_id: "{{ $subject->id }}"
                    },
                    success: function(response) {
                        $("#fullname").val(response.first_name + " " + response.middle_name +
                            " " + response.last_name)
                        $("#first_sem").val(response.first_sem ? response.first_sem : 0);
                        $("#second_sem").val(response.second_sem ? response.second_sem : 0);
                        $("#grade_id").val(response.id)
                        $("#status").val(response.status)
                        if (response.status == "dropped") {
                            $("#second_sem").attr('readonly', true);
                            $("#first_sem").attr('readonly', true);
                        } else {
                            $("#second_sem").attr('readonly', false);
                            $("#first_sem").attr('readonly', false);
                        }
                        $('#updateStudent').modal('show')
                    }
                })
            })

            $("#update_form").on("submit", (e) => {
                e.preventDefault();
                first_sem = $("#first_sem").val()
                second_sem = $("#second_sem").val()
                status = $("#status").val()
                g_id = $("#grade_id").val()
                fullname = $("#fullname").val()

                $.ajax({
                    type: "PUT",
                    url: "{{ route('grade.update') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        fullname: fullname,
                        grade_id: g_id,
                        status: status,
                        first_sem: first_sem,
                        second_sem: second_sem
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
                        console.log(errr.responseJSON);

                    }
                })
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
