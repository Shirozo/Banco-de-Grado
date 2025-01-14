<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Banco De Grado</title>

    <link rel="icon" href="{{ asset('icon.png') }}">
    <script src="{{ asset('assets/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

    @vite(['resources/css/app.css', 'resources/scss/app.scss'])

</head>

<body>
    <div class="main-content" id="panel" style="background-color:white;height:100vh;">

        @include('layouts.navbarFull')

        <div class="mt-2" style="overflow: hidden">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-transparent" style="display: flex;gap:20px;">
                            <select name="course" id="course" class="form-control changeData" style="width: 10%">
                                <option value="" selected>Course</option>
                                @foreach ($courses as $c)
                                    <option value="{{ $c }}">{{ $c }}</option>
                                @endforeach
                            </select>
                            <select name="year" id="year" class="form-control changeData" style="width: 10%">
                                <option value="" selected>Year</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                            <select name="section" id="section" class="form-control changeData" style="width: 10%">
                                <option value="" selected>Section</option>
                                @foreach ($section as $s)
                                    <option value="{{ $s }}">{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="padding: 1%;">
                            <table id="allData" class="table table-stripped table-bordered" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>STUDENT ID</th>
                                        <th>NAME</th>
                                        <th>COURSE</th>
                                        <th style="text-align: center">YEAR</th>
                                        <th style="text-align: center">SECTION</th>
                                        <th style="text-align: center">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody id="allbody">
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>{{ $d->student_id }}</td>
                                            <td>{{ $d->name }}</td>
                                            <td>{{ $d->course }}</td>
                                            <td style="text-align: center">{{ $d->year }}</td>
                                            <td style="text-align: center">{{ $d->section }}</td>
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-flat btn-success"
                                                    onclick="studentData('{{ $d->id }}')">
                                                    <i class="fa fa-eye" style="color:  white !important"></i>
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

        <div class="modal fade" id="studentAllData">
            <div class="modal-dialog modal-lg" role="document">
                <form action="#" method="POST" id="studentAllDataModal">
                    <div class="modal-content">
                        <div class="modal-header" style="justify-content: left !important;">
                            <h5 class="modal-title" id="student_name">
                                <span class="fa-regular fa-user" style="color: black"></span> Name
                                GRADES
                            </h5>
                        </div>
                        <div class="modal-body" style="justify-content: left !important">
                            <h3 id="s_id">Student ID:</h3>
                            <h3 id="s_course_s_year">Course, Section & Year:</h3>
                        </div>
                        <div class="modal-title" style="margin-left: 1.25rem">GRADES</div>
                        <div class="modal-body grades-div" style="justify-content: left !important" id="dataHere">

                        </div>
                        <div class="modal-footer custom-footer" style="margin-top: 10px">
                            <button type="button" class="btn btn-success btn-flat" onclick="showOption()"
                                style="background-color: green">
                                DOWNLOAD</button>
                            <button type="button" class="btn btn-danger btn-flat pull-left btn-close-c"
                                onclick="$('#studentAllData').modal('hide')"><i class="fa fa-close"></i> Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="selectRange">
            <div class="modal-dialog" role="document">
                <form action="#" method="POST" id="selectRan">
                    <div class="modal-content">
                        <div class="modal-header" style="justify-content: left !important;">
                            <h5 class="modal-title">
                                Select Range of Data
                            </h5>
                        </div>
                        <div class="modal-body" style="justify-content: left !important">
                            <input type="hidden" id="user_id">
                            <div class="form-group has-feedback">
                                <label for="sy_range">School Year:</label>
                                <select name="sy_range" maxlength="50" class="form-control" required id="sy_range"
                                    placeholder="Select Semester">
                                </select>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="sem_range">Semester:</label>
                                <select name="sem_range" maxlength="50" class="form-control" required id="sem_range"
                                    placeholder="Select Semester">
                                    <option value="" selected>Select Semester</option>
                                    <option value="1">1</option>
                                    <option value="4">2</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer custom-footer" style="margin-top: 10px">
                            <button type="submit" class="btn btn-success btn-flat" onclick=""
                                style="background-color: green">
                                DOWNLOAD</button>
                            <button type="button" class="btn btn-danger btn-flat pull-left btn-close-c"
                                onclick="$('#selectRange').modal('hide')"><i class="fa fa-close"></i> Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const $input = $('#search-for-student');
        const $searchResult = $('#search-result');

        $input.on('focus', function() {
            $searchResult.addClass('s-active');
            $searchResult.removeClass('s-inactive');
        });

        let table = new DataTable("#allData")

        $("#user-icon").on('click', function() {
            if ($("#user-nav-action").hasClass('active')) {
                $("#user-nav-action").removeClass('active')
                $("#user-nav-action").addClass('s-inactive')
            } else {
                $("#user-nav-action").removeClass('s-inactive')
                $("#user-nav-action").addClass('active')
            }
        });

        $("#selectRan").on("submit", function(e) {
            e.preventDefault();

            var id = $("#user_id").val();
            var sy_range = $("#sy_range").val();
            var sem_range = $("#sem_range").val();

            // Basic validation
            if (!id || !sy_range || !sem_range) {
                swal({
                    title: "Error",
                    text: "Please fill in all fields.",
                    icon: "error",
                    button: "Close"
                });
                return; // Stop execution if validation fails
            }

            // Create a form to submit the data
            var form = $('<form>', {
                action: "{{ route('student.generate') }}", // Your download route
                method: 'GET'
            });

            // Append the data to the form
            form.append($('<input>', {
                type: 'hidden',
                name: 'id',
                value: id
            }));
            form.append($('<input>', {
                type: 'hidden',
                name: 'sy_range',
                value: sy_range
            }));
            form.append($('<input>', {
                type: 'hidden',
                name: 'sem_range',
                value: sem_range
            }));

            console.log(form);

            // Append the form to the body and submit it
            $('body').append(form);
            form.submit();

            // Optionally, show a success message
            swal({
                title: "Success",
                text: "Student Data Downloaded! Please check your downloads.",
                icon: "success",
                button: "Close"
            });
        });

        $(".changeData").on("change", function() {

            course = $("#course").val()
            year = $("#year").val()
            section = $("#section").val()
            $.ajax({
                type: "GET",
                url: "{{ route('api') }}",
                data: {
                    course: course,
                    year: year,
                    section: section
                },
                success: function(response) {
                    html = ``
                    for (let i = 0; i < response.length; i++) {
                        const element = response[i];
                        html += `
                         <tr>
                            <td>${element.student_id}</td>
                            <td>${element.name}</td>
                            <td>${element.course}</td>
                            <td style="text-align: center">${element.year}</td>
                            <td style="text-align: center">${element.section}</td>
                            <td style="text-align: center">
                                <a class="btn btn-sm btn-flat btn-success" data-id="${element.id}">
                                    <i class="fa fa-eye" style="color:  white !important"></i>
                                </a>
                            </td>
                        </tr>
                        `
                    }
                    table.destroy()
                    $("#allbody").html(html)
                    table = new DataTable("#allData")

                }
            })

        })
    })

    function showOption() {
        $.ajax({
            type: "GET",
            url: "{{ route('student.sy') }}",
            data: {
                id: $("#user_id").val()
            },
            success: function(response) {
                data = response.sy
                if (data.length == 0) {
                    swal({
                        title: "Error",
                        text: "Student has no Data!",
                        icon: "error",
                        button: "Close"
                    })
                } else {

                    ht = `<option value="" selected>Select School Year</option>`
                    for (let a = 0; a < data.length; a++) {
                        d = data[a]
                        ht += `
                     <option value="${d.school_year}">${d.school_year}</option>
                    `
                    }
                    $("#sy_range").html(ht)
                    $("#studentAllData").modal("hide")
                    $("#selectRange").modal("show")
                }
            }
        })
    }
    /* https://www.w3schools.com/howto/howto_js_collapsible.asp */
    function collapse(btn) {
        btn.classList.toggle("active");
        var content = btn.nextElementSibling;
        const icon = btn.querySelector('.fa')
        if (content.style.display === "block") {
            content.style.display = "none";
            icon.classList.remove('fa-minus');
            icon.classList.add('fa-plus');
        } else {
            content.style.display = "block";
            icon.classList.remove('fa-plus');
            icon.classList.add('fa-minus');
        }
    }

    function studentData(id) {
        u = "{{ Auth::user() }}"
        if (u.length == 0) {
            swal({
                title: "Error",
                text: "Not Permitted.",
                icon: "error",
                button: "Close"
            });
        } else {

            $("#studentAllData").modal("show")

            $.ajax({
                type: "GET",
                url: "{{ route('student.all') }}",
                data: {
                    id: id
                },
                success: function(response) {
                    $("#student_name").html(
                        `<span class="fa-regular fa-user" style="color: black"></span> ${response.personal.name} GRADES`
                    )
                    $("#user_id").val(response.personal.id)
                    $("#s_id").html(`Student ID: ${response.personal.student_id}`)
                    $("#s_course_s_year").html(
                        `Course, Section & Year: ${response.personal.course} - ${response.personal.year}${response.personal.section}`
                    )
                    grades = response.grades
                    html = ""
                    sy = []

                    for (let i = 0; i < grades.length; i++) {
                        grade = grades[i]
                        if (!sy.includes(grade.school_year.trim())) {

                            if (html.length != 0) {
                                html += `
                                    </tbody>
                                </table>
                            </div>
                            `
                            }
                            html += `
                            <div class="school-year">
                                <button type="button" onclick="collapse(this)" class="collapsible">
                                    ${grade.school_year} <span class="fa fa-plus" style="float: right"></span>
                                </button>
                                    <table class="allDataTable">
                                        <thead>
                                            <tr class="report-tr">
                                                <th class="report-th" style="width: 50%;">Subject</th>
                                                <th class="report-th" style="width: 15%;">1st Sem</th>
                                                <th class="report-th" style="width: 15%;">2nd Sem</th>
                                                <th class="report-th" style="width: 15%;">Average</th>
                                                <th class="report-th" style="width: 10%;">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;
                            sy.push(grade.school_year.trim())
                        }
                        midterm = grade.midterm ? grade.midterm : "No Grade"
                        finals = grade.finals ? grade.finals : "No Grade"

                        if (midterm == "No Grade" && finals == "No Grade") {
                            average = "No Grade"
                        } else {
                            average = (grade.midterm + grade.finals) / 2
                        }

                        if (average > 3) {
                            remark = `<td class="failed" style="width: 10%; text-align:center;">FAILED</td>`
                        } else if (average < 3) {
                            remark = `<td class="passed" style="width: 10%; text-align:center;">PASSED</td>`
                        } else {
                            remark = `<td style="width: 10%; text-align:center;">No Grade!</td>`
                        }
                        html += `
                        <tr>
                            <td style="width: 50%; text-align:center;">${grade.subject_name}</td>
                            <td style="width: 15%; text-align:center;">${midterm}</td>
                            <td style="width: 15%; text-align:center;">${finals}</td>
                            <td style="width: 15%; text-align:center;">${average}</td>
                            ${remark}
                        </tr>
                    `
                    }
                    html += `
                        </tbody>
                    </table>
                </div>`

                    $("#dataHere").html(html)
                }
            })
        }

    }
</script>

</html>
