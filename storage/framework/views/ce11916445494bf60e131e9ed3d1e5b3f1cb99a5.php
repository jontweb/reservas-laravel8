
<?php $__env->startSection('content'); ?>
<link href="<?php echo e('css/custom/user_management/login.css'); ?>" rel="stylesheet" />
<script>
    $(document).ready(function() {
        isHeaderScrolled = 0;
    });
</script>
<div class="whole-wrap">
    <div class="container mt-5">
        <div class="section-top-border">
            <div class="h-100">
                <div class="h-100 row justify-content-center">
                    <div class="h-100 d-flex  align-items-center col-md-12 col-lg-6">
                        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-12 p-4">
                            <div class="app-logo"></div>
                            <h4>
                                <div><?php echo e(translate('Welcome to')); ?> <?php echo e($appearance->app_name); ?></div>
                                <span class="fw-light">
                                <?php echo e(translate('It only takes a few seconds to create your account')); ?>

                                </span>
                            </h4>
                            <div>
                                <form method="POST" action="<?php echo e(route('register')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="position-relative mb-3">
                                                <label for="email" class="">
                                                    <span class="text-danger">*</span> <?php echo e(translate('Email')); ?>

                                                </label>
                                                <input id="email" type="email" placeholder="<?php echo e(translate('Email address')); ?>" class="form-control <?php $__errorArgs = ['email'];
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
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="username" class="">
                                                    <span class="text-danger">*</span> <?php echo e(translate('User Name')); ?>

                                                </label>
                                                <input id="username" type="text" maxlength="99" placeholder="<?php echo e(translate('User Name')); ?>" class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="username" value="<?php echo e(old('username')); ?>" required autofocus />
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
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="name" class=""><?php echo e(translate('Name')); ?></label>
                                                <input id="name" type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(translate('Name here')); ?>" name="name" value="<?php echo e(old('name')); ?>" required autocomplete="name" autofocus />
                                                <?php $__errorArgs = ['name'];
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
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="examplePassword" class="">
                                                    <span class="text-danger">*</span> <?php echo e(translate('Password')); ?>

                                                </label>
                                                <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" placeholder="<?php echo e(translate('Password here')); ?>" required autocomplete="new-password" />

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
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="password_confirmation" class="">
                                                    <span class="text-danger">*</span> <?php echo e(translate('Repeat Password')); ?>

                                                </label>
                                                <input placeholder="<?php echo e(translate('Repeat Password here')); ?>" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 position-relative form-check">
                                        <input name="check" id="exampleCheck" type="checkbox" class="form-check-input" />
                                        <label for="exampleCheck" class="form-check-label">
                                            Accept our
                                            <a href="<?php echo e(route('site.terms.and.condition')); ?>"><?php echo e(translate('Terms and Conditions')); ?></a>.
                                        </label>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="w-auto">
                                            <h6 class="mb-0">
                                            <?php echo e(translate('Already have an account')); ?>?
                                                <a href="<?php echo e(route('login')); ?>" class="text-primary"><?php echo e(translate('Sign in')); ?></a>
                                            </h6>
                                        </div>
                                        <div class="col">
                                                <button type="submit" class="btn-wide btn-shadow btn btn-primary float-end"><?php echo e(translate('Create Account')); ?></button>                                          
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('site.layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nacivnsa/public_html/reservacion/resources/views/auth/register.blade.php ENDPATH**/ ?>