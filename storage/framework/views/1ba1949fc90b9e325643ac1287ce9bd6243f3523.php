
<?php $__env->startSection('content'); ?>

<!--start banner section -->
<section class="banner-area position-relative" style="background:url(<?php echo e($appearance->background_image); ?>) no-repeat;">
	<div class="overlay overlay-bg"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="position-relative text-center">
					<h1 class="text-capitalize mb-3 text-white"><?php echo e(translate('About Us')); ?></h1>
					<a class="text-white" href="<?php echo e(route('site.home')); ?>"><?php echo e(translate('Home')); ?> </a>
					<i class="icofont-long-arrow-right text-white"></i>
					<a class="text-white" href="<?php echo e(route('site.about.us')); ?>"> <?php echo e(translate('About Us')); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end banner section -->

<!-- Start about-info Area -->
<section class="section-gap top-about-us">
	<div class="container">
		<?php $__currentLoopData = $aboutUs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<div class="row single-about-us">
			<div class="col-lg-5 col-md-5">
				<img class="img-fluid" src="<?php echo e($value->image_url); ?>" alt="">
			</div>
			<div class="col-lg-7 col-md-7 about-us-details">
				<p class="about-us-head"><?php echo e(translate('24/7 ABOUT US')); ?></p>
				<h2><?php echo e($value->title); ?></h2>
				<p>
					<?php echo e($value->details); ?>

				</p>
				<div class="row p-2 about-service-quality">
					<div class="col-md-6"><i class="fas fa-check-circle"></i> <?php echo e(translate('24/7 Hours online booking')); ?></div>
					<div class="col-md-6"><i class="fas fa-check-circle"></i> <?php echo e(translate('Expertise staffs')); ?></div>
				</div>
				<div class="row p-2 about-service-quality">
					<div class="col-md-6"><i class="fas fa-check-circle"></i> <?php echo e(translate('On time service delivery')); ?></div>
					<div class="col-md-6"><i class="fas fa-check-circle"></i> <?php echo e(translate('Top quality services')); ?></div>
				</div>
				<div class="col about-us-btns mt-5">
					<a href="<?php echo e(route('site.menu.services')); ?>" class="btn btn-booking-white"><?php echo e(translate('See our services')); ?></a>
					<a href="<?php echo e((route('site.contact'))); ?>" class="btn btn-booking"><?php echo e(translate('Contact with us')); ?></a>
				</div>
			</div>
		</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	</div>
</section>
<!-- End about-info Area -->


<!-- Start Team Area -->
<section class="section-gap expertise-staff-section">
	<div class="container">
		<div class="row d-flex justify-content-center">
			<div class="col-lg-9 header-expertise">
				<div class="text-center pb-3">
					<p><?php echo e(translate('OUR SPECIALIST')); ?></p>
					<h2 class="mb-10"><?php echo e(translate('Meet Our Specialist')); ?></h2>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="expertise-team owl-carousel owl-theme">
				<?php $__currentLoopData = $expertiseEmployee; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="single-item">
					<div class="thum">
						<img class="img-fluid" src="<?php echo e($value->image_url); ?>" alt="Employee Image">
					</div>
					<div class="details">
						<h4 class="title"><?php echo e($value->full_name); ?></h4>
						<p>
							<?php echo e($value->specialist); ?>

						</p>
					</div>
				</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			</div>
		</div>
	</div>
</section>
<!-- End Team Area -->


<!-- Start Client Testimonial Area -->
<section class="section-gap section-client-say">
	<div class="container">
		<div class="row d-flex justify-content-center">
			<div class="col-lg-9 header-client-say">
				<div class="text-center pb-3">
					<p><?php echo e(translate('OUR CLIENTS')); ?></p>
					<h2 class="mb-10"><?php echo e(translate('Valuable Clients Comments')); ?></h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div class="client-say-about-us owl-carousel owl-theme">
					<?php $__currentLoopData = $clientTestimonial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="client-single-say-about-us">
						<div class="w100 d-flex justify-content-center">
							<div class="thum">
								<img src="<?php echo e($value->image); ?>" alt="">
							</div>
						</div>
						<div class="desctiotion">
							<p class="text-center">
								<?php echo e($value->description); ?>

							</p>
							<h4 class="d-flex justify-content-center"><?php echo e($value->name); ?></h4>
							
						</div>
					</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End Client testimonial-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('site.layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Proyectos\reservacion\resources\views/site/about-us.blade.php ENDPATH**/ ?>