<!-- Display modules -->
<?php
    $configData = Helper::appClasses();
?>
<?php $__env->startSection('title', 'index'); ?>






<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Modules</h1>
                <form action="<?php echo e(route('modules.index')); ?>" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search..."
                                value="<?php echo e(request()->input('search')); ?>">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="all" <?php echo e(request()->input('status') == 'all' ? 'selected' : ''); ?>>All
                                </option>
                                <option value="active" <?php echo e(request()->input('status') == 'active' ? 'selected' : ''); ?>>Active
                                </option>
                                <option value="inactive" <?php echo e(request()->input('status') == 'inactive' ? 'selected' : ''); ?>>
                                    Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                <div id="accordionExample"> <!-- Add ID to parent container -->
                    <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="card mb-3">
                            <div class="card-header" id="heading<?php echo e($loop->index); ?>">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                        data-target="#collapse<?php echo e($loop->index); ?>" aria-expanded="true"
                                        aria-controls="collapse<?php echo e($loop->index); ?>">
                                        <?php echo e($module->name); ?>

                                    </button>
                                </h5>
                            </div>

                            <div id="collapse<?php echo e($loop->index); ?>" class="collapse"
                                aria-labelledby="heading<?php echo e($loop->index); ?>" data-parent="#accordionExample">
                                <div class="card-body">
                                    <?php if($module->children->isNotEmpty()): ?>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Module</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?php $__currentLoopData = $module->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subModule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <tr>
                                                  <td><?php echo e($subModule->name); ?></td>
                                                  <td><?php echo e($subModule->description); ?></td>
                                                  <td>
                                                  <div class="form-check form-switch">
                                                    <input class="form-check-input toggle-class" type="checkbox"
                                                        data-module-id="<?php echo e($subModule->code); ?>" id="flexSwitchCheck<?php echo e($subModule->code); ?>"
                                                        <?php echo e($subModule->is_active ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="flexSwitchCheck<?php echo e($subModule->code); ?>"></label>


                                                    

                                                </div>
                                                  </td>
                                                  <td>
                                                      <div class="float-right">
                                                          <a href="<?php echo e(route('modules.edit', $subModule)); ?>"
                                                              class="btn btn-sm btn-primary ml-2">Edit</a>
                                                      </div>
                                                  </td>
                                              </tr>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <p>No sub-modules found.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <script>
      $(document).ready(function () {
          $('.toggle-class').change(function () {
              var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
              var submoduleId = $(this).data('module-id');
              var status = $(this).prop('checked') == true ? 1 : 0;
              $.ajax({
                  type: "PUT",
                  dataType: "json",
                  url: '<?php echo e(route('modules.toggleStatus', ':submoduleId')); ?>'.replace(':submoduleId', submoduleId),
                  // url: '<?php echo e(route('modules.toggleStatus', ['submoduleId' => ':submoduleId'])); ?>'.replace(':submoduleId', submoduleId),
                  headers: {
                      'X-CSRF-TOKEN': CSRF_TOKEN
                  },
                  data: {'status': status, 'submoduleId': submoduleId},
                  success: function (data) {
                      console.log(data.success)
                  }
              });
          });
      });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views/modules/index.blade.php ENDPATH**/ ?>