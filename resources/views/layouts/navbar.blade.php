<nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <h1>Banco De Grado</h1>
            <ul class="navbar-nav align-items-center  ml-md-auto ">
                <li class="nav-item d-xl-none">
                    <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin"
                        data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </li>
                <li class="nav-item d-sm-none">
                    <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                        <i class="ni ni-zoom-split-in"></i>
                    </a>
                </li>
            </ul>

            <div class="user-search-container">
                <div class="input-search">
                    <input class="form-control mr-sm-4 search-user" id="search-for-student"
                        placeholder="Enter Student-ID or Name">
                </div>
                <div class="search-result s-inactive">
                    <h4 class="no-result">Type 1 or more characters</h4>
                </div>
            </div>
            <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle">
                                <img alt="Image placeholder" src="{{ asset('theme/1.jpg') }}">
                            </span>
                            <div class="media-body  ml-2  d-none d-lg-block">
                                <span class="mb-0 text-sm  font-weight-bold">
                                    Username
                                </span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu  dropdown-menu-right ">
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome!</h6>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="ni ni-user-run text-red"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const $input = $('#search-for-student');
        const $searchResult = $('.search-result');

        $input.on('focus', function() {
            $searchResult.addClass('s-active');
            $searchResult.removeClass('s-inactive');

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
                    }
                    else {
                        result_html = ""
                        for (var i = 0; i < data.length; i++) {
                            result_html +=
                                `<h4 class="result" onclick="studentData()">${data[i].name}</h4>`                      
                        }
                    }
                    $(".search-result").html(result_html)
                }
            })
        });
    })

    function studentData() {
        console.log("hello world");

    }
</script>
