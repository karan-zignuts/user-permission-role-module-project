<?php
    $configData = Helper::appClasses();
?>


<?php $__env->startSection('content'); ?>
    <h1>Company List</h1>
    <?php if($createBtn): ?>
        <a href="<?php echo e(route('companies.create')); ?>" class="btn btn-success mb-4">Create New</a>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <div class="input-group input-group-sm mb-3">
                <form action="<?php echo e(route('companies.index')); ?>" method="GET" class="d-flex">
                    <input type="text" class="form-control mr-3" id="search" name="search"
                        placeholder="Search by notes name" value="<?php echo e(request()->input('search')); ?>">
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php if(Auth::check() && Auth::id() == $company->user_id): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($company->name); ?></h5>
                            <p class="card-text"><strong>Owner:</strong> <?php echo e($company->owner_name); ?></p>
                            <p class="card-text"><strong>Address:</strong> <?php echo e($company->address); ?></p>
                            <p class="card-text"><strong>Industry:</strong> <?php echo e($company->industry); ?></p>

                            <td>
                                <?php if($editBtn): ?>
                                    <a href="<?php echo e(route('companies.edit', $company->id)); ?>" class="btn btn-sm btn-primary"><i
                                            class="fas fa-edit"></i> </a>
                                <?php endif; ?>

                                <?php if($deleteBtn): ?>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal<?php echo e($company->id); ?>"><i class="fas fa-trash-alt"></i>
                                    </button>
                                    <div class="modal fade" id="deleteModal<?php echo e($company->id); ?>" tabindex="-1"
                                        aria-labelledby="deleteModalLabel<?php echo e($company->id); ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel<?php echo e($company->id); ?>">
                                                        Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <form action="<?php echo e(route('companies.destroy', $company->id)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col">
                <p>No companies found.</p>
            </div>
        <?php endif; ?>
    </div>

    <div id="pagination" class="pt-2">
        <?php echo e($companies->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views//contact/company/company_index.blade.php ENDPATH**/ ?>