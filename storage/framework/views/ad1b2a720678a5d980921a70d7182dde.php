<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1 class="mb-4">Edit Note</h1>

        <div class="card ">
            <div class="card-body">
                <form action="<?php echo e(route('notes.update', $note)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo e($note->name); ?>">
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" class="form-control" style="height: 200px"><?php echo e($note->description); ?></textarea>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="<?php echo e(route('notes.index')); ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views//account/notes/note_edit.blade.php ENDPATH**/ ?>