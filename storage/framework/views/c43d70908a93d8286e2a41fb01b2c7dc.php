<?php
    $configData = Helper::appClasses();
?>



<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1 class="mb-4">Notes</h1>
        <?php if($createBtn): ?>
            <a href="<?php echo e(route('notes.create')); ?>" class="btn btn-primary mb-3">Create New</a>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-sm mb-3">
                    <form action="<?php echo e(route('notes.index')); ?>" method="GET" class="d-flex">
                        <input type="text" class="form-control mr-3" id="search" name="search"
                            placeholder="Search by notes name" value="<?php echo e(request()->input('search')); ?>">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($note->name); ?></h5>
                            <div class="card-body">
                                <div class="card-content" style="overflow: hidden; max-height: 300px;">
                                    <p><?php echo e(Str::limit($note->description, 200)); ?></p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <?php if($editBtn): ?>
                                    <a href="<?php echo e(route('notes.edit', $note->id)); ?>" class="btn btn-sm btn-primary me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if($deleteBtn): ?>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal<?php echo e($note->id); ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(Auth::check() && Auth::id() == $note->user_id): ?>
                <div class="modal fade" id="deleteModal<?php echo e($note->id); ?>" tabindex="-1"
                    aria-labelledby="deleteModalLabel<?php echo e($note->id); ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel<?php echo e($note->id); ?>">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete <?php echo e($note->name); ?>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="<?php echo e(route('notes.destroy', $note->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div id="pagination" class="pt-2">
            <?php echo e($notes->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views//account/notes/note_index.blade.php ENDPATH**/ ?>