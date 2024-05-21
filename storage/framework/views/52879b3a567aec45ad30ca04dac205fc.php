<?php
    $configData = Helper::appClasses();
?>



<?php $__env->startSection('title', 'Create'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1>Create New Permission</h1>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('permissions.store')); ?>" method="POST" id="createPermissionForm">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea id="description" name="description" class="form-control" rows="3"></textarea>
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
                                                    <td><b><?php echo e($module->parent->name); ?></b></td>
                                                    <td><input type="checkbox" class="selectAll"
                                                            data-target="module<?php echo e($module->code); ?>"> Select All</td>
                                                    <td><input type="checkbox"
                                                            name="permissions[<?php echo e($module->code); ?>][create]"
                                                            class="permissionCheckbox module<?php echo e($module->code); ?>"></td>
                                                    <td><input type="checkbox" name="permissions[<?php echo e($module->code); ?>][edit]"
                                                            class="permissionCheckbox module<?php echo e($module->code); ?>"></td>
                                                    <td><input type="checkbox" name="permissions[<?php echo e($module->code); ?>][view]"
                                                            class="permissionCheckbox module<?php echo e($module->code); ?>"></td>
                                                    <td><input type="checkbox"
                                                            name="permissions[<?php echo e($module->code); ?>][delete]"
                                                            class="permissionCheckbox module<?php echo e($module->code); ?>"></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary">Save</button>
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

        function submitForm() {
            document.getElementById('permissionsForm').submit();
        }
        const selectAllCheckboxes = document.querySelectorAll('.selectAll');
        selectAllCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                handleSelectAll(checkbox);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views/permissions/create.blade.php ENDPATH**/ ?>