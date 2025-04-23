
<?php $__env->startSection('title'); ?> Upload Results <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    .action-btn {
        padding: 0.5rem 1.5rem;
        margin: 0 0.25rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Results <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Upload New Result <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <?php echo $__env->make('partials.notifications', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('admin.results.create')); ?>" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Academic Level</label>
                                <select class="form-select" id="academic_level" name="academic_level" onchange="this.form.submit()">
                                    <option value="">Select Level</option>
                                    <?php $__currentLoopData = $academicLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($level->order); ?>" <?php echo e($selectedLevel == $level->order ? 'selected' : ''); ?>>
                                            <?php echo e($level->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <form action="<?php echo e(route('admin.results.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="academic_level" value="<?php echo e($selectedLevel); ?>">
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Student</label>
                                <select class="form-select" name="student_id" id="student_id" required>
                                    <option value="">Select Student</option>
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($student->id); ?>">
                                            <?php echo e($student->admission_number); ?> - <?php echo e($student->full_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Subject</label>
                                <select class="form-select" name="subject_id" required>
                                    <option value="">Select Subject</option>
                                    <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($subject->id); ?>"><?php echo e($subject->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Exam Type</label>
                                <select class="form-select" name="exam_type" required>
                                    <option value="">Select Type</option>
                                    <option value="Mid Term">Mid Term</option>
                                    <option value="Final">Final</option>
                                    <option value="Quiz">Quiz</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Marks Obtained</label>
                                <input type="number" class="form-control" name="marks_obtained" 
                                       min="0" max="100" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Grade</label>
                                <select class="form-select" name="grade" required>
                                    <option value="">Select Grade</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="F">F</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Exam Date</label>
                                <input type="date" class="form-control" name="exam_date" required>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Remarks</label>
                                <textarea class="form-control" name="remarks" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary action-btn">
                                    <i class="ri-save-line align-bottom me-1"></i> Save Result
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/select2/select2.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        // Initialize select2 for better dropdown experience
        $('#student_id').select2({
            placeholder: "Select a student",
            allowClear: true
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lifemate\Desktop\modern\resources\views/admin/results/create.blade.php ENDPATH**/ ?>