<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<meta name="_token" content="<?php echo e(csrf_token()); ?>" url="<?php echo e(url('/')); ?>" />
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="<?php echo e(url($appearance->icon)); ?>">
	<!-- Meta Description -->
	<meta name="description" content="<?php echo e($appearance->meta_description); ?>">
	<!-- Meta Keyword -->
	<meta name="keywords" content="<?php echo e($appearance->meta_keywords); ?>">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title><?php echo e($appearance->app_name); ?></title>
	<link href="https://fonts.googleapis.com/css?family=Exo:500,600,700|Roboto&display=swap" rel="stylesheet" />
	<script src="<?php echo e(dsAsset('site/assets/js/jquery.min.js')); ?>"></script>

	<link rel="stylesheet" href="<?php echo e(dsAsset('site/assets/css/bootstrap.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(dsAsset('site/assets/js/lib/icofont/icofont.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(dsAsset('site/assets/js/lib/fontawesome/css/all.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(dsAsset('site/assets/js/lib/owl-carousel/assets/owl.theme.default.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(dsAsset('site/assets/js/lib/owl-carousel/assets/owl.carousel.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(dsAsset('site/assets/js/lib/magnific-popup/magnific-popup.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(dsAsset('site/assets/css/app.css')); ?>">
	<link href="<?php echo e(dsAsset('js/lib/xd-dpicker/jquery.datetimepicker.css')); ?>" rel="stylesheet" />
	<link href="<?php echo e(dsAsset('js/lib/tel-input/css/intlTelInput.css')); ?>" rel="stylesheet" />

	<!-- datetime pciker js -->
	<script src="<?php echo e(dsAsset('js/lib/tel-input/js/intlTelInput.js')); ?>"></script>
	<script src="<?php echo e(dsAsset('js/lib/moment.js')); ?>"></script>
	<script src="<?php echo e(dsAsset('js/lib/jquery.steps/jquery.steps.min.js')); ?>"></script>
	<link href="<?php echo e(dsAsset('js/lib/jquery.steps/jquery.steps.css')); ?>" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo e(dsAsset('site/css/website.css')); ?>">
	<script src="<?php echo e(dsAsset('site/js/custom/website.js')); ?>"></script>
	<style>
		:root {
		--theamColor: <?php echo e($appearance["theam_color"]); ?>;
		--theamHoverColor: <?php echo e($appearance["theam_hover_color"]); ?>;
		--theamActiveColor: <?php echo e($appearance["theam_active_color"]); ?>;
		--theamMenuColor: <?php echo e($appearance["menu_color"]); ?>;
		--theamMenuColor2: <?php echo e($appearance["menu_color2"]); ?>;
	}
	</style>
	<?php echo $__env->yieldPushContent('css'); ?>
</head>

