<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="_token" content="<?php echo e(csrf_token()); ?>" url="<?php echo e(url('/')); ?>" />
    <title><?php echo e($appearance->app_name); ?> | Admin</title>
    <link rel="shortcut icon" href="<?php echo e(url($appearance->icon)); ?>">

    <!-- Fonts and icons -->
    <script src="<?php echo e(dsAsset('js/lib/assets/js/plugin/webfont/webfont.min.js')); ?>"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands", "simple-line-icons"
                ],
                urls: ["<?php echo e(url('/')); ?>/js/lib/assets/css/fonts.min.css"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link href="<?php echo e(dsAsset('js/lib/assets/css/bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(dsAsset('js/lib/DataTables/datatables.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(dsAsset('js/lib/assets/css/atlantis.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(dsAsset('js/lib/assets/css/checkbox-slider.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(dsAsset('js/lib/xd-dpicker/jquery.datetimepicker.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(dsAsset('css/site.css?v=1')); ?>" rel="stylesheet" />
    <!-- tel input css -->
    <link href="<?php echo e(dsAsset('js/lib/tel-input/css/intlTelInput.css')); ?>" rel="stylesheet" />

    <!-- bootstrap select -->
    <link href="<?php echo e(dsAsset('js/lib/bootstrap-select-1.13.14/css/bootstrap-select.min.css')); ?>" rel="stylesheet" />

    <!--Jquery JS-->
    <script src="<?php echo e(dsAsset('js/lib/assets/js/core/jquery-3.6.0.min.js')); ?>"></script>
    <link href="https://fonts.googleapis.com/css?family=Exo:500,600,700|Roboto&display=swap" rel="stylesheet" />
</head>

<body>
    <div id="process_notifi" class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="blue">

                <a href="<?php echo e(route('home')); ?>" class="logo">
                    <img height="30" width="145" src="<?php echo e(url($appearance->logo)); ?>" alt="navbar brand" class="navbar-brand br-5 bg-white" />
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more">
                    <i class="icon-options-vertical"></i>
                </button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

                <div class="container-fluid">
                    <div class="collapse" id="search-nav">
                        <form class="navbar-left navbar-form nav-search mr-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pr-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="<?php echo e(translate('Search')); ?> ..." class="form-control" />
                            </div>
                        </form>
                    </div>
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">

                        <form id="language-change-form" class="float-start" action="<?php echo e(route('change.language')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <select id="cmbLang" class="me-3" name="lang_id">
                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php echo e((Session::get('lang')!=null) && (Session::get('lang')['id'])==$lang->id?"selected":""); ?> value=<?php echo e($lang->id); ?>><?php echo e($lang->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </form>
                        <li class="nav-item toggle-nav-search hidden-caret">
                            <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown hidden-caret">
                            <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-envelope"></i>
                            </a>
                            <ul class="d-none dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
                                <li>
                                    <div class="dropdown-title d-flex justify-content-between align-items-center">
                                        <?php echo e(translate('Messages')); ?>

                                        <a href="#" class="small"><?php echo e(translate('Mark all as read')); ?></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="message-notif-scroll scrollbar-outer">
                                        <div class="notif-center">
                                            <a href="#">
                                                <div class="notif-img">
                                                    <img src="<?php echo e(dsAsset('js/lib/assets/img/avater-man.png')); ?>" alt="Img Profile" />
                                                </div>
                                                <div class="notif-content">
                                                    <span class="subject"></span>
                                                    <span class="block">
                                                    </span>
                                                    <span class="time"></span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a class="see-all" href="#">
                                        <?php echo e(translate('See all messages')); ?>

                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown hidden-caret">
                            <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell"></i>
                                <span class="notification">0</span>
                            </a>
                            <ul class="d-none dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                                <li>
                                    <div class="dropdown-title"><?php echo e(translate('You have 4 new notification')); ?></div>
                                </li>
                                <li>
                                    <div class="notif-center">
                                        <a href="#">
                                            <div class="notif-icon notif-primary">
                                                <i class="fa fa-user-plus"></i>
                                            </div>
                                            <div class="notif-content">
                                                <span class="block">
                                                    <?php echo e(translate('Notification 1')); ?>

                                                </span>
                                                <span class="time"><?php echo e(translate('5 minutes ago')); ?></span>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <a class="see-all" href="#">
                                        <?php echo e(translate('See all notifications')); ?>

                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown hidden-caret">
                            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                                <i class="fas fa-layer-group"></i>
                            </a>
                            <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                                <div class="quick-actions-header">
                                    <span class="title mb-1"><?php echo e(translate('Quick Actions')); ?></span>
                                    <span class="subtitle op-8"><?php echo e(translate('Shortcuts')); ?></span>
                                </div>
                                <div class="quick-actions-scroll scrollbar-outer">
                                    <div class="quick-actions-items">
                                        <div class="row m-0">
                                            <a class="col-6 col-md-4 p-0" href="<?php echo e(route('booking.calendar')); ?>">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-calendar"></i>
                                                    <span class="text"><?php echo e(translate('Booking Calendar')); ?></span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="<?php echo e(route('service.booking.info')); ?>">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-list"></i>
                                                    <span class="text"><?php echo e(translate('Booking Information')); ?></span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="<?php echo e(route('customer')); ?>">
                                                <div class="quick-actions-item">
                                                    <i class="flaticon-plus"></i>
                                                    <span class="text"><?php echo e(translate('Create New Customer')); ?></span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                                <div class="avatar-sm">
                                    <?php if($userInfo['photo']==null || $userInfo['photo']==''): ?>
                                    <img src="<?php echo e(dsAsset('js/lib/assets/img/avater-man.png')); ?>" alt="image profile" class="avatar-img rounded-circle" />
                                    <?php else: ?>
                                    <img src="<?php echo e(dsAsset($userInfo['photo'])); ?>" alt="image profile" class="avatar-img rounded-circle" />
                                    <?php endif; ?>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg">
                                                <?php if($userInfo['photo']==null || $userInfo['photo']==''): ?>
                                                <img src="<?php echo e(dsAsset('js/lib/assets/img/avater-man.png')); ?>" alt="image profile" class="avatar-img rounded" />
                                                <?php else: ?>
                                                <img src="<?php echo e(dsAsset($userInfo['photo'])); ?>" alt="image profile" class="avatar-img rounded" />
                                                <?php endif; ?>
                                            </div>
                                            <div class="u-text">
                                                <h4><?php echo e($userInfo['username']); ?></h4>
                                                <p class="text-muted"><?php echo e($userInfo['email']); ?></p>
                                                <a href="<?php echo e(route('change.user.profile.photo')); ?>" class="btn btn-xs btn-secondary btn-sm"><?php echo e(translate('Change Photo')); ?></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>

                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?php echo e(route('change.user.password')); ?>"><?php echo e(translate('Change Password')); ?></a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" id="app-logout" href="<?php echo e(route('logout')); ?>"><?php echo e(translate('Logout')); ?></a>
                                    </li>
                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2">

            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user">
                        <div class="avatar-sm float-left mr-2">
                            <?php if($userInfo['photo']==null || $userInfo['photo']==''): ?>
                            <img src="<?php echo e(dsAsset('js/lib/assets/img/avater-man.png')); ?>" alt="image profile" class="avatar-img rounded-circle" />
                            <?php else: ?>
                            <img src="<?php echo e(dsAsset($userInfo['photo'])); ?>" alt="image profile" class="avatar-img rounded-circle" />
                            <?php endif; ?>

                        </div>
                        <div class="info">
                            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                                <span>
                                    <?php echo e($userInfo['name']); ?>

                                    <span class="user-level"><?php echo e($userInfo['email']); ?></span>
                                </span>
                            </a>
                            <div class="clearfix"></div>

                        </div>
                    </div>
                    <ul class="nav nav-primary">

                        <?php $__currentLoopData = $menuList->where('level', 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item">
                            <a data-toggle="collapse" href="#base<?php echo e($item->id); ?>" class="collapsed" aria-expanded="false">
                                <i class="<?php echo e($item->icon); ?>"></i>
                                <p><?php echo e(translate($item->display_name)); ?></p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="base<?php echo e($item->id); ?>">
                                <ul class="nav nav-collapse">
                                    <?php $__currentLoopData = $menuList->where('level', 2)->where('resource_id', $item->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(route($item1->method)); ?>">
                                            <span class="sub-item"> <?php echo e(translate($item1->display_name)); ?></span>
                                        </a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>
                </div>
            </div>
        </div>
        <div class="main-panel">
            <div class="content">
                <?php echo $__env->yieldContent('content'); ?>
            </div>

        </div>

    </div>


    <!--   Core JS Files   -->
    <script src="<?php echo e(dsAsset('js/lib/assets/js/core/popper.min.js')); ?>"></script>
    <script src="<?php echo e(dsAsset('js/lib/assets/js/core/bootstrap.min.js')); ?>"></script>

    <!-- jQuery UI -->
    <script src="<?php echo e(dsAsset('js/lib/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(dsAsset('js/lib/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')); ?>"></script>

    <!-- jQuery Scrollbar -->
    <script src="<?php echo e(dsAsset('js/lib/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')); ?>"></script>

    <!-- Datatables -->
    <script src="<?php echo e(dsAsset('js/lib/DataTables/datatables.min.js')); ?>"></script>

    <!--theam JS -->
    <script src="<?php echo e(dsAsset('js/lib/assets/js/atlantis.js')); ?>"></script>

    <!--notify JS-->
    <script src="<?php echo e(dsAsset('js/lib/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')); ?>"></script>

    <!--JQ bootstrap validation-->
    <script src="<?php echo e(dsAsset('js/lib/assets/js/plugin/jquery-bootstrap-validation/jqBootstrapValidation.js')); ?>"></script>

    <!--site js-->
    <script src="<?php echo e(dsAsset('js/site.js')); ?>"></script>
    <script src="<?php echo e(dsAsset('js/lib/js-manager.js')); ?>"></script>
    <script src="<?php echo e(dsAsset('js/lib/js-message.js')); ?>"></script>

    <!-- bootstrap select -->
    <script src="<?php echo e(dsAsset('js/lib/bootstrap-select-1.13.14/js/bootstrap-select.min.js')); ?>"></script>

    <!-- datetime pciker js -->
    <script src="<?php echo e(dsAsset('js/lib/xd-dpicker/build/jquery.datetimepicker.full.min.js')); ?>"></script>
    <script src="<?php echo e(dsAsset('js/lib/moment.js')); ?>"></script>

    <!-- tel input -->
    <script src="<?php echo e(dsAsset('js/lib/tel-input/js/intlTelInput.js')); ?>"></script>
</body>

</html><?php /**PATH /home/nacivnsa/public_html/reservacion/resources/views/layouts/app.blade.php ENDPATH**/ ?>