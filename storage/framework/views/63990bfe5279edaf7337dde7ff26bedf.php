<!DOCTYPE html>

<html lang="<?php echo e(session()->get('locale') ?? app()->getLocale()); ?>" class="<?php echo e($configData['style']); ?>-style <?php echo e($navbarFixed ?? ''); ?> <?php echo e($menuFixed ?? ''); ?> <?php echo e($menuCollapsed ?? ''); ?> <?php echo e($footerFixed ?? ''); ?> <?php echo e($customizerHidden ?? ''); ?>" dir="<?php echo e($configData['textDirection']); ?>" data-theme="<?php echo e($configData['theme']); ?>" data-assets-path="<?php echo e(asset('/assets') . '/'); ?>" data-base-url="<?php echo e(url('/')); ?>" data-framework="laravel" data-template="<?php echo e($configData['layout'] . '-menu-' . $configData['theme'] . '-' . $configData['style']); ?>">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title><?php echo $__env->yieldContent('title'); ?> |
    <?php echo e(config('variables.templateName') ? config('variables.templateName') : 'TemplateName'); ?> -
    <?php echo e(config('variables.templateSuffix') ? config('variables.templateSuffix') : 'TemplateSuffix'); ?>

  </title>
  <meta name="description" content="<?php echo e(config('variables.templateDescription') ? config('variables.templateDescription') : ''); ?>" />
  <meta name="keywords" content="<?php echo e(config('variables.templateKeyword') ? config('variables.templateKeyword') : ''); ?>">
  <!-- laravel CRUD token -->
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <!-- Canonical SEO -->
  <link rel="canonical" href="<?php echo e(config('variables.productPage') ? config('variables.productPage') : ''); ?>">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?php echo e(asset('assets/img/favicon/favicon.ico')); ?>" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


  <script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>


  <!-- Include Styles -->
  <?php echo $__env->make('layouts/sections/styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!-- Include Scripts for customizer, helper, analytics, config -->
  <?php echo $__env->make('layouts/sections/scriptsIncludes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body>


  <!-- Layout Content -->
  <?php echo $__env->yieldContent('layoutContent'); ?>
  <!--/ Layout Content -->



  <!-- Include Scripts -->
  <?php echo $__env->make('layouts/sections/scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>

</html>
<?php /**PATH /Users/ztlab113/Desktop/project /Laravel/user-permission-role-module/resources/views/layouts/commonMaster.blade.php ENDPATH**/ ?>