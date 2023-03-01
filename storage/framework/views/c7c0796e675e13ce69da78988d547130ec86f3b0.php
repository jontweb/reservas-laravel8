
<?php $__env->startSection('content'); ?>
<div class="page-inner">
    
    <!--Change Profile photos-->
    <div class="row">
        <div class="col-md-12">
            <div class="main-card card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">
                            <i class="fas fa-user-circle"></i> <?php echo e(translate('Change Profile Photo')); ?>

                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" method="post" action="<?php echo e(route('update.user.profile.photo')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-group control-group form-inline">
                            <label class="col-md-3 col-form-label">
                                <?php echo e(translate('Profile Photo')); ?>

                                <span class="required-label">*</span>
                            </label>
                            <div class="col-md-9 controls">
                                <input type="file" name="profilePhoto" id="profilePhoto" class="form-control input-full" required
                                    accept="image/png,image/jpeg,image/jpg" />
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group control-group form-inline">
                            <div class="offset-md-3 col-md-9">
                                <?php if($profilePhoto!=null || $profilePhoto!=""): ?>
                                <img width="150" src="<?php echo e(dsAsset($profilePhoto)); ?>" />
                                <?php else: ?>
                                <img width="150" src="<?php echo e(dsAsset('js/lib/assets/img/avater-man.png')); ?>" />
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="div-password form-group control-group form-inline">
                            <div class="col-md-12">
                                <input type="submit" id="btnChangePhoto" class="btn btn-success btn-sm pull-right" value="<?php echo e(translate('Save Change')); ?>" />
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nacivnsa/public_html/reservacion/resources/views/user_management/change_profile_photo.blade.php ENDPATH**/ ?>