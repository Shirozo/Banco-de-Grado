<nav class="navbar-main">
    <div class="nav-title nav-nav">
        @yield('back')
        <h1>Banco De Grado</h1>
    </div>
    <div class="nav-right">
        <div class="user-search-container">
            <div class="input-search">
                <input class="form-control user-search" id="search-for-student" placeholder="Enter Student-ID or Name">
            </div>
            <div class="search-result s-inactive" id="search-result">
                <h4 class="no-result">Type 1 or more characters</h4>
            </div>
        </div>
        <div class="nav-action">
            <i class="fa fa-user fa-lg" id="user-icon"></i>
            <div class="search-result s-inactive" id="user-nav-action">
                <a href="{{ route('logout') }}">Log Out</a>
            </div>
        </div>
    </div>
</nav>

<div class="modal fade" id="studentAllData">
    <div class="modal-dialog modal-lg" role="document">
        <form action="#" method="POST" id="studentAllDataModal">
            @csrf
            @method('delete')
            <div class="modal-content">
                <div class="modal-header" style="justify-content: left !important;">
                    <h5 class="modal-title"><span class="fa-regular fa-user" style="color: black"></span> Name GRADES
                    </h5>
                </div>
                <div class="modal-body" style="justify-content: left !important">
                    <h3>Student ID:</h3>
                    <h3>Course, Section & Year:</h3>
                </div>
                <div class="modal-title" style="margin-left: 1.25rem">GRADES</div>
                <div class="modal-body grades-div" style="justify-content: left !important" id="dataHere">

                </div>
                <div class="modal-footer custom-footer" style="margin-top: 10px">
                    <button type="submit" class="btn btn-success btn-flat" name="add"
                        style="background-color: green">
                        DOWNLOAD</button>
                    <button type="button" class="btn btn-danger btn-flat pull-left btn-close-c"
                        onclick="$('#studentAllData').modal('hide')"><i class="fa fa-close"></i> Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const $input = $('#search-for-student');
        const $searchResult = $('#search-result');

        $input.on('focus', function() {
            $searchResult.addClass('s-active');
            $searchResult.removeClass('s-inactive');

        });

        $("#user-icon").on('click', function() {
            if ($("#user-nav-action").hasClass('active')) {
                $("#user-nav-action").removeClass('active')
                $("#user-nav-action").addClass('s-inactive')
            } else {
                $("#user-nav-action").removeClass('s-inactive')
                $("#user-nav-action").addClass('active')
            }
        });

        $input.on('blur', function() {
            setTimeout(() => {
                $searchResult.addClass('s-inactive');
            }, 200);
        });

        $("#search-for-student").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $.ajax({
                url: "{{ route('student.api') }}",
                type: "GET",
                data: {
                    q: value
                },
                success: function(data) {
                    console.log(data.length);

                    if (data.length == 0) {
                        result_html = `<h4 class="no-result">No Result</h4>`
                    } else {
                        result_html = ""
                        for (var i = 0; i < data.length; i++) {
                            result_html +=
                                `<h4 class="result" onclick="studentData(${data[i].id})">${data[i].text}</h4>`
                        }
                    }
                    $("#search-result").html(result_html)
                }
            })
        });
    })

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
        $("#studentAllData").modal("show")

        $.ajax({
            type: "GET",
            url: "{{ route('student.all') }}",
            data: {
                id: id
            },
            success: function(response) {
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
                    first_sem = grade.first_sem ? grade.first_sem : "No Grade"
                    second_sem = grade.second_sem ? grade.second_sem : "No Grade"

                    if (first_sem == "No Grade" && second_sem == "No Grade") {
                        average = "No Grade"
                    }
                    else {
                        average = (grade.first_sem + grade.second_sem) / 2
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
                            <td style="width: 15%; text-align:center;">${first_sem}</td>
                            <td style="width: 15%; text-align:center;">${second_sem}</td>
                            <td style="width: 15%; text-align:center;">${average}</td>
                            ${remark}
                        </tr>
                    `
                }
                html += `
                        </tbody>
                    </table>
                </div>`

                $("#dataHere").append(html)
            }
        })
    }
</script>
