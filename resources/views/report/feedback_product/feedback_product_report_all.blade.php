@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/report/feedback_product/vue_feedback_product_report_all.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3> Feedback Product Report All </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/feedback_report_selection') }}"><i class="fa fa-pie-chart"></i> Feedback Report Selection</a></li>
        <li><a href="{{ route('feedback_product_report.index') }}"><i class="fa fa-bar-chart"></i> Feedback Product Report</a></li>
        <li class="active"> View All </li>
    </ol>
@endsection

@section('main-content')
    <div id="feedback_product_report_all">
        <feedback-product-report-all tenant_id="{{ Auth::user()->tenantId }}"></feedback-product-report-all>
    </div>
@endsection