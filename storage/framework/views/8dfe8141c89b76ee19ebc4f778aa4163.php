<?php
    $configData = Helper::appClasses();
?>



<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit User</h3>
                    </div>
                    
                    <div class="card-body">
                        <form action="<?php echo e(route('users.update', $user->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" value="<?php echo e($user->first_name); ?>"
                                    class="form-control">
                            </div>
                            <div class="form-group mt-2">
                                <label for="role">Role:</label>
                                <select id="role" name="role[]" class="form-control" multiple>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($role->id); ?>"
                                            <?php echo e(in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'selected' : ''); ?>>
                                            <?php echo e($role->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <label for="contact">Contact:</label>
                                <input type="text" id="contact" name="contact" value="<?php echo e($user->phone_number); ?>"
                                    class="form-control">
                            </div>
                            <div class="form-group mt-2">
                                <label for="address">Address:</label>
                                <input type="text" id="address" name="address" value="<?php echo e($user->address); ?>"
                                    class="form-control">
                            </div>
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views/users/edit.blade.php ENDPATH**/ ?>