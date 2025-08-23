<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'Sistema de gestión - Autenticación'); ?>">
    <meta name="keywords" content="admin, panel, gestión, autenticación">
    <meta name="author" content="Sistema de Gestión">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <title><?php echo $__env->yieldContent('title', 'Autenticación'); ?> - <?php echo e(config('app.name', 'Sistema de Gestión')); ?></title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.ico')); ?>">
    
    <!-- CSS -->
    <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('assets/css/icons.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('assets/css/style.css')); ?>" rel="stylesheet" type="text/css">
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="vertical-layout">
    <!-- Start Containerbar -->
    <div id="containerbar" class="containerbar authenticate-bg">
        <!-- Start Container -->
        <div class="container">
            <div class="auth-box login-box">
                <!-- Start row -->
                <div class="row no-gutters align-items-center justify-content-center">
                    <!-- Start col -->
                    <div class="col-md-6 col-lg-5">
                        <!-- Start Auth Box -->
                        <div class="auth-box-right">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Logo -->
                                    <div class="form-head">
                                        <a href="<?php echo e(route('dashboard')); ?>" class="logo">
                                            <img src="<?php echo e(asset('assets/images/logo.svg')); ?>" class="img-fluid" alt="logo">
                                        </a>
                                    </div>
                                    
                                    <!-- Session Status -->
                                    <?php if(session('status')): ?>
                                        <div class="alert alert-success mb-3" role="alert">
                                            <?php echo e(session('status')); ?>

                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Validation Errors -->
                                    <?php if($errors->any()): ?>
                                        <div class="alert alert-danger mb-3">
                                            <ul class="mb-0">
                                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><?php echo e($error); ?></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Main Content -->
                                    <?php echo e($slot); ?>

                                    
                                </div>
                            </div>
                        </div>
                        <!-- End Auth Box -->
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
        </div>
        <!-- End Container -->
    </div>
    <!-- End Containerbar -->
    
    <!-- JavaScript -->
    <script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/modernizr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/detect.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery.slimscroll.js')); ?>"></script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\proyectos_php\sichera_2025\resources\views/layouts/guest.blade.php ENDPATH**/ ?>