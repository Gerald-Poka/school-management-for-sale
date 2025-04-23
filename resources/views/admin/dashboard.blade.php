@extends('layouts.master')
@section('title') School Dashboard @endsection
@section('css')
<link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
<style>
.notification-bubble {
    position: relative;
}
.notification-bubble::after {
    content: attr(data-count);
    position: absolute;
    top: -8px;
    right: -8px;
    background: #f06548;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
    line-height: 1;
}
.tips-carousel {
    height: 60px;
    overflow: hidden;
}
.clock-widget {
    background: rgba(var(--vz-primary-rgb), 0.1);
    border-radius: 8px;
    padding: 15px;
}
.session-timer {
    font-size: 13px;
    color: var(--vz-text-muted);
}
.tips-container {
    height: 120px;
    position: relative;
    background: linear-gradient(135deg, rgba(var(--vz-primary-rgb), 0.05) 0%, rgba(var(--vz-primary-rgb), 0.1) 100%);
    border-radius: 15px;
    overflow: hidden;
    padding: 20px;
}

.tip-text {
    position: absolute;
    width: 100%;
    text-align: center;
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--vz-primary);
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.5s ease;
}

.tip-text.active {
    opacity: 1;
    transform: translateY(0);
}

.tip-text span {
    display: inline-block;
}

@keyframes sparkle {
    0%, 100% { opacity: 0; transform: scale(0); }
    50% { opacity: 1; transform: scale(1); }
}

.sparkle {
    position: absolute;
    width: 10px;
    height: 10px;
    background: rgba(var(--vz-primary-rgb), 0.5);
    border-radius: 50%;
    pointer-events: none;
}
</style>
@endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Home @endslot
    @slot('title') Dashboard @endslot
@endcomponent

<!-- Top Stats Row -->
<div class="row mb-3">
    <!-- Clock & Session Timer -->
    <div class="col-xl-3">
        <div class="card">
            <div class="card-body clock-widget">
                <div class="d-flex align-items-center">
                    <i class="ri-time-line fs-2 me-2 text-primary"></i>
                    <div>
                        <h4 class="mb-0" id="live-clock">00:00:00</h4>
                        <small class="session-timer">
                            Session time: <span id="session-time">0m</span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Notifications -->
    <div class="col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="notification-bubble" data-count="3">
                        <i class="ri-mail-line fs-2 text-primary"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-1">New Messages</h6>
                        <div class="dropdown">
                            <a class="text-muted" href="#" role="button" data-bs-toggle="dropdown">
                                3 unread messages
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-primary">
                                                        MT
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">Math Teacher</h6>
                                                <p class="mb-0 text-muted">Assignment submissions...</p>
                                                <small class="text-muted">3 min ago</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- Add more messages here -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tips Carousel -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ri-lightbulb-flash-line fs-2 text-warning me-2"></i>
                    <div class="tips-carousel">
                        <div class="tips-content" id="tips-content">
                            <!-- Tips will be inserted here by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Welcome Widget -->
    <div class="col-xxl-6">
        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="fs-22 fw-semibold ff-secondary mb-2">Welcome Back, Admin! 👋</h4>
                        <p class="text-muted mb-4">Here's what's happening with your school today.</p>
                    </div>
                    <div class="avatar-lg">
                        <div class="avatar-title bg-light rounded-circle">
                            <img src="{{ URL::asset('build/images/school-logo.png') }}" alt="" class="avatar-sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-xxl-6">
        <div class="d-flex flex-column h-100">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Total Students</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="2500">0</span></h2>
                                    <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0">
                                        <i class="ri-arrow-up-line align-middle"></i> 16.24 %
                                    </span> vs. previous month</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary-subtle rounded-circle fs-2">
                                            <i class="las la-user-graduate text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Academic Performance</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="85">0</span>%</h2>
                                    <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0">
                                        <i class="ri-arrow-up-line align-middle"></i> 3.57 %
                                    </span> vs. previous term</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success-subtle rounded-circle fs-2">
                                            <i class="las la-chart-line text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Total Teachers</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="120">0</span></h2>
                                    <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0">
                                        <i class="ri-arrow-up-line align-middle"></i> 8.5 %
                                    </span> vs. previous year</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                            <i class="las la-chalkboard-teacher text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Fee Collection</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold">$<span class="counter-value" data-target="125600">0</span></h2>
                                    <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0">
                                        <i class="ri-arrow-down-line align-middle"></i> 2.8 %
                                    </span> vs. target</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-warning-subtle rounded-circle fs-2">
                                            <i class="las la-dollar-sign text-warning"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <!-- Academic Performance Trend -->
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header border-0 align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Academic Performance Trend</h4>
                <div>
                    <button type="button" class="btn btn-soft-secondary btn-sm">
                        ALL
                    </button>
                    <button type="button" class="btn btn-soft-primary btn-sm">
                        1Y
                    </button>
                </div>
            </div>
            <div class="card-body p-0 pb-2">
                <div class="w-100">
                    <div id="performance_chart" data-colors='["--vz-primary", "--vz-success"]' class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subject Performance -->
    <div class="col-xl-4">
        <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Subject Performance</h4>
            </div>
            <div class="card-body">
                <div id="subjects_chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]' class="apex-charts" dir="ltr"></div>
                <div class="mt-3 px-3">
                    <div class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
                        <p class="fw-medium mb-0"><i class="ri-circle-fill text-primary align-middle me-2"></i> Mathematics</p>
                        <div>
                            <span class="text-muted pe-5">85%</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
                        <p class="fw-medium mb-0"><i class="ri-circle-fill text-success align-middle me-2"></i> Science</p>
                        <div>
                            <span class="text-muted pe-5">78%</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <p class="fw-medium mb-0"><i class="ri-circle-fill text-warning align-middle me-2"></i> Languages</p>
                        <div>
                            <span class="text-muted pe-5">82%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Timetables and Attendance -->
