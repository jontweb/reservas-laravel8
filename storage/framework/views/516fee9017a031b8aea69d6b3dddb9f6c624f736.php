
<?php $__env->startSection('content'); ?>
<!-- Start Slide-->

<section class="top-section">
	<div class="overlay overlay-bg"></div>
	<div class="top-banner" style="background:url(<?php echo e($appearance->background_image); ?>) no-repeat;"></div>
	<div class="container top-banner-content">
		<div class="row">
			<div class="col-lg-7 col-md-7 col-xs-12 about-service">
				<div class="w100">
					<h1 class="mb-3"> <?php echo e($appearance->motto); ?></h1>
					<p class="pr-5">
						<?php echo e($appearance->about_service); ?>

					</p>
				</div>
			</div>
			<div class="col-lg-5 col-md-5 col-xs-12 banner-right-content">
				<div class="margin-top-110 float-right-banner">
					<a href="<?php echo e(route('site.appoinment.booking')); ?>" class="btn btn-booking btn-lg btn-full-round"><?php echo e(translate('Book An Appointment')); ?> <i class="far fa-clock"></i></a>
				</div>
			</div>
		</div>
	</div>
</section>
<!--End Slide-->


<!-- Top Service Area -->
<section class="top-area section-gap">
	<div class="container">
		<div class="row website-service-summary">
			<div class="col-lg-3">
				<div class="single-item-service-summary mb-3">
					<div class="d-flex justify-content-center">
						<div class="float-start pt-3">
							<div class="icon-background icon-total-service">
								<img src="<?php echo e(dsAsset('site/img/total-service.svg')); ?>" />
							</div>
						</div>
						<div class="float-start single-item-service-summary-content">
							<h2 class="text-total-service-count text-count mt-3"><?php echo e($serviceSummary['totalService']); ?></h2>
							<h4 class="text-service-title"><?php echo e(translate('Total Services')); ?></h4>
						</div>

					</div>
				</div>
			</div>

			<div class="col-lg-3">
				<div class="single-item-service-summary mb-3">
					<div class="d-flex justify-content-center">
						<div class="float-start pt-3">
							<div class="icon-background ico-background-exp-staff">
								<img src="<?php echo e(dsAsset('site/img/expertise-staff.svg')); ?>" />
							</div>
						</div>
						<div class="float-start single-item-service-summary-content">
							<h2 class="text-count text-exp-staff-count mt-3"><?php echo e($serviceSummary['totalEmloyee']); ?></h2>
							<h4 class="text-service-title"><?php echo e(translate('Expertise Staffs')); ?></h4>
						</div>

					</div>
				</div>
			</div>

			<div class="col-lg-3">
				<div class="single-item-service-summary mb-3">
					<div class="d-flex justify-content-center">
						<div class="float-start pt-3">
							<div class="icon-background ico-background-satisfied-client">
								<img src="<?php echo e(dsAsset('site/img/satisfied-client.svg')); ?>" />
							</div>
						</div>
						<div class="float-start single-item-service-summary-content">
							<h2 class="text-count text-satisfied-client-count mt-3"><?php echo e($serviceSummary['SatiffiedClient']); ?></h2>
							<h4 class="text-service-title"><?php echo e(translate('Satisfied Clients')); ?></h4>
						</div>

					</div>
				</div>
			</div>

			<div class="col-lg-3">
				<div class="single-item-service-summary mb-3">
					<div class="d-flex justify-content-center">
						<div class="float-start pt-3">
							<div class="icon-background ico-background-done-service">
								<img src="<?php echo e(dsAsset('site/img/done-service.svg')); ?>" />
							</div>
						</div>
						<div class="float-start single-item-service-summary-content">
							<h2 class="text-count text-done-service-count mt-3"><?php echo e($serviceSummary['DoneService']); ?></h2>
							<h4 class="text-service-title"><?php echo e(translate('Done Services')); ?></h4>
						</div>

					</div>
				</div>
			</div>

		</div>
		<div class="row d-flex justify-content-center">
			<div class="col-lg-9">
				<div class="text-center pb-3">
					<h2 class="mb-10"><?php echo e(translate('Available Our Top and Popular Services')); ?></h2>
					<p><?php echo e(translate('We calculate top services based on our client feedback and number of provided services.')); ?></p>
				</div>
			</div>
		</div>
		<div class="row top-service">
			<?php $__currentLoopData = $topService; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="col-lg-3 col-md-6">
				<div class="single-item">
					<div class="thum">
						<img class="img-fluid" src="<?php echo e($value->image); ?>" alt="">
					</div>
					<a href="<?php echo e(route('site.appoinment.booking')); ?>">
						<h4><?php echo e($value->title); ?></h4>
					</a>
					<p>
						<?php echo e($value->remarks); ?>

					</p>
					<a href="<?php echo e(route('site.service.single.details')); ?>/<?php echo e($value->sch_service_id); ?>" class="read-more"><?php echo e(translate('Learn More')); ?> <i class="icofont-simple-right ml-2"></i></a>
				</div>
			</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>
</section>
<!-- End top service Area -->

<!-- Start New Team Area -->
<section class="top-area section-gap">
	<div class="container">
		<div class="row d-flex justify-content-center">
			<div class="col-lg-9">
				<div class="text-center pb-3">
					<h2 class="mb-10"><?php echo e(translate('Recently Joined New Team Members Us')); ?></h2>
					<p><?php echo e(translate('We are offering, you can take service from our new team member, hope they will provide to you best services.')); ?></p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="new-team owl-carousel owl-theme">
				<?php $__currentLoopData = $newJoiningEmployee; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="single-item">
					<div class="thum">
						<img class="img-fluid" src="<?php echo e($value->image_url); ?>" alt="Employee Image">
					</div>
					<div class="details">
						<h4 class="title"><?php echo e($value->full_name); ?></h4>
						<p>
							<?php echo e($value->specialist); ?>

						</p>
						<a href="<?php echo e(route('site.appoinment.booking')); ?>" class="btn btn-booking-white"><?php echo e(translate('Book Now')); ?></a>
					</div>
				</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			</div>
		</div>
	</div>
</section>
<!-- End New Team Area -->

<!-- Start Client Testimonial Area -->
<section class="top-area section-gap">
	<div class="container">
		<div class="row d-flex justify-content-center">
			<div class="col-lg-9">
				<div class="text-center pb-3">
					<h2 class="mb-10"><?php echo e(translate('Valuable Clients Testimonials')); ?></h2>
					<p><?php echo e(translate('We got testimonials from our valued clients both online and offline and they are very much happy.')); ?></p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="top-client-testimonial owl-carousel owl-theme">
				<?php $__currentLoopData = $clientTestimonial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="client-single-testimonial d-flex flex-row">
					<div class="thum">
						<img class="img-fluid" src="<?php echo e($value->image); ?>" alt="">
					</div>
					<div class="desctiotion">
						<p>
							<?php echo e($value->description); ?>

						</p>
						<h4><?php echo e($value->name); ?></h4>
						<div class="star">
							<?php for($i=1;$i<=5;$i++): ?> <?php if($i<=$value->rating): ?>
								<span class="fa fa-star checked"></span>
								<?php else: ?>
								<span class="fa fa-star"></span>
								<?php endif; ?>
								<?php endfor; ?>
						</div>
					</div>
				</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			</div>
		</div>
	</div>
</section>
<!-- End Client testimonial-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('site.layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nacivnsa/public_html/reservacion/resources/views/site/index.blade.php ENDPATH**/ ?>