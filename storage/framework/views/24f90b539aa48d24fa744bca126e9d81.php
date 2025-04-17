
<?php $__env->startSection('title'); ?> My Invoices <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Financial Records <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> My Invoices <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Date</th>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($invoice->invoice_number); ?></td>
                                        <td><?php echo e($invoice->invoice_date->format('d/m/Y')); ?></td>
                                        <td><?php echo e($invoice->due_date->format('d/m/Y')); ?></td>
                                        <td>TSh <?php echo e(number_format($invoice->total_amount, 2)); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo e($invoice->status === 'paid' ? 'success' : 
                                                ($invoice->status === 'partially_paid' ? 'warning' : 
                                                ($invoice->status === 'overdue' ? 'danger' : 'info'))); ?>">
                                                <?php echo e(ucfirst(str_replace('_', ' ', $invoice->status))); ?>

                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex gap-2 justify-content-end">
                                                
                                                <a href="<?php echo e(route('student.invoices.show', $invoice)); ?>" 
                                                   class="btn btn-soft-primary btn-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="View Details">
                                                    <i class="ri-eye-fill"></i>
                                                </a>

                                                
                                                <a href="<?php echo e(route('student.invoices.print', $invoice)); ?>" 
                                                   class="btn btn-soft-info btn-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Print Invoice">
                                                    <i class="ri-printer-fill"></i>
                                                </a>

                                                
                                                <?php if($invoice->status !== 'paid'): ?>
                                                <a href="<?php echo e(route('student.invoices.pay', $invoice)); ?>" 
                                                   class="btn btn-soft-success btn-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Make Payment">
                                                    <i class="ri-bank-card-fill"></i>
                                                </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No invoices found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php echo e($invoices->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lifemate\Desktop\modern\resources\views/student/invoices/index.blade.php ENDPATH**/ ?>