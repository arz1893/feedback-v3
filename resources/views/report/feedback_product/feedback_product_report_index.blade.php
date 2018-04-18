@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-multiselect/vue-multiselect.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/vue-assets/selection/product/product_selection.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3> Feedback Product Report </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/feedback_report_selection') }}"><i class="fa fa-pie-chart"></i> Feedback Report Selection</a></li>
        <li class="active"> Feedback Product Report </li>
    </ol>
    <a role="button" class="btn btn-primary">
        View all report <i class="fa fa-bar-chart"></i>
    </a>
@endsection

@section('main-content')
    <p class="text-yellow">Note *: report section is under construction</p>
    <div id="product_selection">
        <product-selection tenant_id="{{ Auth::user()->tenantId }}" type="report"></product-selection>
    </div>
@endsection