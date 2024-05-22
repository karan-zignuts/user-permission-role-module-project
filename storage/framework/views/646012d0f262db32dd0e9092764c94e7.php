<?php
    $configData = Helper::appClasses();
?>


<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">
          
            <div class="card-header">
                <h1 class="card-title">Meeting</h1>
                <?php if($createBtn): ?>
                    <a href="<?php echo e(route('meetings.create')); ?>"
                        style="text-decoration: none; background-color: #007bff; color: #fff; padding: 10px; border-radius: 5px;"
                        class="btn btn-primary">Create New</a>
                <?php endif; ?>
            </div>

            <div class="card-body">
              
                <form action="<?php echo e(route('meetings.index')); ?>" method="GET" class="mb-4">
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
                                <th>description</th>
                                <th>date</th>
                                <th>time</th>
                                <th>Status</th>
                                <?php if($editBtn || $deleteBtn): ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $meetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             
                                <?php if(Auth::check() && Auth::id() == $meeting->user_id): ?>
                                    <tr>
                                        <td><?php echo e($meeting->name); ?></td>
                                        <td><?php echo e($meeting->description); ?></td>
                                        <td><?php echo e($meeting->date); ?></td>
                                        <td><?php echo e($meeting->time); ?></td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggle-class" type="checkbox"
                                                    data-meeting-id="<?php echo e($meeting->id); ?>"
                                                    id="flexSwitchCheck<?php echo e($meeting->id); ?>"
                                                    <?php echo e($meeting->is_active ? 'checked' : ''); ?>>
                                                <label class="form-check-label"
                                                    for="flexSwitchCheck<?php echo e($meeting->id); ?>"></label>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <?php if($editBtn || $deleteBtn): ?>
                                                <?php if($editBtn): ?>
                                                    <a href="<?php echo e(route('meetings.edit', $meeting->id)); ?>"
                                                        class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> </a>
                                                <?php endif; ?>
                                                <?php if($deleteBtn): ?>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal<?php echo e($meeting->id); ?>"><i
                                                            class="fas fa-trash-alt"></i> </button>
                                                    <div class="modal fade" id="deleteModal<?php echo e($meeting->id); ?>"
                                                        tabindex="-1"
                                                        aria-labelledby="deleteModalLabel<?php echo e($meeting->id); ?>"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteModalLabel<?php echo e($meeting->id); ?>">
                                                                        Confirm Delete</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <form
                                                                        action="<?php echo e(route('meetings.destroy', $meeting->id)); ?>"
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
                        <?php echo e($meetings->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.toggle-class').change(function() {
                var meetingId = $(this).data('meeting-id');
                var status = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: "<?php echo e(route('meetings.updateStatus')); ?>",
                    method: 'POST',
                    data: {
                        meeting_id: meetingId,
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

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views//account/meetings/meeting_index.blade.php ENDPATH**/ ?>