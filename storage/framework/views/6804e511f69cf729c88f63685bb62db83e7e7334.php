<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <title><?php echo e($appearance->app_name); ?> Login</title>
    <link rel="shortcut icon" href="<?php echo e(url($appearance->icon)); ?>">

    <meta name="description" content="<?php echo e($appearance->meta_description); ?>">
    <!-- Meta Keyword -->
    <meta name="keywords" content="<?php echo e($appearance->meta_keywords); ?>">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <link href="<?php echo e(dsAsset('js/lib/assets/css/bootstrap.min.css')); ?>" rel="stylesheet" />
    <script src="<?php echo e(dsAsset('js/lib/assets/js/core/jquery-3.6.0.min.js')); ?>"></script>
    <link href="<?php echo e(dsAsset('css/custom/user_management/login.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(dsAsset('css/site.css')); ?>" rel="stylesheet" />
</head>
<body class="login-bg" style="background-image: url(<?php echo e(dsAsset($appearance->login_background_image)); ?>);">

    <div class="container-fluid">
        <div class="h-100">
            <div class="h-100 row justify-content-center">
                <div class="h-100 d-flex  align-items-center col-md-12 col-lg-6">
                    <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-6 p-4">
                        <h4 class="mb-0">
                            <span class="d-block"><?php echo e(translate('Welcome back')); ?>,</span>
                            <span class="fs-19"><?php echo e(translate('Please sign in to your account.')); ?></span>
                        </h4>
                        <h6 class="mt-3"><?php echo e(translate('No account')); ?>? <a href="<?php echo e(route('register')); ?>" class="text-primary"><?php echo e(translate('Sign up')); ?>

                        <?php echo e(translate('now')); ?></a></h6>
                        <div class="divider row"></div>
                        <div>
                            <form method="POST" action="<?php echo e(route('login')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="username" class=""><?php echo e(translate('Email')); ?></label>
                                            <input id="username" type="text" class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="username" value="<?php echo e(old('username')); ?>" required autocomplete="username" autofocus placeholder="<?php echo e(translate('Eamil Or Username')); ?>" />

                                            <?php $__errorArgs = ['username'];
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
                                    </div>
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="password" class=""><?php echo e(translate('Password')); ?></label>
                                            <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="current-password" placeholder="Password here">

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
                                    </div>
                                </div>
                                <div class="position-relative form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="remember"><?php echo e(translate('Remember Me')); ?>

                                    </label>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="ml-auto">
                                        <button type="submit" class="btn btn-shadow btn-primary"><?php echo e(translate('Click to Login')); ?></button>
                                    </div>

                                </div>

                                <!-- <div class="align-items-center text-center mt-5">
                                    <button id="btnAdmin" class="btn btn-sm btn-primary">Admin User</button>
                                    <button id="btnStaff" class="btn btn-sm btn-info">Staff User</button>
                                    <button id="btnWebUser" class="btn btn-sm btn-success">Web User</button>
                                    <script>
                                        $("#btnAdmin").on('click',function(){
                                            $("#username").val('admin');
                                            $("#password").val('12345678');
                                        });
                                        $("#btnStaff").on('click',function(){
                                            $("#username").val('staff');
                                            $("#password").val('12345678');
                                        });
                                        $("#btnWebUser").on('click',function(){
                                            $("#username").val('webuser');
                                            $("#password").val('12345678');
                                        });
                                    </script>
                                </div> -->

                                <div class="align-items-center text-center mt-5">
                                    <?php if(Route::has('password.request')): ?>
                                    <a class="btn-lg btn btn-link fs-16" href="<?php echo e(route('password.request')); ?>">
                                        <?php echo e(translate('Forgot Your Password?')); ?>

                                    </a>
                                    <?php endif; ?>
                                </div>

                                <div class="align-items-center text-center">
                                    <a class="btn-lg btn btn-link fs-16" href="<?php echo e(route('site.home')); ?>">
                                        <?php echo e(translate('Go to Website')); ?>

                                    </a>
                                </div>

                              

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html><?php /**PATH /home/nacivnsa/public_html/reservacion/resources/views/auth/login.blade.php ENDPATH**/ ?>