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
                                        <h5 class="card-title text-muted text-uppercase mb-0">USERS</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $users->count() }}</span>
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
                        <h3 class="mb-0" style="float: left;">Users</h3>
                        <a onclick="$('#addUser').modal('show')" class="button-34 button-35"><i class="fa fa-plus"></i>
                            ADD USER</a>
                    </div>
                    <div style="padding: 1%;">
                        <table id="subjects" class="table table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 20%;" class="th-sm">Name</th>
                                    <th style="width: 20%;">Username</th>
                                    <th style="width: 20%">Role</th>
                                    <th style="text-align: center; width: 10%!important" class="th-sm w-25">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $usr)
                                    <tr>
                                        <td>{{ $usr->name }}</td>
                                        <td>{{ $usr->username }}</td>
                                        <td>{{ $usr->user_type == 1 ? "Admin" : "Faculty" }}</td>
                                        <td style="text-align: center;">
                                            <a href="#updateUser" class="btn btn-sm btn-flat btn-user-data"
                                                data-id="{{ $usr->id }}">
                                                <i class="fa fa-pen" style="color:  white !important"></i>
                                            </a>
                                            <a class="btn btn-sm btn-flat btn-danger delete" data-id="{{ $usr->id }}">
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

    <div class="modal fade " id="addUser">
        <div class="modal-dialog" role="document">
            <form action="{{ route('user.store') }}" method="POST" id="addModal">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">NEW USER</h5>
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
                            @error('username')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="username">Username:</label>
                            <input type="text" name="username" maxlength="30" class="form-control" required
                                id="username" placeholder="Username">
                        </div>
                        <div class="form-group has-feedback">
                            @error('password')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="password">Password:</label>
                            <input type="password" name="password" maxlength="30" minlength="8" class="form-control"
                                required id="password" placeholder="Password">
                        </div>
                        <div class="form-group has-feedback">
                            @error('type')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="type">User Type:</label>
                            <select name="type" maxlength="50" class="form-control" required id="type"
                                placeholder="User Type">
                                <option value="" selected>-----------</option>
                                <option value="1">Admin</option>
                                <option value="2">Faculty</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-flat btn-add" name="add"><i
                                class="fa fa-plus"></i>
                            ADD</button>
                        <button type="button" class="btn btn-danger btn-flat pull-left btn-close-c"
                            onclick="$('#addUser').modal('hide')"><i class="fa fa-close"></i> Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="updateUser">
        <div class="modal-dialog" role="document">
            <form action="#" method="POST" id="update_form">
                @csrf
                @method('put')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">UPDATE USER</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="u_id" id="u_id">
                        <div class="form-group has-feedback">
                            @error('name')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="update_name">Fullname:</label>
                            <input type="text" name="update_name" maxlength="50" class="form-control" required
                                id="update_name" placeholder="Fullname">
                        </div>
                        <div class="form-group has-feedback">
                            @error('username')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="update_username">Username:</label>
                            <input type="text" name="update_username" maxlength="30" class="form-control" required
                                id="update_username" placeholder="Username">
                        </div>
                        <div class="form-group has-feedback">
                            @error('password')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="update_password">Password:</label>
                            <input type="text" name="update_password" maxlength="30" minlength="8"
                                class="form-control" id="update_password" placeholder="Password">
                            <span class="text-danger" style="font-size: 10px !important">Input to change the
                                password!</span>
                        </div>
                        <div class="form-group has-feedback">
                            @error('type')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                            <label for="update_type">User Type:</label>
                            <select name="update_type" class="form-control" required id="update_type"
                                placeholder="User Type">
                                <option value="" selected>-----------</option>
                                <option value="1">Admin</option>
                                <option value="2">Faculty</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-flat btn-add" name="add"><i
                                class="fa fa-plus"></i>
                            UPDATE</button>
                        <button type="button" class="btn btn-danger btn-flat pull-left btn-close-c"
                            onclick="$('#updateUser').modal('hide')"><i class="fa fa-close"></i> Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="deleteUser">
        <div class="modal-dialog" role="document">
            <form action="#" method="POST" id="deleteModal">
                @csrf
                @method('delete')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">DELETE USER</h5>
                    </div>
                    <div class="modal-body">
                        <h2>ARE YOU SURE YOU WANT TO DELETE THIS USER?</h2>
                        <input type="hidden" name="delete_id" id="delete_id">
                    </div>
                    <div class="modal-footer custom-footer" style="margin-top: 10px">
                        <button type="submit" class="btn btn-danger btn-flat" name="add"
                            style="background-color: red">
                            DELETE</button>
                        <button type="button" class="btn btn-danger btn-flat pull-left btn-close-c"
                            onclick="$('#deleteUser').modal('hide')"><i class="fa fa-close"></i> Close</button>
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
                    url: "{{ route('user.destroy') }}",
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

            $(".btn-user-data").on("click", function() {

                id = $(this).data('id')
                $.ajax({
                    type: "GET",
                    url: "{{ route('user.dataApi') }}",
                    dataType: "json",
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        $("#update_name").val(response.data.name)
                        $("#update_username").val(response.data.username);
                        $("#update_course").val(response.data.course);
                        $("#update_type").val(response.data.user_type)
                        $("#u_id").val(id)
                        $('#updateUser').modal('show')
                    }
                })
            })

            $("#addModal").on("submit", function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('user.store') }}",
                    dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: $("#name").val(),
                        username: $("#username").val(),
                        password: $("#password").val(),
                        type: $("#type").val(),
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
                $('#deleteUser').modal('show')
            })

            $("#update_form").on("submit", (e) => {
                e.preventDefault();
                update_name = $("#update_name").val()
                update_username = $("#update_username").val()
                update_type = $("#update_type").val()
                update_password = $("#update_password").val()
                u_id = $("#u_id").val()

                $.ajax({
                    type: "PUT",
                    url: "{{ route('user.update') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        update_name: update_name,
                        update_username: update_username,
                        update_type: update_type,
                        update_password: update_password,
                        id: u_id
                    },
                    success: function(response) {
                        swal({
                            title: "Success",
                            text: "Data Updated",
                            icon: "success",
                            button: "OK"
                        }).then(() => {
                            let user = "{{ Auth::user()->id }}"
                            
                            if (+update_type == 2 && (+user == +u_id)) {
                                window.location.href = "{{ route('subject.show') }}"
                            } else {
                                window.location.reload();
                            }
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
    </script>
@endsection
