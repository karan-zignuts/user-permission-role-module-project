<?php
    $configData = Helper::appClasses();
?>



<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php if(session('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header">
                        <h3>Roles</h3>
                    </div>
                    <div class="card-body">
                        <a href="<?php echo e(route('roles.create')); ?>" class="btn btn-primary mb-3">Create New Role</a>
                        <form action="<?php echo e(route('roles.index')); ?>" method="GET" class="mb-4">
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
                                            <?php echo e(request()->input('status') == 'active' ? 'selected' : ''); ?>>Active</option>
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($role->name); ?></td>
                                        <td><?php echo e($role->description); ?></td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggle-class" type="checkbox"
                                                    data-role-id="<?php echo e($role->id); ?>"
                                                    id="flexSwitchCheck<?php echo e($role->id); ?>"
                                                    <?php echo e($role->is_active ? 'checked' : ''); ?>>
                                                <label class="form-check-label"
                                                    for="flexSwitchCheck<?php echo e($role->id); ?>"></label>
                                            </div>
                                        </td>

                                        <td>
                                            <a href="<?php echo e(route('roles.edit', $role->id)); ?>"
                                                class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> </a>
                                            <form id="deleteRoleForm<?php echo e($role->id); ?>"
                                                action="<?php echo e(route('roles.destroy', $role->id)); ?>" method="POST"
                                                class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger delete-role-btn"
                                                    data-role-id="<?php echo e($role->id); ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <div id="pagination" class="pt-2">
                            <?php echo e($roles->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.toggle-class').change(function() {
                var roleId = $(this).data('role-id');
                var status = $(this).prop('checked') ? 1 : 0;
                $.ajax({
                    url: "<?php echo e(route('roles.updateStatus')); ?>",
                    method: 'POST',
                    data: {
                        role_id: roleId,
                        status: status,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.delete-role-btn').click(function(e) {
                e.preventDefault();
                var roleId = $(this).data('role-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#deleteRoleForm' + roleId).submit();
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views/roles/index.blade.php ENDPATH**/ ?>