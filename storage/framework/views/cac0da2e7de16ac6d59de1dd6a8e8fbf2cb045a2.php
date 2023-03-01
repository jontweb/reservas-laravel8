
<?php $__env->startSection('content'); ?>
<div class="page-inner">

    <div class="row">
        <div class="col-md-12">
            <div class="main-card card">
                <form id="inputForm" novalidate="novalidate">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">
                                <?php echo e(translate('Translate')); ?> English => <b><?php echo e($translateLang); ?></b>
                            </h4>
                        </div>
                    </div>
                    <div class="card-body pt-1">
                        <table id="tableElement" class="table table-bordered w100"></table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnSave" class="btn btn-success btn-shadow"><?php echo e(translate('Save Change')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo e(dsAsset('js/custom/settings/translate.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nacivnsa/public_html/reservacion/resources/views/settings/translate-language.blade.php ENDPATH**/ ?>