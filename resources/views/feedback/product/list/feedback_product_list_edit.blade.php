@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-multiselect/vue-multiselect.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/vue-assets/feedback/product/feedback_product_edit.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h4 class="text-yellow">Edit Feedback Product</h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('feedback_product_list.index') }}"><i class="ion ion-clipboard"></i>Feedback Product List</a></li>
        <li class="active">Edit Feedback Product</li>
    </ol>
@endsection

@section('main-content')
    <div id="feedback_product_edit">
        <feedback-product-edit feedback_product_id="{{ $feedbackProduct->systemId }}" tenant_id="{{ $feedbackProduct->tenantId }}" syscreator="{{ Auth::user()->systemId }}"></feedback-product-edit>
    </div>
@endsection