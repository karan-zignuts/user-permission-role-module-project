<?php
    $configData = Helper::appClasses();
?>



<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3>User Management</h3>
                    </div>
                    <div class="card-body">
                        <?php if(session('success')): ?>
                            <div id="successMessage" class="alert alert-success">
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>
                        
                        <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary mb-3">Create New User</a>

                        
                        <form action="<?php echo e(route('users.index')); ?>" method="GET" class="mb-4" id="filterForm">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Search..."
                                        value="<?php echo e(request()->input('search')); ?>">
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-control" id="statusFilter">
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

                        
                        <table class="table" id="userTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-status="<?php echo e($user->is_active ? 'active' : 'inactive'); ?>">
                                        <td><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></td>
                                        <td><?php echo e($user->email); ?></td>
                                        <td>
                                            <?php
                                                $roles = $user->roles;
                                                $rolesCount = $roles->count();
                                                $maxRolesToShow = 3;
                                                $truncatedRoles = $roles->slice(0, $maxRolesToShow);
                                                $remainingRolesCount = $rolesCount - $maxRolesToShow;
                                            ?>

                                            <?php $__currentLoopData = $truncatedRoles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($role->name); ?>

                                                <?php if(!$loop->last): ?>
                                                    ,
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php if($remainingRolesCount > 0): ?>
                                                +<?php echo e($remainingRolesCount); ?>

                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggle-user-status" type="checkbox"
                                                    data-user-id="<?php echo e($user->id); ?>"
                                                    id="flexSwitchCheckUser<?php echo e($user->id); ?>"
                                                    <?php echo e($user->is_active ? 'checked' : ''); ?>>
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckUser<?php echo e($user->id); ?>"></label>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <a href="<?php echo e(route('users.edit', $user->id)); ?>"
                                                class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> </a>
                                            <form id="deleteForm<?php echo e($user->id); ?>"
                                                action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST"
                                                style="display: inline-block;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                    data-user-id="<?php echo e($user->id); ?>"
                                                    data-user-name="<?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?>">
                                                    <i class="fas fa-trash-alt"></i> </button>
                                            </form>
                                        </td>
                                        
                                        <td>
                                            <button type="button" id="earningReportsId"
                                                class="btn btn-primary btn-icon dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsId">
                                                <a href="<?php echo e(route('resetPass', $user->id)); ?>" class="dropdown-item">Reset
                                                    Password</a>

                                                <form action="<?php echo e(route('forceLogout', $user->id)); ?>" method="POST"
                                                    id="forceLogoutForm">
                                                    <?php echo csrf_field(); ?>
                                                    <button class="dropdown-item" type="submit"
                                                        onclick="return confirm('Are you sure you want to force logout?')">Force
                                                        Logout</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        
                        <div id="pagination" class="pt-2">
                            <?php echo e($users->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var filterForm = document.getElementById('filterForm');
            var statusFilter = document.getElementById('statusFilter');
            var userTable = document.getElementById('userTable').getElementsByTagName('tbody')[0]
                .getElementsByTagName('tr');

            filterForm.addEventListener('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(filterForm);
                var search = formData.get('search').toLowerCase();
                var status = formData.get('status');

                Array.from(userTable).forEach(function(row) {
                    var name = row.getElementsByTagName('td')[0].textContent.toLowerCase();
                    var rowStatus = row.dataset.status;

                    if ((search === '' || name.includes(search)) && (status === 'all' ||
                            rowStatus === status)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });


        $(document).ready(function() {
            $('.toggle-user-status').change(function() {
                var userId = $(this).data('user-id');
                var status = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: "<?php echo e(route('users.toggle-status')); ?>",
                    method: 'POST',
                    data: {
                        user_id: userId,
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

        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const userId = event.target.getAttribute('data-user-id');
                    const userName = event.target.getAttribute('data-user-name');

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
                            console.log('Deleting user:', userId);
                            button.disabled =
                                true;
                            document.getElementById('deleteForm' + userId).submit();
                        } else {
                            console.log('Deletion canceled.');
                        }
                    });
                });
            });
        });

        setTimeout(function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.remove();
            }
        }, 3000);
    </script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/sweetalert/dist/sweetalert.css">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views/users/index.blade.php ENDPATH**/ ?>