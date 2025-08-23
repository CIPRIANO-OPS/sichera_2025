<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'Sistema de gestión administrativo'); ?>">
    <meta name="keywords" content="<?php echo $__env->yieldContent('meta_keywords', 'admin, panel, dashboard, gestión'); ?>">
    <meta name="author" content="<?php echo $__env->yieldContent('meta_author', 'Sistema Administrativo'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> - <?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.ico')); ?>">

    <!-- CSS -->
    <!-- Switchery css -->
    <link href="<?php echo e(asset('assets/plugins/switchery/switchery.min.css')); ?>" rel="stylesheet">
    <!-- Apex css -->
    <link href="<?php echo e(asset('assets/plugins/apexcharts/apexcharts.css')); ?>" rel="stylesheet">
    <!-- Slick css -->
    <link href="<?php echo e(asset('assets/plugins/slick/slick.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/plugins/slick/slick-theme.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('assets/css/icons.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('assets/css/flag-icon.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('assets/css/style.css')); ?>" rel="stylesheet" type="text/css">

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="vertical-layout">
    <!-- Start Infobar Setting Sidebar -->
    <?php echo $__env->make('layouts.partials.settings-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- End Infobar Setting Sidebar -->

    <!-- Start Containerbar -->
    <div id="containerbar">
        <!-- Start Leftbar -->
        <?php echo $__env->make('layouts.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- End Leftbar -->

        <!-- Start Rightbar -->
        <div class="rightbar">
            <!-- Start Topbar Mobile -->
            <?php echo $__env->make('layouts.partials.topbar-mobile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <!-- End Topbar Mobile -->

            <!-- Start Topbar -->
            <?php echo $__env->make('layouts.partials.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <!-- End Topbar -->

            <div class="breadcrumbbar">
                <?php echo $__env->yieldContent('breadcrumb'); ?>
            </div>

            <!-- Start Contentbar -->
            <div class="contentbar">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
            <!-- End Contentbar -->

            <!-- Start Footerbar -->
            <div class="footerbar">
                <footer class="footer">
                    <p class="mb-0">© <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'Laravel')); ?> - Todos los derechos reservados.</p>
                </footer>
            </div>
            <!-- End Footerbar -->
        </div>
        <!-- End Rightbar -->
    </div>
    <!-- End Containerbar -->

    <!-- JavaScript -->
    <script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/modernizr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/detect.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery.slimscroll.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/vertical-menu.js')); ?>"></script>
    <!-- Switchery js -->
    <script src="<?php echo e(asset('assets/plugins/switchery/switchery.min.js')); ?>"></script>
    <!-- Apex js -->
    <script src="<?php echo e(asset('assets/plugins/apexcharts/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/apexcharts/irregular-data-series.js')); ?>"></script>
    <!-- Slick js -->
    <script src="<?php echo e(asset('assets/plugins/slick/slick.min.js')); ?>"></script>
    <!-- Custom Dashboard js -->
    <script src="<?php echo e(asset('assets/js/custom/custom-dashboard.js')); ?>"></script>
    <!-- Core js -->
    <script src="<?php echo e(asset('assets/js/core.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH D:\proyectos_php\sichera_2025\resources\views/layouts/master.blade.php ENDPATH**/ ?>