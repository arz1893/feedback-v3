@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/selection/tag/tag_selection.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3 style="margin-top: -0.5%;"> Select Tag </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/feedback_report_selection') }}"><i class="fa fa-pie-chart"></i> Feedback Report Selection</a></li>
        <li class="active"> Select Tag </li>
    </ol>
@endsection

@section('main-content')
    <div id="tag_selection">
        <tag-selection tenant_id="{{ Auth::user()->tenantId }}"></tag-selection>
    </div>
@endsection