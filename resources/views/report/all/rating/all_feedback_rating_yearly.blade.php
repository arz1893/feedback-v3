@extends('home')

@push('scripts')
    <script src="{{ asset('js/axios/axios.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/lodash/lodash.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/chartjs/all/rating/all_feedback_rating_yearly.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3 style="margin-top: -0.5%;" class="text-info">All Feedback Rating in <span id="current_year"></span></h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/feedback_report_selection') }}"><i class="fa fa-pie-chart"></i> Feedback Report Selection</a></li>
        <li class="active"> All Feedback Rating (Yearly) </li>
    </ol>
@endsection

@section('main-content')
    {{ Form::hidden('tenantId', Auth::user()->tenantId, ['id' => 'tenantId']) }}

    <div class="btn-group" role="group" aria-label="...">
        <a role="button" class="btn btn-xs btn-default">Daily</a>
        <a href="{{ route('all_feedback_rating_monthly') }}" role="button" class="btn btn-xs btn-default">Monthly</a>
        <a role="button" class="btn btn-xs btn-default active">Yearly</a>
    </div> <br> <br>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <form class="form-inline">
                    <div class="form-group pull-left">
                        {{ Form::label('select_year', 'Select Year') }}
                        {{ Form::selectYear('select_year', 1990, intval(date('Y')), intval(date('Y')), ['class' => 'form-control', 'onchange' => 'onChangeParameter()']) }}
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="loading_state" class="text-center invisible">
        <i class="fa fa-circle-o-notch fa-spin"></i> Loading...
    </div>

    <div id="not_found" class="well" style="margin-top: 3%; display: none;">
        <div class="text-center">
            There is no report found at current year
        </div>
    </div>

    <div class="chart-container">
        <canvas id="all_feedback_rating_yearly" height="125"></canvas>
    </div>
@endsection