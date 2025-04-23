
<?php $__env->startSection('title'); ?> Exam Results <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<style>
    .results-table {
        background: var(--vz-card-bg-custom);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .grade-badge {
        font-size: 0.875rem;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        display: inline-block;
    }
    
    .grade-a {
        background-color: rgba(46, 204, 113, 0.1);
        color: #27ae60;
    }
    
    .grade-b {
        background-color: rgba(52, 152, 219, 0.1);
        color: #2980b9;
    }
    
    .grade-c {
        background-color: rgba(241, 196, 15, 0.1);
        color: #f39c12;
    }
    
    .grade-f {
        background-color: rgba(231, 76, 60, 0.1);
        color: #c0392b;
    }
    
    .pending-badge {
        background-color: rgba(241, 196, 15, 0.1);
        color: #f39c12;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.875rem;
    }
    
    .progress {
        width: 100px;
        height: 6px !important;
        margin: 0;
    }
    
    .table > :not(caption) > * > * {
        padding: 1rem 1.25rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> Student <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> Exam Results <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if($subjects->isEmpty()): ?>
                        <div class="text-center p-4">
                            <i class="las la-graduation-cap fs-1 text-muted mb-3"></i>
                            <h5 class="card-title">No Subjects Available</h5>
                            <p class="text-muted">You don't have any subjects registered yet.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive results-table">
                            <table class="table table-nowrap align-middle mb-0">
                                <thead>
                                    <tr class="table-primary">
                                        <th scope="col">Subject</th>
                                        <th scope="col">Exam Type</th>
                                        <th scope="col">Marks</th>
                                        <th scope="col">Grade</th>
                                        <th scope="col">Progress</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($subject->results->isEmpty()): ?>
                                            <tr>
                                                <td><?php echo e($subject->name); ?></td>
                                                <td colspan="6" class="text-center">
                                                    <div class="pending-badge">
                                                        Results Pending
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php $__currentLoopData = $subject->results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($subject->name); ?></td>
                                                    <td><?php echo e($result->exam_type); ?></td>
                                                    <td><?php echo e($result->marks_obtained); ?>%</td>
                                                    <td>
                                                        <span class="grade-badge grade-<?php echo e(strtolower($result->grade)); ?>">
                                                            <?php echo e($result->grade); ?>

                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success" role="progressbar" 
                                                                style="width: <?php echo e(($result->marks_obtained)); ?>%">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?php echo e($result->exam_date->format('M d, Y')); ?></td>
                                                    <td>
                                                        <?php if($result->remarks): ?>
                                                            <small class="text-muted"><?php echo e($result->remarks); ?></small>
                                                        <?php else: ?>
                                                            <small class="text-muted">-</small>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lifemate\Desktop\modern\resources\views/student/results/index.blade.php ENDPATH**/ ?>