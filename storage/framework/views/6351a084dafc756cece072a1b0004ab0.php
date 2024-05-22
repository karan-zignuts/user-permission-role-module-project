<?php
    $configData = Helper::appClasses();
?>




<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card my-4">
                    <div class="card-header">
                        <h2 class="card-title text-center">User Details</h2>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center mb-4">
                                <img src="<?php echo e(asset('assets/img/avatars/14.png')); ?>" alt="User Image"
                                    class="d-block img-fluid rounded-circle mb-3">
                            </div>
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <strong>Name:</strong> <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?>

                                        </div>
                                        <div class="mb-3">
                                            <strong>Contact No:</strong> <?php echo e($user->phone_number); ?>

                                        </div>
                                        <div class="mb-3">
                                            <strong>Address:</strong> <?php echo e($user->address); ?>

                                        </div>
                                        <div class="mb-3">
                                            <strong>Roles:</strong>

                                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="list-inline-item"><?php echo e($role->name); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <a href="<?php echo e(route('userside.edit')); ?>" class="btn btn-primary btn-block">Edit</a>
                            </div>
                            <div class="col-md-6">
                                <a href="<?php echo e(route('changePassword')); ?>" class="btn btn-primary btn-block">Change
                                    Password</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views/userside/details.blade.php ENDPATH**/ ?>