<?php
    $configData = Helper::appClasses();
?>



<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Edit Person</h1>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo e(route('companies.update', $company)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">Name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?php echo e($company->name); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="owner_name" class="col-sm-2 col-form-label">Owner_Name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="owner_name" name="owner_name"
                                value="<?php echo e($company->owner_name); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="address" class="col-sm-2 col-form-label">Address:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="address" name="address"
                                value="<?php echo e($company->address); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="phone_number" class="col-sm-2 col-form-label">Contact No:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                value="<?php echo e($company->industry); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="<?php echo e(route('companies.index')); ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views//contact/company/company_edit.blade.php ENDPATH**/ ?>