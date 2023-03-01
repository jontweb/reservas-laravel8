@extends('site.layouts.site-dashboard')
@section('content-site-dashboard')
<link href="{{ dsAsset('site/css/custom/client/client-pending-booking.css') }}" rel="stylesheet" />
<div class="row">
	<div class="col-md-12">
		<div class="card card-box-shadow card-pending-booking p-4">
			<div class="w-100 pb-3">
			<h5>{{translate('All pending & other booking info')}}</h5>
			</div>
			<div class="col-md-12">
				<table class="table table-responsive w100" id="tableElement"></table>
			</div>
		</div>

	</div>
</div>
<script src="{{ dsAsset('site/js/custom/client/client-pending-booking.js') }}"></script>
@endsection