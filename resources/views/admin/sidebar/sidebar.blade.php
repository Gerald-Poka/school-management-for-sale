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
                    <a class="nav-link menu-link" href="{{ route('admin.dashboard') }}">
                        <i class="las la-tachometer-alt"></i> <span>Dashboard</span>
                    </a>
                </li>

                <!-- Students Management -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarStudents" data-bs-toggle="collapse" role="button">
                        <i class="las la-user-graduate"></i> <span>Students</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarStudents">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.students.index') }}" class="nav-link" data-key="t-all-students">
                                    All Students
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.students.create') }}" class="nav-link" data-key="t-add-student">
                                    Add New Student
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-payment-records">
                                    Payment Records
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Teachers Management -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarTeachers" data-bs-toggle="collapse" role="button">
                        <i class="las la-chalkboard-teacher"></i> <span>Teachers</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarTeachers">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.teachers.index') }}" class="nav-link" data-key="t-all-teachers">
                                    All Teachers
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.teachers.create') }}" class="nav-link" data-key="t-add-teacher">
                                    Add New Teacher
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.teachers.assignments.index') }}" class="nav-link" data-key="t-assignments">
                                    Subject Assignments
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.teachers.schedules.index') }}" class="nav-link" data-key="t-schedules">
                                    Teaching Schedules
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Subjects -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarSubjects" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSubjects">
                        <i class="las la-book"></i> <span>Subjects</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarSubjects">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.subjects.index') }}" class="nav-link" data-key="t-all-subjects">All Subjects</a>
                            </li>
                            <li class="nav-item">
                            <a href="{{ route('admin.subjects.create') }}" class="nav-link" data-key="t-create-subject">Add New Subject</a>
                            </li>
                            <li class="nav-item">
                            <a href="{{ route('admin.subjects.topics.index') }}" class="nav-link" data-key="t-topics">Topics Management</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Timetable -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarTimetable" data-bs-toggle="collapse" role="button">
                        <i class="las la-calendar"></i> <span>Timetable</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarTimetable">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.timetables.index') }}" class="nav-link">View Timetables</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.timetables.create') }}" class="nav-link">Create Timetable</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Finance -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarFinance" data-bs-toggle="collapse" role="button">
                        <i class="las la-money-bill"></i> <span>Finance</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarFinance">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#sidebarFeeStructure" data-bs-toggle="collapse" class="nav-link">
                                    Fee Structure </i>
                                </a>
                                <div class="collapse" id="sidebarFeeStructure">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.finance.tuition-fees') }}" class="nav-link">Tuition Fees</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.finance.transport-fees') }}" class="nav-link">Transport Fees</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.finance.other-fees') }}" class="nav-link">Other Fees</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.finance.invoices.index') }}" class="nav-link">Invoices</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.finance.payments.index') }}" class="nav-link">Payment Records</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="{{ route('admin.finance.fee-collection') }}" class="nav-link">Fee Collection</a>
                            </li> -->
                            <li class="nav-item">
                                <a href="{{ route('admin.finance.reports') }}" class="nav-link">Financial Reports</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Settings -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarSettings" data-bs-toggle="collapse" role="button">
                        <i class="las la-cog"></i> <span>Settings</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarSettings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link">School Settings</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">Academic Year</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">Holiday Calendar</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
