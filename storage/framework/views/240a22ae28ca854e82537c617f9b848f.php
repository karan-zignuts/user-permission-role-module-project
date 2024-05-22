<?php if(isset($pageConfigs)): ?>
    <?php echo Helper::updatePageConfig($pageConfigs); ?>

<?php endif; ?>
<?php
    $configData = Helper::appClasses();
?>

<?php if(isset($configData['layout'])): ?>
    <?php echo $__env->make(
        $configData['layout'] === 'horizontal'
            ? 'layouts.horizontalLayout'
            : ($configData['layout'] === 'blank'
                ? 'layouts.blankLayout'
                : 'layouts.contentNavbarLayout'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views////layouts/layoutMaster.blade.php ENDPATH**/ ?>