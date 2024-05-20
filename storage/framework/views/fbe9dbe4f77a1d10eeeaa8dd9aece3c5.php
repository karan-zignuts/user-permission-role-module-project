<!-- resources/views/permissions/index.blade.php -->
<?php
    $configData = Helper::appClasses();
?>



<?php $__env->startSection('title', 'index'); ?>

<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Permissions</h3>
                    </div>
                    <div class="card-body">
                        <a href="<?php echo e(route('permissions.create')); ?>" class="btn btn-primary mb-4"><i class="fas fa-plus"></i>
                            Create New
                            Permission</a>

                        <form action="<?php echo e(route('permissions.index')); ?>" method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Search..."
                                        value="<?php echo e(request()->input('search')); ?>">
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-control">
                                        <option value="all" <?php echo e(request()->input('status') == 'all' ? 'selected' : ''); ?>>
                                            All</option>
                                        <option value="active"
                                            <?php echo e(request()->input('status') == 'active' ? 'selected' : ''); ?>>Active
                                        </option>
                                        <option value="inactive"
                                            <?php echo e(request()->input('status') == 'inactive' ? 'selected' : ''); ?>>Inactive
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive mb-2">
                            <table class="table table-striped permissions-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($permission->name); ?></td>
                                            <td><?php echo e($permission->description); ?></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input toggle-class" type="checkbox"
                                                        data-permission-id="<?php echo e($permission->id); ?>"
                                                        id="flexSwitchCheck<?php echo e($permission->id); ?>"
                                                        <?php echo e($permission->is_active ? 'checked' : ''); ?>>
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheck<?php echo e($permission->id); ?>"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(route('permissions.edit', $permission->id)); ?>"
                                                    class="btn btn-info btn-sm"><i class="fas fa-edit"></i> </a>
                                                <form action="<?php echo e(route('permissions.destroy', $permission->id)); ?>"
                                                    method="POST" class="d-inline" id="deletePermissionForm">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm delete-permission-btn"><i
                                                            class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="pagination" class="pt-2">
                            <?php echo e($permissions->appends(request()->query())->links()); ?>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var permission_id = $(this).data('permission-id');
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: '<?php echo e(route('permissions.toggleStatus', ':permission_id')); ?>'.replace(
                        ':permission_id', permission_id),
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: {
                        'status': status,
                        'permission_id': permission_id
                    },
                    success: function(data) {
                        console.log(data.success)
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-permission-btn').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the form from submitting

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this permission!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('deletePermissionForm').submit();
                        }
                    });
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views/permissions/index.blade.php ENDPATH**/ ?>