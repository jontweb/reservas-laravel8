
<?php $__env->startSection('content'); ?>

<!--start banner section -->
<section class="banner-area position-relative" style="background:url(<?php echo e($appearance->background_image); ?>) no-repeat;">
	<div class="overlay overlay-bg"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="position-relative text-center">
					<h1 class="text-capitalize mb-3 text-white"><?php echo e(translate('Photo Gallery')); ?></h1>
					<a class="text-white" href="<?php echo e(route('site.home')); ?>"><?php echo e(translate('Home')); ?> </a>
					<i class="icofont-long-arrow-right text-white"></i>
					<a class="text-white" href="<?php echo e(route('site.photo.gallery')); ?>"><?php echo e(translate('Photo Gallery')); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end banner section -->

<!-- Start photo gallery area -->
<section class="section-gap">
	<div class="container">
		<h3><?php echo e(translate('Our Photo Gallery')); ?></h3>
		<div class="row photo-gallery">
			<?php $__currentLoopData = $photoGallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="col-md-4">
				<a href="<?php echo e($value->image_url); ?>" class="img-gal">
					<div class="single-photo-gallery" style="background: url(<?php echo e($value->image_url); ?>);"></div>
				</a>
			</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>
</section>
<!-- End photo gallery area -->


<?php $__env->stopSection(); ?>
<?php echo $__env->make('site.layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Proyectos\reservacion\resources\views/site/photo-gallery.blade.php ENDPATH**/ ?>