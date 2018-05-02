@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/charts/chart-stylesheet.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/axios/axios.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/lodash/lodash.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modernizr/modernizr-custom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/chartjs/feedback_product/all/feedback_report_top_product_yearly.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3 style="margin-top: -0.5%;" class="text-info">All Feedback Product in <span id="current_year"></span></h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/feedback_report_selection') }}"><i class="fa fa-pie-chart"></i> Feedback Report Selection</a></li>
        <li class="active"> Top Product (Yearly) </li>
    </ol>
@endsection

@section('main-content')

    {{ Form::hidden('tenantId', Auth::user()->tenantId, ['id' => 'tenantId']) }}

    <div class="btn-group" role="group" aria-label="...">
        <a role="button" class="btn btn-xs btn-default">Daily</a>
        <a role="button" href="{{ route('feedback_product_report_top_monthly') }}" class="btn btn-xs btn-default">Monthly</a>
        <a role="button" class="btn btn-xs btn-default active">Yearly</a>
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

    <div class="row">
        <div class="col-lg-2 pull-left">
            <div class="form-inline">
                <div class="form-group">
                    {{ Form::label('show_data', 'Show') }}
                    {{ Form::select('show_data', ['10' => '10', '50' => '50', '100' => '100'], 10, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="col-lg-2 pull-right">
            <div class="pull-right">
                <form class="form-inline">
                    <div class="form-group">
                        {{ Form::label('select_year', 'Select Year') }}
                        {{ Form::selectYear('select_year', 1990, intval(date('Y')), intval(date('Y')), ['class' => 'form-control']) }}
                    </div>
                </form>
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
            There is no report found at current year
        </div>
    </div>

    <div style="height: 300px; !important;">
        <canvas id="feedback_report_all_product_yearly" height="275" width="800"></canvas>
    </div>
@endsection