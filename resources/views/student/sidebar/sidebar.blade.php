<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="#" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('school/logo.png') }}" alt="" height="75">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('school/logo.png') }}" alt="" height="75">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="#" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('school/logo.png') }}" alt="" height="75">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('school/logo.png') }}" alt="" height="75">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>Menu</span></li>

                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('student.dashboard') }}">
                        <i class="las la-tachometer-alt"></i> <span>Dashboard</span>
                    </a>
                </li>

                <!-- My Subjects -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('student.subjects.index') }}">
                        <i class="las la-book"></i> <span>My Subjects</span>
                    </a>
                </li>

                <!-- My Timetable -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('student.timetable') }}">
                        <i class="las la-calendar"></i> <span>My Timetable</span>
                    </a>
                </li>

                <!-- Financial Records -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarFinance" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarFinance">
                        <i class="las la-money-bill"></i> <span>Financial</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarFinance">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('student.invoices.index') }}" class="nav-link">Invoices</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('student.payments.index') }}" class="nav-link">My Payments</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Assignments -->
                <!-- <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="las la-tasks"></i> <span>Assignments</span>
                    </a>
                </li> -->

                <!-- Exam Results -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('student.results.index') }}">
                        <i class="las la-chart-bar"></i> <span>Exam Results</span>
                    </a>
                </li>

                <!-- My Profile -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('student.profile.index') }}">
                        <i class="las la-user-circle"></i> <span>My Profile</span>
                    </a>
                </li>

                <!-- Settings -->
            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
