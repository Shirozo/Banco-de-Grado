<nav class="navbar-main">
    <div class="nav-title nav-nav">
        @yield('back')
        <h1>Banco De Grado</h1>
    </div>
    <div class="nav-right">
        <div class="user-search-container">
            <div class="input-search">
                <input class="form-control user-search" id="search-for-student"
                    placeholder="Enter Student-ID or Name">
            </div>
            <div class="search-result s-inactive" id="search-result">
                <h4 class="no-result">Type 1 or more characters</h4>
            </div>
        </div>
        <div class="nav-action">
            <i class="fa fa-user fa-lg" id="user-icon"></i>
            <div class="search-result s-inactive" id="user-nav-action">
               <a href="#">Log Out</a>
            </div>
        </div>
    </div>
</nav>
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
                    }
                    else {
                        result_html = ""
                        for (var i = 0; i < data.length; i++) {
                            result_html +=
                                `<h4 class="result" onclick="studentData()">${data[i].name}</h4>`                      
                        }
                    }
                    $("#search-result").html(result_html)
                }
            })
        });
    })

    function studentData() {
        console.log("hello world");

    }
</script>