<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Recent Timetable Updates</h4>
                <div class="flex-shrink-
                <div class="flex-shrink-0">
                    <div class="dropdown card-header-dropdown">
                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-muted fs-18"><i class="mdi mdi-dots-vertical"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">View All</a>
                            <a class="dropdown-item" href="#">Mark as Read</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Timetables and Attendance -->
<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Recent Timetable Updates</h4>
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.timetables.index') }}" class="btn btn-soft-primary btn-sm">
                        <i class="ri-calendar-line align-middle"></i> View All
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless table-nowrap align-middle mb-0">
                        <thead class="table-light text-muted">
                            <tr>
                                <th scope="col">Class</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Day</th>
                                <th scope="col">Time</th>
                                <th scope="col">Teacher</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Grade 10</td>
                                <td>Mathematics</td>
                                <td>Monday</td>
                                <td>09:45 - 10:45</td>
                                <td>Mr. Johnson</td>
                            </tr>
                            <tr>
                                <td>Grade 8</td>
                                <td>Science</td>
                                <td>Tuesday</td>
                                <td>11:15 - 12:15</td>
                                <td>Mrs. Smith</td>
                            </tr>
                            <tr>
                                <td>Grade 12</td>
                                <td>Physics</td>
                                <td>Wednesday</td>
                                <td>14:15 - 15:15</td>
                                <td>Dr. Williams</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Attendance Overview</h4>
                <div class="flex-shrink-0">
                    <button type="button" class="btn btn-soft-info btn-sm">
                        <i class="ri-file-list-3-line align-middle"></i> Generate Report
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="attendance_chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning"]' class="apex-charts" dir="ltr"></div>
                <div class="mt-2 text-center">
                    <div class="row">
                        <div class="col-4">
                            <div class="mt-2">
                                <p class="text-muted mb-1">Present</p>
                                <h4 class="fw-semibold">92.8%</h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mt-2">
                                <p class="text-muted mb-1">Absent</p>
                                <h4 class="fw-semibold">5.7%</h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mt-2">
                                <p class="text-muted mb-1">Late</p>
                                <h4 class="fw-semibold">1.5%</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Events -->
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Upcoming School Events</h4>
                <div class="flex-shrink-0">
                    <a href="#" class="btn btn-soft-primary btn-sm">
                        <i class="ri-calendar-event-line align-middle"></i> View Calendar
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card border card-border-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm">
                                            <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-4">
                                                <i class="ri-award-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="card-title">Annual Sports Day</h5>
                                        <p class="text-muted mb-0">15th March, 2023</p>
                                    </div>
                                </div>
                                <p class="mb-0">Annual sports competition with track and field events for all grades.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card border card-border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm">
                                            <div class="avatar-title bg-success-subtle text-success rounded-circle fs-4">
                                                <i class="ri-book-open-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="card-title">Science Exhibition</h5>
                                        <p class="text-muted mb-0">22nd March, 2023</p>
                                    </div>
                                </div>
                                <p class="mb-0">Students will showcase their science projects and innovations.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card border card-border-warning">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm">
                                            <div class="avatar-title bg-warning-subtle text-warning rounded-circle fs-4">
                                                <i class="ri-user-voice-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="card-title">Parent-Teacher Meeting</h5>
                                        <p class="text-muted mb-0">30th March, 2023</p>
                                    </div>
                                </div>
                                <p class="mb-0">End of term meeting to discuss student progress and performance.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
<script>
// Performance Chart
var options = {
    series: [{
        name: "Performance",
        data: [65, 70, 75, 73, 80, 85, 83]
    }],
    chart: { 
        type: 'line', 
        height: 350,
        toolbar: {
            show: false
        }
    },
    stroke: {
        curve: 'smooth',
        width: 3
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
    },
    colors: ['#0ab39c'],
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'dark',
            gradientToColors: ['#405189'],
            shadeIntensity: 1,
            type: 'horizontal',
            opacityFrom: 1,
            opacityTo: 1,
        },
    },
    markers: {
        size: 4,
        colors: ['#0ab39c'],
        strokeColors: '#fff',
        strokeWidth: 2,
        hover: {
            size: 7,
        }
    },
    yaxis: {
        title: {
            text: 'Performance Score'
        },
    }
};
var chart = new ApexCharts(document.querySelector("#performance_chart"), options);
chart.render();

