
<?php $__env->startSection('title'); ?> Results Management <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('build/libs/datatables/datatables.min.css')); ?>" rel="stylesheet">
<style>
    .grade-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.875rem;
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
    .grade-d {
        background-color: rgba(230, 126, 34, 0.1);
        color: #d35400;
    }
    .grade-f {
        background-color: rgba(231, 76, 60, 0.1);
        color: #c0392b;
    }
    .action-btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
        margin: 0 0.2rem;
        border-radius: 0.25rem;
    }
    
    .btn-edit {
        background-color: rgba(52, 152, 219, 0.1);
        color: #2980b9;
        border: none;
    }
    
    .btn-edit:hover {
        background-color: rgba(52, 152, 219, 0.2);
        color: #2980b9;
    }
    
    .btn-delete {
        background-color: rgba(231, 76, 60, 0.1);
        color: #c0392b;
        border: none;
    }
    
    .btn-delete:hover {
        background-color: rgba(231, 76, 60, 0.2);
        color: #c0392b;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Results <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Results Management <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="card-title mb-0">Student Results</h5>
                    <a href="<?php echo e(route('admin.results.create')); ?>" class="btn btn-primary">
                        <i class="ri-add-line align-bottom me-1"></i> Upload Results
                    </a>
                </div>
                
                <form action="<?php echo e(route('admin.results.index')); ?>" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <select name="academic_level" class="form-select">
                            <option value="">All Levels</option>
                            <?php $__currentLoopData = $academicLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($level->order); ?>" <?php echo e(request('academic_level') == $level->order ? 'selected' : ''); ?>>
                                    Standard <?php echo e($level->order); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <select name="subject_id" class="form-select">
                            <option value="">All Subjects</option>
                            <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($subject->id); ?>" <?php echo e(request('subject_id') == $subject->id ? 'selected' : ''); ?>>
                                    <?php echo e($subject->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <select name="exam_type" class="form-select">
                            <option value="">All Exam Types</option>
                            <option value="Mid Term" <?php echo e(request('exam_type') == 'Mid Term' ? 'selected' : ''); ?>>Mid Term</option>
                            <option value="Final" <?php echo e(request('exam_type') == 'Final' ? 'selected' : ''); ?>>Final</option>
                            <option value="Quiz" <?php echo e(request('exam_type') == 'Quiz' ? 'selected' : ''); ?>>Quiz</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="ri-filter-3-line align-bottom me-1"></i> Filter
                            </button>
                            <a href="<?php echo e(route('admin.results.index')); ?>" class="btn btn-light">
                                <i class="ri-refresh-line align-bottom"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Subject</th>
                                <th>Exam Type</th>
                                <th>Marks</th>
                                <th>Grade</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($result->student->admission_number); ?> -
                                        <?php echo e($result->student->first_name); ?> <?php echo e($result->student->last_name); ?>

                                        <small class="d-block text-muted">
                                            Standard <?php echo e($result->student->academicLevel->order); ?>

                                        </small>
                                    </td>
                                    <td><?php echo e($result->subject->name); ?></td>
                                    <td><?php echo e($result->exam_type); ?></td>
                                    <td><?php echo e($result->marks_obtained); ?>%</td>
                                    <td>
                                        <span class="grade-badge grade-<?php echo e(strtolower($result->grade)); ?>">
                                            <?php echo e($result->grade); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($result->exam_date->format('d M, Y')); ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo e(route('admin.results.edit', $result->id)); ?>" 
                                           class="btn action-btn btn-edit" 
                                           title="Edit Result">
                                            <i class="ri-pencil-line align-bottom"></i>
                                        </a>
                                        
                                        <button type="button" 
                                                class="btn action-btn btn-delete" 
                                                onclick="if(confirm('Are you sure you want to delete this result?')) document.getElementById('delete-form-<?php echo e($result->id); ?>').submit();"
                                                title="Delete Result">
                                            <i class="ri-delete-bin-line align-bottom"></i>
                                        </button>
                                        
                                        <form id="delete-form-<?php echo e($result->id); ?>" 
                                              action="<?php echo e(route('admin.results.destroy', $result->id)); ?>" 
                                              method="POST" 
                                              class="d-none">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/datatables/datatables.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        $('.datatable').DataTable({
            order: [[5, 'desc']], // Sort by date descending
            pageLength: 25,
            language: {
                search: "",
                lengthMenu: "_MENU_ results per page",
            },
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            initComplete: function() {
                $('.dataTables_filter input').attr("placeholder", "Search results...");
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lifemate\Desktop\modern\resources\views/admin/results/index.blade.php ENDPATH**/ ?>