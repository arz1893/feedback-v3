@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-multiselect/vue-multiselect.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/vue-assets/selection/product/product_selection.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue-multiselect/vue-multiselect.min.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('feedback.index') }}"><i class="ion ion-settings"></i> Feedback selection</a></li>
        <li class="active">Feedback Product</li>
    </ol>
    <span class="text-danger" style="font-size: 2em; position: relative; top: 5px;">Feedback</span>
    <a role="button" class="btn btn-sm btn-flat bg-aqua">Product</a>
    <a role="button" href="{{ route('feedback_service.index') }}" class="btn btn-sm btn-link">Service</a>
@endsection

@section('main-content')
    <div id="product_selection">
        <product-selection tenant_id="{{ Auth::user()->tenantId }}" type="feedback"></product-selection>
    </div>
@endsection