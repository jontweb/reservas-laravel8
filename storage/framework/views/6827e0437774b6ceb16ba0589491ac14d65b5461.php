<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Language" content="en" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo e($appearance->app_name); ?></title>
    <link rel="shortcut icon" href="<?php echo e(url($appearance->icon)); ?>">
    <meta name="description" content="<?php echo e($appearance->meta_description); ?>">
    <!-- Meta Keyword -->
    <meta name="keywords" content="<?php echo e($appearance->meta_keywords); ?>">

    <link href="<?php echo e(dsAsset('js/lib/assets/css/bootstrap.min.css')); ?>" rel="stylesheet" />
    <script src="<?php echo e(dsAsset('js/lib/assets/js/core/jquery.3.2.1.min.js')); ?>"></script>
    <link href="<?php echo e(dsAsset('css/site.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(dsAsset('css/custom/user_management/login.css')); ?>" rel="stylesheet" />

</head>

<body style="background-image: url(<?php echo e(dsAsset($appearance->login_background_image)); ?>);">
    <div class="container-fluid">
        <div class="h-100">
            <div class="h-100 row justify-content-center">
                <div class="h-100 d-flex  align-items-center col-md-12 col-lg-6">
                    <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-6 p-4">
                        <h4 class="mb-15rem">
                            <div>Forgot your Password?</div>
                            <span class="fs-19">Use the form below to recover it.</span>
                        </h4>
                        <div>
                            <?php if(session('status')): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo e(session('status')); ?>

                            </div>
                            <?php endif; ?>
                            <form method="POST" action="<?php echo e(route('password.email')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="email" class=""><?php echo e(translate('Email')); ?></label>
                                            <input placeholder="Email here..." id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus />

                                            <?php $__errorArgs = ['email'];
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
                                <div class="mt-4 d-flex align-items-center">
                                    <div class="ml-auto">
                                        <button type="submit" class="btn btn-shadow btn-primary"><?php echo e(translate('Send Password Reset Link')); ?></button>
                                    </div>
                                </div>
                                <div class="mt-4 align-items-center text-center">
                                    <a href="<?php echo e(route('login')); ?>" class="text-primary"><?php echo e(translate('Sign in existing account')); ?></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html><?php /**PATH C:\xampp\htdocs\Proyectos\reservacion\resources\views/auth/passwords/email.blade.php ENDPATH**/ ?>