<body id="process_notifi">
	<header class="header">
		<div class="header-top">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6 header-top-left">
						<a href="<?php echo e($appearance->faccebook_link); ?>"><i class="fab fa-facebook-f fs-13"></i></a>
						<a href="<?php echo e($appearance->twitter_link); ?>"><i class="fab fa-twitter fs-13"></i></a>
						<a href="<?php echo e($appearance->youtube_link); ?>"><i class="fab fa-youtube fs-13"></i></a>
						<a href="<?php echo e($appearance->instagram_link); ?>"><i class="fab fa-instagram fs-13"></i></a>
					</div>
					<div class="col-md-6">
						<div class="text-lg-end mt-2 mt-lg-0 float-end header-top-right">
							<form id="language-change-form" class="float-start" action="<?php echo e(route('change.language')); ?>" method="POST">
								<?php echo csrf_field(); ?>
								<select id="cmbLang" class="me-3" name="lang_id">
									<?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option <?php echo e((Session::get('lang')!=null) && (Session::get('lang')['id'])==$lang->id?"selected":""); ?> value=<?php echo e($lang->id); ?>><?php echo e($lang->name); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</form>

							<a class="me-3 color-white fs-12" href="<?php echo e(route('site.appoinment.booking')); ?>"><i class="far fa-clock"></i> <?php echo e(translate('Book Now')); ?></a>
							<?php if(auth()->check() && auth()->user()->user_type==2): ?>
							<a class="me-3 color-white" href="<?php echo e(route('client.dashboard')); ?>"><?php echo e(translate('My Panel')); ?></a>
							<?php else: ?>
							<a class="me-3 color-white fs-12" href="<?php echo e(route('register')); ?>"><i class="fas fa-user-plus"></i> <?php echo e(translate('Sign Up')); ?></a>
							<a class="me-3 color-white fs-12" href="<?php echo e(route('login')); ?>"><i class="fas fa-sign-in-alt"></i> <?php echo e(translate('Sign In')); ?></a>
							<?php endif; ?>

							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<nav class="navbar navbar-expand-lg navbar-light navigation" id="navbar">
			<div class="container">
				<a class="navbar-brand" href="<?php echo e(route('site.home')); ?>">
					<img src="<?php echo e(dsAsset($appearance->logo)); ?>" />
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-main" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbar-main">
					<ul class="navbar-nav ms-auto">
						<?php $__currentLoopData = $menuList->where('site_menu_id', 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mTop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="<?php echo e(route($mTop->route)); ?>" id="navbarDropdownMenuLink" role="button" data-bs-toggle="<?php if($menuList->where('site_menu_id', $mTop->id)->count()>0): ?> dropdown <?php endif; ?>" aria-expanded="false"><?php echo e(translate($mTop->name)); ?>

								<?php if($menuList->where('site_menu_id', $mTop->id)->count()>0): ?>
								<i class="icofont-thin-down"></i>
								<?php endif; ?>
							</a>
							<?php if($menuList->where('site_menu_id', $mTop->id)->count()>0): ?>

							<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
								<?php $__currentLoopData = $menuList->where('site_menu_id', $mTop->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li><a class="dropdown-item" href="<?php echo e(route($c1->route)); ?>"><?php echo e(translate($c1->name)); ?></a>
								</li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
							<?php endif; ?>
						</li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<!--end header -->

	<?php echo $__env->yieldContent('content'); ?>;

	<!-- Start footer-->
	<footer class="footer section-gap">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-4 col-md-6 col-sm-6">
					<div class="footer-widget">
						<h3><?php echo e(translate('About Service')); ?></h3>
						<p>
							<?php echo e($appearance->about_service); ?>

						</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="footer-widget">
						<h3><?php echo e(translate('Website Navigation Links')); ?></h3>
						<div class="row">
							<div class="col">
								<ul>
									<?php $__currentLoopData = $menuList->where('site_menu_id', 0)->skip(0)->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mTop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li><a href="<?php echo e(route($mTop->route)); ?>"><?php echo e($mTop->name); ?></a></li>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</ul>
							</div>
							<div class="col">
								<ul>
									<?php $__currentLoopData = $menuList->where('site_menu_id', 0)->skip(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mTop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li><a href="<?php echo e(route($mTop->route)); ?>"><?php echo e($mTop->name); ?></a></li>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<li><a href="<?php echo e(route('site.terms.and.condition')); ?>"><?php echo e(translate('Terms & Conditions')); ?></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="footer-widget">
						<h3><?php echo e(translate('Contact Information')); ?></h3>
						<ul>
							<li><a href="#"><?php echo e(translate('Phone')); ?> : <?php echo e($appearance->contact_phone); ?></a></li>
							<li><a href="#"><?php echo e(translate('Email to')); ?> : <?php echo e($appearance->contact_email); ?></a></li>
							<li><a href="#"><?php echo e(translate('Website')); ?> : <?php echo e($appearance->contact_web); ?></a></li>
							<li><a href="#"><?php echo e(translate('Address')); ?> : <?php echo e($appearance->address); ?></a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-2 col-md-6 col-sm-6">
					<div class="footer-widget">
						<h3 class="mb-20"><?php echo e(translate('Payment Method')); ?></h3>
						<ul class="d-flex flex-wrap">
							<li class="p-1"><img src="img/paypal.png" width="50" alt=""></li>
							<li class="p-1"><img src="img/stripe.png" width="50" alt=""></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="row footer-button-section d-flex justify-content-between align-items-center">
				<div class="col-lg-7 col-sm-12 fs-13">
					Copyright &copy; <?php echo e(now()->year); ?> All rights reserved | <?php echo e($appearance->app_name); ?>

				</div>
				<p class="col-lg-5 col-sm-12 footer-social-media">
					<a href="<?php echo e($appearance->faccebook_link); ?>"><i class="fab fa-facebook-f fs-13"></i></a>
					<a href="<?php echo e($appearance->twitter_link); ?>"><i class="fab fa-twitter fs-13"></i></a>
					<a href="<?php echo e($appearance->youtube_link); ?>"><i class="fab fa-youtube fs-13"></i></a>
					<a href="<?php echo e($appearance->instagram_link); ?>"><i class="fab fa-instagram fs-13"></i></a>

				</p>

			</div>
		</div>
	</footer>
	<!-- End footer -->
	<script src="<?php echo e(dsAsset('site/assets/js/bootstrap.min.js')); ?>"></script>
	<script src="<?php echo e(dsAsset('site/assets/js/popper.min.js')); ?>"></script>
	<script src="<?php echo e(dsAsset('site/assets/js/easing.js')); ?>"></script>
	<script src="<?php echo e(dsAsset('site/assets/js/lib/owl-carousel/owl.carousel.min.js')); ?>"></script>
	<script src="<?php echo e(dsAsset('site/assets/js/lib/magnific-popup/jquery.magnific-popup.min.js')); ?>"></script>
	<script src="<?php echo e(dsAsset('site/assets/js/main.js')); ?>"></script>
	<!--notify JS-->
	<script src="<?php echo e(dsAsset('js/lib/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')); ?>"></script>
	<!--JQ bootstrap validation-->
	<script src="<?php echo e(dsAsset('js/lib/assets/js/plugin/jquery-bootstrap-validation/jqBootstrapValidation.js')); ?>"></script>
	<script src="<?php echo e(dsAsset('js/lib/xd-dpicker/build/jquery.datetimepicker.full.min.js')); ?>"></script>
	<script src="<?php echo e(dsAsset('js/site.js')); ?>"></script>
	<script src="<?php echo e(dsAsset('js/lib/js-manager.js')); ?>"></script>
	<script src="<?php echo e(dsAsset('js/lib/js-message.js')); ?>"></script>
	<?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH /home/nacivnsa/public_html/reservacion/resources/views/site/layouts/site.blade.php ENDPATH**/ ?>