<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">People</h1>
        
                <?php if($createBtn): ?>
                    <a href="<?php echo e(route('people.create')); ?>" class="btn btn-primary">Create New People</a>
                <?php endif; ?>
            </div>

            <div class="card-body">
               
                <form action="<?php echo e(route('people.index')); ?>" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search..."
                                value="<?php echo e(request()->input('search')); ?>">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="all" <?php echo e(request()->input('status') == 'all' ? 'selected' : ''); ?>>
                                    All</option>
                                <option value="active" <?php echo e(request()->input('status') == 'active' ? 'selected' : ''); ?>>Active
                                </option>
                                <option value="inactive" <?php echo e(request()->input('status') == 'inactive' ? 'selected' : ''); ?>>
                                    Inactive
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                 
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Address</th>
                                <th>Status</th>
                                <?php if($editBtn || $deleteBtn): ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $people; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                                <?php if(Auth::check() && Auth::id() == $person->user_id): ?>
                                    <tr>
                                        <td><?php echo e($person->name); ?></td>
                                        <td><?php echo e($person->designation); ?></td>
                                        <td><?php echo e($person->address); ?></td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggle-class" type="checkbox"
                                                    data-person-id="<?php echo e($person->id); ?>"
                                                    id="flexSwitchCheck<?php echo e($person->id); ?>"
                                                    <?php echo e($person->is_active ? 'checked' : ''); ?>>
                                                <label class="form-check-label"
                                                    for="flexSwitchCheck<?php echo e($person->id); ?>"></label>
                                            </div>
                                        </td>
                                         
                                        <td>
                                            <?php if($editBtn || $deleteBtn): ?>
                                                <?php if($editBtn): ?>
                                                    <a href="<?php echo e(route('people.edit', $person->id)); ?>"
                                                        class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> </a>
                                                <?php endif; ?>

                                                <?php if($deleteBtn): ?>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal<?php echo e($person->id); ?>"><i
                                                            class="fas fa-trash-alt"></i> </button>
                                                    <div class="modal fade" id="deleteModal<?php echo e($person->id); ?>"
                                                        tabindex="-1"
                                                        aria-labelledby="deleteModalLabel<?php echo e($person->id); ?>"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteModalLabel<?php echo e($person->id); ?>">
                                                                        Confirm Delete</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete <?php echo e($person->name); ?>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <form
                                                                        action="<?php echo e(route('people.destroy', $person->id)); ?>"
                                                                        method="POST">
                                                                        <?php echo csrf_field(); ?>
                                                                        <?php echo method_field('DELETE'); ?>
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    
                    <div id="pagination" class="pt-2">
                        <?php echo e($people->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.toggle-class').change(function() {
                var personId = $(this).data('person-id');
                var status = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: "<?php echo e(route('people.updateStatus')); ?>",
                    method: 'POST',
                    data: {
                        person_id: personId,
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views//contact/people/people_index.blade.php ENDPATH**/ ?>