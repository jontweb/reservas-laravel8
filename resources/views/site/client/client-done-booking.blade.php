@extends('site.layouts.site-dashboard')
@section('content-site-dashboard')
<link href="{{ dsAsset('site/css/custom/client/client-done-booking.css') }}" rel="stylesheet" />
<div class="row">
	<div class="col-md-12">
		<div class="card card-box-shadow p-4 card-done-booking">
			<div class="w-100 pb-3">
				<h5>{{translate('All done booking info')}}</h5>
			</div>
			<div class="col-md-12">
				<table class="table table-responsive w100" id="tableElement"></table>
			</div>
		</div>

	</div>
</div>
<script src="{{ dsAsset('site/js/custom/client/client-done-booking.js') }}"></script>
@endsection