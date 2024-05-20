
<?php $__env->startComponent('mail::message'); ?>
# Hello <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?> ,

You have been invited to join our platform. Click the link below to accept the invitation:

<?php $__env->startComponent('mail::button', ['url' => route('acceptinvite', ['token' => $token])]); ?>
Accept Invitation
<?php echo $__env->renderComponent(); ?>

Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views/emails/invitation.blade.php ENDPATH**/ ?>