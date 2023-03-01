
<?php $__env->startSection('content'); ?>

<!--start banner section -->
<section class="banner-area position-relative" style="background:url(<?php echo e($appearance->background_image); ?>) no-repeat;">
	<div class="overlay overlay-bg"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="position-relative text-center">
					<h1 class="text-capitalize mb-3 text-white"><?php echo e(translate('Frequently Asked Questions')); ?></h1>
					<a class="text-white" href="<?php echo e(route('site.home')); ?>"><?php echo e(translate('Home')); ?> </a>
					<i class="icofont-long-arrow-right text-white"></i>
					<a class="text-white" href="<?php echo e(route('site.faq')); ?>"><?php echo e(translate('FAQ')); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end banner section -->

<!-- Start faq area -->
<section class="section-gap">
	<div class="container">
		<div class="accordion" id="accordionExample">
			<h3 class="pb-2"><?php echo e(translate('Frequently Asked Questions')); ?></h3>
			<?php $__currentLoopData = $faq; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="accordion-item single-faq">
				<h2 class="accordion-header" id="faq-item-<?php echo e($key); ?>">
					<button class="accordion-button<?php echo e($key==0?'':'  collapsed'); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo e($key); ?>" aria-expanded="<?php echo e($key==0?'true':'false'); ?>" aria-controls="collapse-<?php echo e($key); ?>">
						<?php echo e($key+1); ?>. <?php echo e($value->question); ?>

					</button>
				</h2>
				<div id="collapse-<?php echo e($key); ?>" class="accordion-collapse collapse<?php echo e($key==0?' show':''); ?>" aria-labelledby="faq-item-<?php echo e($key); ?>" data-bs-parent="#accordionExample">
					<div class="accordion-body">
						<div class="row">
							<div class="col-md-12 align-content-start">
								<p><?php echo e($value->answer); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>

	</div>
</section>
<!-- End faq area -->



<?php $__env->stopSection(); ?>
<?php echo $__env->make('site.layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Proyectos\reservacion\resources\views/site/faq.blade.php ENDPATH**/ ?>