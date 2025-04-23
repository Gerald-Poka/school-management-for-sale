<?php $__env->startSection('title'); ?>
    Student Dashboard
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('build/libs/swiper/swiper-bundle.min.css')); ?>" rel="stylesheet">
<style>
    .welcome-widget {
        background: linear-gradient(135deg, rgba(75, 56, 179, 0.1) 0%, rgba(75, 56, 179, 0.2) 100%);
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }
    
    .welcome-widget::before {
        content: "";
        position: absolute;
        top: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(75, 56, 179, 0.1);
        z-index: 0;
    }
    
    .welcome-widget::after {
        content: "";
        position: absolute;
        bottom: -60px;
        left: -60px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(75, 56, 179, 0.1);
        z-index: 0;
    }
    
    .welcome-content {
        position: relative;
        z-index: 1;
    }
    
    .stat-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .timetable-mini {
        border-radius: 8px;
        overflow: hidden;
    }
    
    .timetable-mini .table th {
        background-color: #4b38b3;
        color: #fff;
        font-weight: 500;
        padding: 10px;
    }
    
    .timetable-mini .table td {
        padding: 10px;
        vertical-align: middle;
    }
    
    .subject-card {
        border-radius: 8px;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .subject-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .subject-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        margin-right: 15px;
    }
    
    .invoice-mini {
        border-left: 3px solid;
        transition: all 0.3s ease;
    }
    
    .invoice-mini:hover {
        transform: translateX(5px);
    }
    
    .invoice-paid {
        border-color: #0ab39c;
    }
    
    .invoice-pending {
        border-color: #f7b84b;
    }
    
    .invoice-overdue {
        border-color: #f06548;
    }
    
    .clock-widget {
        background: rgba(75, 56, 179, 0.1);
        border-radius: 8px;
        padding: 15px;
    }
    
    .session-timer {
        font-size: 13px;
        color: var(--vz-text-muted);
    }
    
    .announcement-card {
        border-radius: 8px;
        border-left: 4px solid #4b38b3;
        transition: all 0.3s ease;
    }
    
    .announcement-card:hover {
        background-color: rgba(75, 56, 179, 0.05);
    }
    
    .upcoming-event {
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .upcoming-event:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .event-date {
        width: 60px;
        height: 60px;
        background: #4b38b3;
        color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }
    
    .event-date .day {
        font-size: 20px;
        font-weight: 700;
        line-height: 1;
    }
    
    .event-date .month {
        font-size: 12px;
        text-transform: uppercase;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Student Dashboard</h4>
                    <div class="page-title-right">
                        <div class="card clock-widget mb-0">
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
            </div>
        </div>

        <div class="row mb-4">
        <div class="col-xxl-8">
    <div class="card welcome-widget">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="welcome-content">
                        <h3 class="mb-3 fw-semibold">Welcome back, <?php echo e(auth()->user()->student->first_name ?? 'Student'); ?>! 👋</h3>
                        <p class="text-muted mb-4">Here's a summary of your academic journey and upcoming activities.</p>
                        
                        <div class="d-flex gap-3">
                            <a href="<?php echo e(route('student.timetable')); ?>" class="btn btn-primary">View Timetable</a>
                            <a href="<?php echo e(route('student.subjects.index')); ?>" class="btn btn-soft-primary">My Subjects</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-flex align-items-center justify-content-center">
                    <div class="avatar-lg">
                        <?php if(auth()->user()->student->profile_picture): ?>
                            <img src="<?php echo e(Storage::url(auth()->user()->student->profile_picture)); ?>" 
                                 alt="Profile Picture"
                                 class="avatar-lg rounded-circle"
                                 style="object-fit: cover; width: 100%; height: 100%;">
                        <?php else: ?>
                            <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-1" 
                                 style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <?php echo e(substr(auth()->user()->student->first_name ?? '', 0, 1)); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

            
            <div class="col-xxl-4">
                <div class="row">
                    <div class="col-md-6 col-xxl-12 mb-3 mb-md-0 mb-xxl-3">
                        <div class="card stat-card bg-primary-subtle">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm">
                                            <div class="avatar-title bg-primary text-white rounded-circle fs-3">
                                                <i class="las la-book"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Enrolled Subjects</p>
                                        <h4 class="mb-0"><?php echo e(rand(5, 8)); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xxl-12">
                        <div class="card stat-card bg-success-subtle">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm">
                                            <div class="avatar-title bg-success text-white rounded-circle fs-3">
                                                <i class="las la-chart-bar"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted mb-1">Attendance Rate</p>
                                        <h4 class="mb-0"><?php echo e(rand(85, 98)); ?>%</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Classes & Upcoming Events -->
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                <div class="flex-shrink-0">
    <a href="<?php echo e(route('student.timetable')); ?>" class="btn btn-soft-primary btn-sm">
        <i class="ri-calendar-line align-middle"></i> Full Timetable
    </a>
</div>
<div class="card-body">
    <div class="table-responsive timetable-mini">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Subject</th>
                    <th>Teacher</th>
                    <th>Room</th>
                </tr>
            </thead>
            <tbody>
            <?php
    $today = \Carbon\Carbon::now()->format('l');
    try {
        $student = auth()->user()->student;
        $academicLevel = $student->academicLevel;
        $timetable = $academicLevel->timetables()->where('is_active', true)->first();
        $todaySlots = $timetable ? $timetable->slots->where('day_of_week', $today)->sortBy('start_time') : collect([]);
    } catch (\Exception $e) {
        $todaySlots = collect([]);
        $timetable = null;
    }
?>

<?php if($timetable && $todaySlots->count() > 0): ?>
    <?php $__currentLoopData = $todaySlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e(\Carbon\Carbon::parse($slot->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($slot->end_time)->format('H:i')); ?></td>
            <td>
                <?php if($slot->type === 'class'): ?>
                    <span class="fw-medium"><?php echo e($slot->subject->name ?? 'No Subject'); ?></span>
                <?php elseif($slot->type === 'break'): ?>
                    <span class="badge bg-warning">Break Time</span>
                <?php elseif($slot->type === 'lunch'): ?>
                    <span class="badge bg-info">Lunch Break</span>
                <?php endif; ?>
            </td>
            <td><?php echo e($slot->teacher->first_name ?? ''); ?> <?php echo e($slot->teacher->last_name ?? ''); ?></td>
            <td><?php echo e($slot->room_number ?? '-'); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <tr>
        <td colspan="4" class="text-center py-4">
            <div class="avatar-sm mx-auto mb-3">
                <div class="avatar-title bg-soft-primary text-primary rounded-circle fs-3">
                    <i class="las la-calendar-day"></i>
                </div>
            </div>
            <h5>No Classes Today</h5>
            <p class="text-muted mb-0">Enjoy your day off!</p>
        </td>
    </tr>
<?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

                </div>
            </div>
            
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Upcoming Events</h4>
                    </div>
                    <div class="card-body">
                        <div class="upcoming-event d-flex p-3 border rounded mb-3">
                            <div class="event-date me-3">
                                <span class="day">15</span>
                                <span class="month">Mar</span>
                            </div>
                            <div>
                                <h5 class="mb-1">Mid-Term Exams</h5>
                                <p class="text-muted mb-0">Prepare for your upcoming exams</p>
                            </div>
                        </div>
                        
                        <div class="upcoming-event d-flex p-3 border rounded mb-3">
                            <div class="event-date me-3">
                                <span class="day">22</span>
                                <span class="month">Mar</span>
                            </div>
                            <div>
                                <h5 class="mb-1">Science Exhibition</h5>
                                <p class="text-muted mb-0">School auditorium, 10:00 AM</p>
                            </div>
                        </div>
                        
                        <div class="upcoming-event d-flex p-3 border rounded">
                            <div class="event-date me-3">
                                <span class="day">30</span>
                                <span class="month">Mar</span>
                            </div>
                            <div>
                                <h5 class="mb-1">Parent-Teacher Meeting</h5>
                                <p class="text-muted mb-0">School hall, 2:00 PM - 5:00 PM</p>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Subjects & Financial Summary -->
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">My Subjects</h4>
                        <div class="flex-shrink-0">
                            <a href="<?php echo e(route('student.subjects.index')); ?>" class="btn btn-soft-primary btn-sm">
                                <i class="ri-book-open-line align-middle"></i> View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                                $subjects = auth()->user()->student->academicLevel->subjects ?? collect([]);
                                $displaySubjects = $subjects->take(4);
                            ?>

                            <?php if($displaySubjects->count() > 0): ?>
                                <?php $__currentLoopData = $displaySubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card subject-card border">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="subject-icon bg-primary-subtle">
                                                        <i class="las la-book fs-4 text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1"><?php echo e($subject->name); ?></h6>
                                                        <p class="text-muted mb-0 small"><?php echo e($subject->code); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="col-12">
                                    <div class="text-center py-4">
                                        <div class="avatar-sm mx-auto mb-3">
                                            <div class="avatar-title bg-soft-primary text-primary rounded-circle fs-3">
                                                <i class="las la-book-open"></i>
                                            </div>
                                        </div>
                                        <h5>No Subjects Available</h5>
                                        <p class="text-muted mb-0">No subjects have been assigned yet.</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Financial Summary</h4>
                        <div class="flex-shrink-0">
                            <a href="<?php echo e(route('student.invoices.index')); ?>" class="btn btn-soft-primary btn-sm">
                                <i class="ri-file-list-3-line align-middle"></i> All Invoices
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                            $invoices = auth()->user()->student->invoices ?? collect([]);
                            $pendingInvoices = $invoices->where('status', '!=', 'paid')->take(3);
                        ?>

                        <?php if($pendingInvoices->count() > 0): ?>
                            <h6 class="text-muted mb-3">Pending Payments</h6>
                            <?php $__currentLoopData = $pendingInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="invoice-mini p-3 mb-3 <?php echo e($invoice->status === 'overdue' ? 'invoice-overdue' : 'invoice-pending'); ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Invoice #<?php echo e($invoice->invoice_number); ?></h6>
                                            <p class="text-muted mb-0 small">Due: <?php echo e($invoice->due_date->format('d M, Y')); ?></p>
                                        </div>
                                        <div class="text-end">
                                            <h6 class="mb-1">TSh <?php echo e(number_format($invoice->total_amount, 2)); ?></h6>
                                            <span class="badge bg-<?php echo e($invoice->status === 'overdue' ? 'danger' : 'warning'); ?>">
                                                <?php echo e(ucfirst(str_replace('_', ' ', $invoice->status))); ?>

                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-end">
                                        <a href="<?php echo e(route('student.invoices.show', $invoice)); ?>" class="btn btn-sm btn-soft-primary">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <div class="avatar-sm mx-auto mb-3">
                                    <div class="avatar-title bg-soft-success text-success rounded-circle fs-3">
                                        <i class="las la-check-circle"></i>
                                    </div>
                                </div>
                                <h5>All Payments Completed</h5>
                                <p class="text-muted mb-0">You have no pending payments.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Announcements -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">School Announcements</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 mb-3">
                                <div class="announcement-card p-3 border">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm">
                                                <div class="avatar-title bg-soft-primary text-primary rounded-circle fs-4">
                                                    <i class="ri-megaphone-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="mb-1">Term Schedule Update</h5>
                                            <p class="text-muted mb-0">Posted on March 10, 2023</p>
                                        </div>
                                    </div>
                                    <p class="mb-0">The school term will end on April 15th, 2023. Final exams will begin on April 5th.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="announcement-card p-3 border">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm">
                                                <div class="avatar-title bg-soft-warning text-warning rounded-circle fs-4">
                                                    <i class="ri-notification-2-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="mb-1">Library Hours Extended</h5>
                                            <p class="text-muted mb-0">Posted on March 8, 2023</p>
                                        </div>
                                    </div>
                                    <p class="mb-0">The school library will now remain open until 6:00 PM on weekdays to support exam preparation.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="announcement-card p-3 border">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm">
                                                <div class="avatar-title bg-soft-success text-success rounded-circle fs-4">
                                                    <i class="ri-calendar-event-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="mb-1">Career Day</h5>
                                            <p class="text-muted mb-0">Posted on March 5, 2023</p>
                                        </div>
                                    </div>
                                    <p class="mb-0">Career day will be held on March 25th. Various professionals will be present to guide students.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<script>
    // Live Clock
    function updateClock() {
        const now = new Date();
        document.getElementById('live-clock').textContent = 
            now.toLocaleTimeString('en-US', { hour12: false });
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Session Timer
    const lastLogin = new Date("<?php echo e(auth()->user()->last_login ?? now()); ?>");
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
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lifemate\Desktop\modern\resources\views/student/dashboard.blade.php ENDPATH**/ ?>