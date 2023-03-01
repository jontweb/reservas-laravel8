@extends('site.layouts.site')
@section('content')
<link href="{{ dsAsset('site/css/custom/choose-payment-method.css') }}" rel="stylesheet" />
<div class="row">
    <div class="col-md-6 offset-md-3 mt-4">
        <div class="main-card  card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">
                        {{translate('Choose your desired payment partner')}}
                    </h4>

                </div>
            </div>
            <div class="card-body">
                @foreach($paymentMethod->all() as $pay)
                @if ($pay['type']!=1)
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <div class="payment-choose-div {{$pay['type']==2?'payment-choose':''}}">
                            <input {{$pay['type']==2?'checked':''}} type="radio" name="payment_type" value="{{$pay['id']}}" class="float-start payment-radio d-none" />
                            @if ($pay['type']==2)
                            <i class="fab fa-cc-paypal float-start m-1 fa-2x"></i>
                            @elseif ($pay['type']==3)
                            <i class="fab fa-cc-stripe float-start m-1 fa-2x"></i>
                            @else
                            <i class="fas fa-money-bill-alt float-start m-1 fa-2x"></i>
                            @endif
                            <div class="float-start color-black p-2">{{$pay['name']}}</div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
                <div class="row">
                    <div class="col mt-3">
                        <button id="btnNext" type="button" class="btn btn-booking btn-lg float-end w-100">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ dsAsset('site/js/custom/choose-payment-method.js') }}"></script>
@endsection