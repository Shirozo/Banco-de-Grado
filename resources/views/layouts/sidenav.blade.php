<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="#">
                <i>Banco de Grado</i>
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav" style="margin-top: 60px;">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('student.show') }}">
                            <i class="fa fa-graduation-cap"></i>
                            <span class="nav-link-text">Students</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.show') }}">
                            <i class="fa fa-users"></i>
                            <span class="nav-link-text">Users</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
