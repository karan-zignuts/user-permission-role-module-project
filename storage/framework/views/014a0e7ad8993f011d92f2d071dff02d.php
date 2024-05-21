<?php
    $configData = Helper::appClasses();
?>



<?php $__env->startSection('title', 'Create'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h3><b>
                            <div class="card-header">Edit Permission</div>
                        </b></h3>
                    <div class="card-body">
                        <form action="<?php echo e(route('permissions.update', $permission->id)); ?>" method="POST" id="permissionsForm">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    value="<?php echo e($permission->name); ?>">
                            </div>
                            <div class="form-group mt-2">
                                <label for="description">Description:</label>
                                <textarea id="description" name="description" class="form-control"><?php echo e($permission->description); ?></textarea>
                            </div>
                            <div class="form-group mt-2">
                                <label>Module-wise Permissions:</label>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Module</th>
                                            <th>Parent Module</th>
                                            <th>All</th>
                                            <th>Create</th>
                                            <th>Edit</th>
                                            <th>View</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($module->parent()->count() > 0): ?>
                                                <tr>
                                                    <td><?php echo e($module->name); ?></td>
                                                    <td><strong><?php echo e($module->parent->name); ?></strong></td>
                                                    <td><input type="checkbox" class="selectAll"
                                                            data-target="module<?php echo e($module->code); ?>"> Select All</td>
                                                    <?php $__currentLoopData = ['create', 'edit', 'view', 'delete']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <td>
                                                            <?php
                                                                $permissionExists = $permission->hasPermission(
                                                                    $module->code,
                                                                    $action,
                                                                );
                                                            ?>
                                                            <input type="checkbox"
                                                                name="permissions[<?php echo e($module->code); ?>][<?php echo e($action); ?>]"
                                                                class="permissionCheckbox module<?php echo e($module->code); ?>"
                                                                value="1" <?php echo e($permissionExists ? 'checked' : ''); ?>>
                                                        </td>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <input type="hidden" name="permissions[<?php echo e($module->code); ?>][dummy]"
                                                        value="0">
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="<?php echo e(route('permissions.index')); ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleSelectAll(checkbox) {
            const checkboxes = checkbox.parentElement.parentElement.querySelectorAll('.permissionCheckbox');
            checkboxes.forEach(cb => {
                cb.checked = checkbox.checked;
            });
        }
        const selectAllCheckboxes = document.querySelectorAll('.selectAll');
        selectAllCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                handleSelectAll(checkbox);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views/permissions/edit.blade.php ENDPATH**/ ?>