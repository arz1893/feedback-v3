@extends('home')

@push('scripts')
    <script src="{{ asset('js/axios/axios.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/lodash/lodash.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modernizr/modernizr-custom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/chartjs/feedback_service/all/feedback_report_top_service_monthly.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3 style="margin-top: -0.5%;" class="text-info">Top Feedback Service in <span id="current_month"></span> <span id="current_year"></span></h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/feedback_report_selection') }}"><i class="fa fa-pie-chart"></i> Feedback Report Selection</a></li>
        <li class="active"> Top Service (Monthly)</li>
    </ol>
@endsection

@section('main-content')
    {{ Form::hidden('tenantId', Auth::user()->tenantId, ['id' => 'tenantId']) }}

    <div class="btn-group" role="group" aria-label="...">
        <a role="button" class="btn btn-xs btn-default">Daily</a>
        <a role="button" class="btn btn-xs btn-default active">Monthly</a>
        <a href="{{ route('feedback_service_report_top_yearly') }}" role="button" class="btn btn-xs btn-default">Yearly</a>
    </div>

    {{ Form::radio('customer_rating', 1, false, ['id' => 'radio_dissatisfied', 'class' => 'invisible']) }}
    {{ Form::radio('customer_rating', 2, false, ['id' => 'radio_neutral', 'class' => 'invisible']) }}
    {{ Form::radio('customer_rating', 3, false, ['id' => 'radio_satisfied', 'class' => 'invisible', 'checked' => true]) }}

    <div class="text-center">
        Customer Rating
        <br>
        <a>
            <i id="very_bad"
               class="smiley_rating material-icons text-maroon"
               style="font-size: 3.5em;"
               data-value="1" onclick="customerRating(this)">
                sentiment_very_dissatisfied
            </i>
        </a>
        <a>
            <i id="normal"
               class="smiley_rating material-icons text-yellow"
               style="font-size: 3.5em;"
               data-value="2" onclick="customerRating(this)">
                sentiment_neutral
            </i>
        </a>
        <a>
            <i id="very_satisfied"
               class="smiley_rating material-icons text-green is-selected"
               style="font-size: 3.5em;"
               data-value="3" onclick="customerRating(this)">
                sentiment_very_satisfied
            </i>
        </a>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-inline">
                    <div class="form-group pull-left">
                        {{ Form::label('select_month', 'Month') }}
                        {{ Form::selectMonth('select_month', intval(date('m')), ['class' => 'form-control', 'onchange' => 'changeParameter()']) }}
                    </div> &nbsp; &nbsp; &nbsp; &nbsp;
                    <div class="form-group pull-left">
                        {{ Form::label('select_year', 'Select Year') }}
                        {{ Form::selectYear('select_year', 1990, intval(date('Y')), intval(date('Y')), ['class' => 'form-control', 'onchange' => 'changeParameter()']) }}
                    </div>
                    <div class="form-group pull-right">
                        {{ Form::label('show_data', 'Show') }}
                        {{ Form::select('show_data', ['10' => '10', '50' => '50', '100' => '100'], 10, ['class' => 'form-control', 'onchange' => 'changeParameter()']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="visible-xs">
        <p class="text-muted">Note *: for best experience please view it on desktop</p>
    </div>

    <div id="loading_state" class="text-center invisible">
        <i class="fa fa-circle-o-notch fa-spin"></i> Loading...
    </div>

    <div id="not_found" class="well" style="margin-top: 3%; display: none;">
        <div class="text-center">
            There is no report found at current selected year and month
        </div>
    </div>

    <div class="chart-container">
        <canvas id="feedback_report_all_service_monthly" width="800" height="275"></canvas>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_customer_feedback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><span id="service_name"></span></h4>
                </div>
                <div class="modal-body" style="max-height: calc(100vh - 212px); overflow-y: auto;">
                    <div id="feedback_content"></div>
                </div>
            </div>
        </div>
    </div>
@endsection