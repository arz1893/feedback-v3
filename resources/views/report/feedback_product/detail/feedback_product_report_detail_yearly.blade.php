@extends('home')

@push('scripts')
    <script src="{{ asset('js/axios/axios.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/lodash/lodash.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/chartjs/feedback_product/detail/feedback_product_report_detail_yearly.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3 style="margin-top: -0.5%;" class="text-info"> Report Detail (Yearly) </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/feedback_report_selection') }}"><i class="fa fa-pie-chart"></i> Feedback Report Selection</a></li>
        <li><a href="{{ route('feedback_product_report.index') }}"><i class="fa fa-bar-chart"></i> Feedback Product Report</a></li>
        <li class="active"> Report Detail (Yearly) </li>
    </ol>
@endsection

@section('main-content')
    <div class="media">
        <div class="media-left">
            <a href="#">
                @if($product->img != null)
                    <img class="media-object" src="{{ asset($product->img) }}" alt="..." width="64" height="64">
                @else
                    <img class="media-object" src="{{ asset('default-images/no-image.jpg') }}" alt="..." width="64" height="64">
                @endif
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">{{ $product->name }}</h4>
            @if(count($product->tags) > 0)
                @foreach($product->tags as $tag)
                    <span class="label" style="background: {{ $tag->bgColor }}">{{ $tag->name }}</span>
                @endforeach
            @endif
        </div>
    </div>
    <hr/>

    {{ Form::hidden('productId', $product->systemId, ['id' => 'productId']) }}

    <div class="btn-group" role="group" aria-label="...">
        <a role="button" class="btn btn-xs btn-default">Daily</a>
        <a role="button" class="btn btn-xs btn-default">Weekly</a>
        <a href="{{ route('feedback_product_report_detail_monthly', $product->systemId) }}" role="button" class="btn btn-xs btn-default">Monthly</a>
        <a role="button" class="btn btn-xs btn-default active">Yearly</a>
    </div> <br> <br>

    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="pull-left">
                    <form class="form-inline">
                        <div class="form-group">
                            {{ Form::label('select_year', 'Select Year') }}
                            {{ Form::selectYear('select_year', 1990, intval(date('Y')), intval(date('Y')), ['class' => 'form-control']) }}
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <h4 class="text-center">All Feedback in <span id="current_year"></span></h4>

        <div id="loading_state" class="text-center invisible">
            <i class="fa fa-circle-o-notch fa-spin"></i> Loading...
        </div>

        <div id="not_found" class="well" style="margin-top: 2%; display: none;">
            <div class="text-center">
                There is no report found at current year
            </div>
        </div>

        <canvas id="feedback_product_chart_detail_yearly" style="height:55vh; width:80vw"></canvas>
    </div>
@endsection