// Subject Performance Chart
var subjectOptions = {
    series: [85, 78, 82],
    chart: { 
        type: 'donut', 
        height: 250 
    },
    labels: ['Mathematics', 'Science', 'Languages'],
    colors: ['#405189', '#0ab39c', '#f7b84b'],
    legend: {
        show: false
    },
    plotOptions: {
        pie: {
            donut: {
                size: '70%',
                labels: {
                    show: true,
                    name: {
                        show: true,
                    },
                    value: {
                        show: true,
                        formatter: function (val) {
                            return val + '%';
                        }
                    }
                }
            }
        }
    }
};
var subjectChart = new ApexCharts(document.querySelector("#subjects_chart"), subjectOptions);
subjectChart.render();

// Attendance Chart
var attendanceOptions = {
    series: [92.8, 5.7, 1.5],
    chart: {
        type: 'radialBar',
        height: 250,
    },
    plotOptions: {
        radialBar: {
            dataLabels: {
                name: {
                    fontSize: '22px',
                },
                value: {
                    fontSize: '16px',
                },
                total: {
                    show: true,
                    label: 'Total',
                    formatter: function (w) {
                        return '100%';
                    }
                }
            },
            hollow: {
                size: '50%',
            }
        }
    },
    labels: ['Present', 'Absent', 'Late'],
    colors: ['#405189', '#f06548', '#f7b84b'],
};
var attendanceChart = new ApexCharts(document.querySelector("#attendance_chart"), attendanceOptions);
attendanceChart.render();

// Live Clock
function updateClock() {
    const now = new Date();
    document.getElementById('live-clock').textContent = 
        now.toLocaleTimeString('en-US', { hour12: false });
}
setInterval(updateClock, 1000);
updateClock();

// Session Timer
const lastLogin = new Date("{{ auth()->user()->last_login ?? now() }}");
function updateSessionTime() {
    const now = new Date();
    const diff = Math.floor((now - lastLogin) / 1000 / 60);
    const hours = Math.floor(diff / 60);
    const minutes = diff % 60;
    let timeStr = '';
    if (hours > 0) timeStr += `${hours}h `;
    timeStr += `${minutes}m`;
    document.getElementById('session-time').textContent = timeStr;
}
setInterval(updateSessionTime, 60000);
updateSessionTime();

// Tips Carousel
const tips = [
    "✨ Welcome to School Management System!",
    "✨ Designed by Gerald Ndyamukama",
    "✨ Contact: +255 673 128 464",
    "✨ Known as Poka Machande"
];

function createSparkle() {
    const sparkle = document.createElement('div');
    sparkle.className = 'sparkle';
    
    // Random position
    sparkle.style.left = Math.random() * 100 + '%';
    sparkle.style.top = Math.random() * 100 + '%';
    
    // Random size
    const size = Math.random() * 15 + 5;
    sparkle.style.width = size + 'px';
    sparkle.style.height = size + 'px';
    
    return sparkle;
}

function animateText(text) {
    const container = document.getElementById('tips-content');
    container.innerHTML = '';
    container.className = 'tip-text';
    
    // Create wrapper for each character
    const chars = text.split('').map(char => {
        const span = document.createElement('span');
        span.textContent = char;
        span.style.opacity = '0';
        span.style.transform = 'translateY(20px)';
        return span;
    });
    
    chars.forEach(span => container.appendChild(span));
    
    // Add sparkles
    for (let i = 0; i < 10; i++) {
        const sparkle = createSparkle();
        container.appendChild(sparkle);
        sparkle.style.animation = `sparkle ${Math.random() * 2 + 1}s linear`;
        setTimeout(() => sparkle.remove(), 2000);
    }
    
    // Animate characters
    chars.forEach((span, i) => {
        setTimeout(() => {
            span.style.transition = 'all 0.3s ease';
            span.style.opacity = '1';
            span.style.transform
            span.style.transition = 'all 0.3s ease';
            span.style.opacity = '1';
            span.style.transform = 'translateY(0)';
        }, i * 50);
    });
    
    container.classList.add('active');
}

let currentTipIndex = 0;
function showNextTip() {
    const container = document.getElementById('tips-content');
    container.classList.remove('active');
    
    setTimeout(() => {
        animateText(tips[currentTipIndex]);
        currentTipIndex = (currentTipIndex + 1) % tips.length;
    }, 500);
}

// Initial tip
showNextTip();

// Change tip every 5 seconds
setInterval(showNextTip, 5000);
</script>
@endsection
