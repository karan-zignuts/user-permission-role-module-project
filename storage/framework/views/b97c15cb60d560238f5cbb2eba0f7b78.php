<?php
    $configData = Helper::appClasses();
?>


<?php $__env->startSection('content'); ?>
<div class="container">
  <div class="row justify-content-center mt-4">
      <div class="col-md-6 mx-auto">
          <div class="card">
              <div class="card-header">Welcome! Set Your Password</div>

              <div class="card-body">
                  <form method="POST" action="<?php echo e(route('setpassword')); ?>">
                      <?php echo csrf_field(); ?>
                      <input type="hidden" name="token" value="<?php echo e($token); ?>">

                      <div class="form-group">
                          <label for="password">Password</label>
                          <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" name="password" required autocomplete="new-password">
                          <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                              <span class="invalid-feedback" role="alert">
                                  <strong><?php echo e($message); ?></strong>
                              </span>
                          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                      </div>

                      <div class="form-group mt-2">
                          <label for="password_confirmation">Confirm Password</label>
                          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                      </div>

                      <div class="form-group mt-2">
                          <button type="submit" class="btn btn-primary">Save Password</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views/set_password.blade.php ENDPATH**/ ?>