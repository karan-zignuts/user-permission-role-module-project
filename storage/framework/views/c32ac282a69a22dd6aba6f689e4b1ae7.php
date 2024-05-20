<?php $__env->startSection('content'); ?>
<form method="POST" action="<?php echo e(route('auth-login-basic')); ?>">
  <?php echo csrf_field(); ?>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Login</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views/auth/login.blade.php ENDPATH**/ ?>