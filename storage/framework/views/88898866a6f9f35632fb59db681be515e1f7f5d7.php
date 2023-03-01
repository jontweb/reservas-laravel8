
<?php $__env->startSection('content'); ?>
<div class="page-inner">



    <!--Change password-->
    <div class="row">
        <div class="col-md-12">
            <div class="main-card card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">
                            <i class="fas fa-key"></i> <?php echo e(translate('Change Password')); ?>

                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" id="passwordChangeForm" novalidate="novalidate">
                        <div class="div-password form-group control-group form-inline">
                            <label class="col-md-3 col-form-label">
                                <?php echo e(translate('Current Password')); ?>

                                <span class="required-label">*</span>
                            </label>
                            <div class="col-md-9 controls">
                                <input type="password" name="currentPassword" id="currentPassword" placeholder="<?php echo e(translate('Current Password')); ?>"
                                    class="form-control input-full" required minlength="8"
                                    data-validation-required-message="Current password is required" />
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="div-password form-group control-group form-inline">
                            <label class="col-md-3 col-form-label">
                                <?php echo e(translate('New Password')); ?>

                                <span class="required-label">*</span>
                            </label>
                            <div class="col-md-9 controls">
                                <input type="password" name="newPassword" id="newPassword" placeholder="<?php echo e(translate('New Password')); ?>"
                                    class="form-control input-full" required minlength="8"
                                    data-validation-required-message="New password is required" />
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="div-password form-group control-group form-inline">
                            <label class="col-md-3 col-form-label">
                                <?php echo e(translate('Confirm New Password')); ?>

                                <span class="required-label">*</span>
                            </label>
                            <div class="col-md-9 controls">
                                <input type="password" name="newConfirmPassword" id="newConfirmPassword"
                                    placeholder="<?php echo e(translate('Confirm new password')); ?>" class="form-control input-full" required minlength="8"
                                    data-validation-required-message="Confirm new password is required"
                                    data-validation-match-match="newPassword" />
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="div-password form-group control-group form-inline">
                            <div class="col-md-12">
                                <button type="submit" id="btnChangePassword" class="btn btn-success btn-sm pull-right"><?php echo e(translate('Change Password')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo e(dsAsset('js/custom/user_management/change-password.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nacivnsa/public_html/reservacion/resources/views/user_management/change_password.blade.php ENDPATH**/ ?>