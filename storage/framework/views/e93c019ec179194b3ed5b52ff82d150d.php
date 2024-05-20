<?php
    $configData = Helper::appClasses();
?>



<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Edit Role</h3></div>
                    <div class="card-body">
                        <form action="<?php echo e(route('roles.update', $role->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" value="<?php echo e($role->name); ?>" class="form-control">
                            </div>
                            <div class="form-group mt-2">
                                <label for="description">Description:</label>
                                <input type="text" id="description" name="description" value="<?php echo e($role->description); ?>" class="form-control">
                            </div>
                            <div class="form-group mt-2">
                                <label for="permissions">Permissions:</label>
                                <select id="permissions" name="permissions[]" class="form-control" multiple size="5">
                                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($permission->id); ?>" <?php echo e($role->permissions->contains($permission->id) ? 'selected' : ''); ?>>
                                            <?php echo e($permission->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="<?php echo e(route('roles.index')); ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views/roles/edit.blade.php ENDPATH**/ ?>