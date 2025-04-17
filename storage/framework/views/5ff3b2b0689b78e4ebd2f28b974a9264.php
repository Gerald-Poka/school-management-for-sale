
<?php $__env->startSection('title'); ?> My Timetable <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    .timetable-cell {
        min-height: 100px;
        transition: all 0.3s ease;
    }
    .timetable-cell:hover {
        background-color: rgba(75, 56, 179, 0.05);
    }
    .period-cell {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
    .break-cell {
        background-color: #fff3cd;
    }
    .lunch-cell {
        background-color: #d1e7dd;
    }
    .time-column {
        width: 120px;
    }
    .subject-name {
        font-weight: 600;
        color: #4b38b3;
    }
    .teacher-name {
        font-size: 0.875rem;
        color: #6c757d;
    }
    .room-number {
        font-size: 0.75rem;
        color: #495057;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">My Timetable</h4>
                <div class="page-title-right">
                    <span class="text-muted">
                        <?php echo e(auth()->user()->student->academicLevel->name ?? 'Unknown Level'); ?>

                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if($timetable): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="time-column">Time</th>
                                        <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th class="text-center"><?php echo e($day); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $timeSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timeSlot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="align-middle">
                                                <?php echo e($timeSlot[0]); ?> - <?php echo e($timeSlot[1]); ?>

                                            </td>
                                            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $slot = $timetable->slots
                                                        ->where('day_of_week', $day)
                                                        ->where('start_time', $timeSlot[0])
                                                        ->first();
                                                ?>
                                                <td class="timetable-cell align-middle <?php echo e($slot && $slot->type !== 'class' ? $slot->type.'-cell' : ''); ?>">
                                                    <?php if($slot): ?>
                                                        <?php if($slot->type === 'class' && $slot->subject): ?>
                                                            <div class="period-cell p-2">
                                                                <div class="subject-name">
                                                                    <?php echo e($slot->subject->name); ?>

                                                                </div>
                                                                <?php if($slot->teacher): ?>
                                                                    <div class="teacher-name">
                                                                        <?php echo e($slot->teacher->first_name); ?> <?php echo e($slot->teacher->last_name); ?>

                                                                    </div>
                                                                <?php endif; ?>
                                                                <?php if($slot->room_number): ?>
                                                                    <div class="room-number">
                                                                        Room: <?php echo e($slot->room_number); ?>

                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="text-center">
                                                                <strong><?php echo e(ucfirst($slot->type)); ?></strong>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="avatar-lg mx-auto mb-4">
                                <div class="avatar-title bg-soft-primary text-primary display-5 rounded-circle">
                                    <i class="las la-calendar"></i>
                                </div>
                            </div>
                            <h5>No Timetable Available</h5>
                            <p class="text-muted">
                                The timetable for your academic level has not been published yet.
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lifemate\Desktop\modern\resources\views/student/timetable/index.blade.php ENDPATH**/ ?>