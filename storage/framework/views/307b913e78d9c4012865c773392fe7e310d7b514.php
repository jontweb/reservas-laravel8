	
	<?php $__env->startSection('content'); ?>
	<!--start banner section -->
	<section class="banner-area position-relative" style="background:url(<?php echo e($appearance->background_image); ?>) no-repeat;">
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="position-relative text-center">
						<h1 class="text-capitalize mb-3 text-white"><?php echo e(translate('Our Services')); ?></h1>
						<a class="text-white" href="<?php echo e(route('site.home')); ?>"><?php echo e(translate('Home')); ?> </a>
						<i class="icofont-long-arrow-right text-white"></i>
						<a class="text-white" href="<?php echo e(route('site.menu.services')); ?>"> <?php echo e(translate('Service')); ?></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end banner section -->

	<!-- Start Service Area -->
	<section class="top-area section-gap">
		<div class="container">
			<div class="row d-flex justify-content-center">
				<div class="col-lg-9">
					<div class="text-center pb-3">
						<h2 class="mb-10"><?php echo e(translate('Available Our Services')); ?></h2>
						<p><?php echo e(translate('All available services of our all branches you can choose any service based on your need.')); ?></p>
					</div>
				</div>
			</div>
			<div class="row">
				<?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="col-lg-4">
					<div class="single-service">
						<div class="thum">
							<img src="<?php echo e($value->image); ?>" alt="">
						</div>
						<div class="details">
							<h4><?php echo e($value->title); ?></h4>
							<p><?php echo e($value->remarks); ?></p>
							<ul class="single-service-info">
								<li class="d-flex justify-content-between align-items-center">
									<span><?php echo e(translate('Total Service Time')); ?></span>
									<span><?php echo e($value->time_slot_in_time); ?> minute</span>
								</li>
								<li class="d-flex justify-content-between align-items-center">
									<span><?php echo e(translate('Service Limit')); ?> <?php echo e($value->appoinntment_limit_type); ?></span>
									<span><?php echo e($value->appoinntment_limit); ?></span>
								</li>
								<li class="d-flex justify-content-between align-items-center">
									<span><?php echo e(translate('Price per service')); ?> </span>
									<span><?php echo e($value->price); ?></span>
								</li>
								<li class="d-flex justify-content-between align-items-center">
									<span><?php echo e($value->visibility); ?></span>
									<a href="<?php echo e(route('site.appoinment.booking')); ?>" class="btn btn-booking-white"><?php echo e(translate('Book Now')); ?></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
		</div>
	</section>
	<!-- End service Area -->
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('site.layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Proyectos\reservacion\resources\views/site/services.blade.php ENDPATH**/ ?>