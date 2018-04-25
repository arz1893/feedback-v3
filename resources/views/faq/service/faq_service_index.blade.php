@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-multiselect/vue-multiselect.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/vue-assets/selection/service/service_selection.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue-multiselect/vue-multiselect.min.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/faq') }}"><i class="ion ion-help"></i> FAQ selection</a></li>
        <li class="active">FAQ Service</li>
    </ol>
    <span class="text-danger" style="font-size: 2em; position: relative; top: 5px;">FAQ</span>
    <a href="{{ route('faq_product.index') }}" role="button" class="btn btn-sm btn-link">Product</a>
    <a role="button" class="btn btn-sm btn-link bg-aqua">Service</a>
@endsection

@section('main-content')
    <div id="service_selection">
        <service-selection tenant_id="{{ Auth::user()->tenantId }}" type="faq"></service-selection>
    </div>
@endsection