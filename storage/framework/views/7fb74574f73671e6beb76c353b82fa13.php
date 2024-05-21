<?php
    $configData = Helper::appClasses();
?>



<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h2 class="card-header">Create New Note</h2>

                    <div class="card-body">
                        <form action="<?php echo e(route('notes.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Enter note name" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="description">Description:</label>
                                <textarea id="description" name="description" class="form-control" placeholder="Enter note description" rows="4"
                                    required></textarea>
                            </div>
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary mr-2">Save</button>
                                <a href="<?php echo e(route('notes.index')); ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views//account/notes/note_create.blade.php ENDPATH**/ ?>