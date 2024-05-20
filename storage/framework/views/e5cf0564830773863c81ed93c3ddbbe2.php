<?php
    $configData = Helper::appClasses();
?>



<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card shadow">
            <div class="card-header text-white" >
                <h1 class="card-title mb-0">Edit Activity</h1>
            </div>
            <div class="card-body" >
                <form action="<?php echo e(url('/activities/'.$activity->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="mb-3">
                        <b><label for="name" class="form-label">Name</label></b>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo e($activity->name); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"><?php echo e($activity->description); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="assign_person" class="form-label">Assigned Person</label>
                        <input type="text" class="form-control" id="assign_person" name="assign_person" value="<?php echo e($activity->assign_person); ?>">
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary me-md-2">Save</button>
                        <a href="<?php echo e(url('/activities')); ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views//account/activity-log/activity_edit.blade.php ENDPATH**/ ?>