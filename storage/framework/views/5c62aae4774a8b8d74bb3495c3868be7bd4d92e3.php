	
	<?php $__env->startSection('content'); ?>
	<!--start banner section -->
	<section class="banner-area position-relative" style="background:url(<?php echo e($appearance->background_image); ?>) no-repeat;">
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="position-relative text-center">
						<h1 class="text-capitalize mb-3 text-white"><?php echo e(translate('Our Teams')); ?></h1>
						<a class="text-white" href="<?php echo e(route('site.home')); ?>"><?php echo e(translate('Home')); ?> </a>
						<i class="icofont-long-arrow-right text-white"></i>
						<a class="text-white" href="<?php echo e(route('site.menu.team')); ?>"> <?php echo e(translate('Our Team')); ?></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end banner section -->

	<!-- Start Team Area -->
	<section class="top-area section-gap">
		<div class="container">
			<div class="row d-flex justify-content-center">
				<div class="col-lg-9">
					<div class="text-center pb-3">
						<h2 class="mb-10"><?php echo e(translate('Our Skilled Team Members')); ?></h2>
						<p><?php echo e(translate('We always choose best team for your better services and better quality.')); ?></p>
					</div>
				</div>
			</div>
			<div class="row">
				<?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="col-lg-3">
					<div class="single-our-team">
						<div class="thum">
							<img src="<?php echo e($value->image_url); ?>" alt="">
						</div>
						<div class="details">
							<h4 class="d-flex justify-content-between">
								<span><?php echo e($value->full_name); ?></span>
							</h4>
							<p>
								<?php echo e($value->specialist); ?>

							</p>
							<a href="<?php echo e(route('site.single.team.details')); ?>/<?php echo e($value->id); ?>" class=""><?php echo e(translate('Learn More')); ?> <i class="icofont-simple-right ml-2"></i></a>

						</div>
					</div>
				</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
		</div>
	</section>
	<!-- End Team Area -->
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('site.layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Proyectos\reservacion\resources\views/site/team.blade.php ENDPATH**/ ?>