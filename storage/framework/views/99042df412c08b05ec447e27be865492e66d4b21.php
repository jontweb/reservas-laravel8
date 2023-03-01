
<?php $__env->startSection('content'); ?>

<!--start banner section -->
<section class="banner-area position-relative" style="background:url(<?php echo e($appearance->background_image); ?>) no-repeat;">
    <div class="overlay overlay-bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="position-relative text-center">
                    <h1 class="text-capitalize mb-3 text-white"><?php echo e(translate('Contact Us')); ?></h1>
                    <a class="text-white" href="<?php echo e(route('site.home')); ?>"><?php echo e(translate('Home')); ?> </a>
                    <i class="icofont-long-arrow-right text-white"></i>
                    <a class="text-white" href="<?php echo e(route('site.contact')); ?>"> <?php echo e(translate('Contact Us')); ?></a></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end banner section -->

<!-- Start about-info Area -->
<section class="top-area section-gap">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-9">
                <div class="text-center pb-3">
                    <h2 class="mb-10"><?php echo e(translate('Contact Us')); ?></h2>
                    <p><?php echo e(translate('For any query contact us by email or phone')); ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12 contact-address">
                <div class="single-contact d-flex flex-row">
                    <div class="icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="contact-details">
                        <p class="address">
						<?php echo e($appearance->address); ?>

                        </p>
                    </div>
                </div>
                <div class="single-contact d-flex flex-row">
                    <div class="icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="contact-details">
                        <h5><?php echo e($appearance->contact_phone); ?></h5>
                        <p><?php echo e(translate('Call us in Office time only')); ?></p>
                    </div>
                </div>
                <div class="single-contact d-flex flex-row">
                    <div class="icon">
                        <i class="far fa-envelope-open"></i>
                    </div>
                    <div class="contact-details">
                        <h5><?php echo e($appearance->contact_email); ?></h5>
                        <p><?php echo e(translate('Send your query anytime!')); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 contact-us-email">
                <form  id="form-send-notification">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <input required name="name" id="name" type="text" class="form-control" placeholder="<?php echo e(translate('Your Full Name')); ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <input required name="email" id="email" type="email" class="form-control" placeholder="<?php echo e(translate('Your Email Address')); ?>">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <input required name="subject" id="subject" type="text" class="form-control" placeholder="<?php echo e(translate('Your Query Topic/Subject')); ?>">
                            </div>
                        </div>                       
                    </div>
                    <div class="mb-4">
                        <textarea required name="message" id="message" class="form-control" rows="8" placeholder="<?php echo e(translate('Your Message')); ?>"></textarea>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-booking float-end pe-4 ps-4"><?php echo e(translate('Send Mail')); ?></button>
                    </div>
                </form>
            </div>
        </div>


        <div class="row align-items-center mt-4">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h3 class="ps-2"><?php echo e(translate('Our Map Location')); ?></h3>
				<input type="hidden" id="maplat" value="<?php echo e($gMapConfig['lat']); ?>"/>
			<input type="hidden" id="maplong" value="<?php echo e($gMapConfig['long']); ?>" />
                <div class="map-wrap" style="width: 100%; height: 445px;" id="map"></div>
            </div>
        </div>
    </div>
</section>
<!-- End about-info Area -->
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e($gMapConfig['map_key']); ?>"></script>
<script src="<?php echo e(dsAsset('site/js/custom/client-notification.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('site.layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Proyectos\reservacion\resources\views/site/contact.blade.php ENDPATH**/ ?>