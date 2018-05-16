@extends('home')

@push('scripts')
    <script src="{{ asset('js/axios/axios.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/lodash/lodash.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/chartjs/feedback_service/detail/feedback_service_report_detail_yearly.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3 style="margin-top: -0.5%;" class="text-info">Report Detail (Yearly)</h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/feedback_report_selection') }}"><i class="fa fa-pie-chart"></i> Feedback Report Selection</a></li>
        <li><a href="{{ route('feedback_service_report.index') }}"><i class="fa fa-bar-chart"></i> Feedback Service Report</a></li>
        <li class="active"> Report Detail (Yearly) </li>
    </ol>
@endsection

@section('main-content')
    <div class="media">
        <div class="media-left">
            <a href="#">
                @if($service->img != null)
                    <img class="media-object" src="{{ asset($service->img) }}" alt="..." width="64" height="64">
                @else
                    <img class="media-object" src="{{ asset('default-images/no-image.jpg') }}" alt="..." width="64" height="64">
                @endif
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">{{ $service->name }}</h4>
            @if(count($service->tags) > 0)
                @foreach($service->tags as $tag)
                    <span class="label" style="background: {{ $tag->bgColor }}">{{ $tag->name }}</span>
                @endforeach
            @endif
        </div>
    </div>
    <hr/>

    {{ Form::hidden('serviceId', $service->systemId, ['id' => 'serviceId']) }}

    <div class="btn-group" role="group" aria-label="...">
        <a role="button" class="btn btn-xs btn-default">Daily</a>
        <a href="{{ route('feedback_service_report_detail_monthly', $service->systemId) }}" role="button" class="btn btn-xs btn-default">Monthly</a>
        <a role="button" class="btn btn-xs btn-default active">Yearly</a>
    </div> <br> <br>

    <div class="row">
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

    <h4 class="text-center">All Feedback in <span id="current_year"></span></h4>

    <div id="loading_state" class="text-center invisible">
        <i class="fa fa-circle-o-notch fa-spin"></i> Loading...
    </div>

    <div id="not_found" class="well" style="margin-top: 2%; display: none;">
        <div class="text-center">
            There is no report found at current year
        </div>
    </div>

    <div class="col-lg-12">
        <canvas id="feedback_service_chart_detail_yearly"></canvas>
    </div>
@endsection