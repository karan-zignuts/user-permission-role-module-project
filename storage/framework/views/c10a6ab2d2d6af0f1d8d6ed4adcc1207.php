<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Edit Meeting</h2>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('meetings.update', $meeting)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="<?php echo e($meeting->name); ?>">
                    </div>
                    <div class="form-group mt-2">
                        <label for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description"><?php echo e($meeting->description); ?></textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label for="date">Date:</label>
                        <input type="date" class="form-control" id="date" name="date"
                            value="<?php echo e($meeting->date); ?>" min="<?php echo e(now()->toDateString()); ?>">
                    </div>
                    <div class="form-group mt-2">
                        <label for="time">Time:</label>
                        <input type="time" class="form-control" id="time" name="time"
                            value="<?php echo e($meeting->time); ?>">
                    </div>
                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="<?php echo e(route('meetings.index')); ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views//account/meetings/meeting_edit.blade.php ENDPATH**/ ?>