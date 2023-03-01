
<?php $__env->startSection('content'); ?>
<div class="page-inner">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="main-card card">
                <form class="form-horizontal" id="inputForm" novalidate="novalidate">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">
                                <i class="fas fa-cog"></i> <?php echo e(translate('Company Settings')); ?>

                            </h4>
                        </div>
                    </div>

                    <div class="form-group control-group form-inline ">
                        <label class="col-md-3">
                            <?php echo e(translate('Name')); ?>

                            <span class="required-label">*</span>
                        </label>
                        <div class="col-md-9 controls">
                            <input type="text" id="name" name="name" placeholder="<?php echo e(translate('Company Name')); ?>" required="required" class="form-control input-full" data-validation-required-message="name is required"/>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group control-group form-inline ">
                        <label class="col-md-3">
                            <?php echo e(translate('Address')); ?>

                            <span class="required-label">*</span>
                        </label>
                        <div class="col-md-9 controls">
                            <input type="text" id="address" name="address" placeholder="<?php echo e(translate('address')); ?>" required="required" class="form-control input-full" data-validation-required-message="Address is required"/>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group control-group form-inline ">
                        <label class="col-md-3">
                            Phone
                            <span class="required-label">*</span>
                        </label>
                        <div class="col-md-9 controls">
                            <input type="text" id="phone" name="phone" placeholder="<?php echo e(translate('phone')); ?>"  class="form-control input-full" />
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group control-group form-inline ">
                        <label class="col-md-3">
                            <?php echo e(translate('Mobile')); ?>

                            <span class="required-label">*</span>
                        </label>
                        <div class="col-md-9 controls">
                            <input type="text" id="mobile" name="mobile" placeholder="<?php echo e(translate('mobile')); ?>"  class="form-control input-full" />
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group control-group form-inline ">
                        <label class="col-md-3">
                            <?php echo e(translate('Email')); ?>

                            <span class="required-label">*</span>
                        </label>
                        <div class="col-md-9 controls">
                            <input type="text" id="email" name="email"  class="form-control input-full" />
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group control-group form-inline ">
                        <label class="col-md-3">
                            <?php echo e(translate('Web Address')); ?>

                            <span class="required-label">*</span>
                        </label>
                        <div class="col-md-9 controls">
                            <input type="text" id="web_address" name="web_address"   class="form-control input-full"/>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><?php echo e(translate('Save Change')); ?></button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo e(dsAsset('js/custom/settings/company.js')); ?>"></script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nacivnsa/public_html/reservacion/resources/views/settings/company.blade.php ENDPATH**/ ?>