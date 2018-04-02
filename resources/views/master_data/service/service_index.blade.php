@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-multiselect/vue-multiselect.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/vue-assets/master_data/service/vue_index_service.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue-multiselect/vue-multiselect.min.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h4 class="text-danger"> Master Service </h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Service</li>
    </ol>
@endsection

@section('main-content')

    <a href="{{ route('service.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle"></i> Add Service
    </a>
    <br><br>

    {{ Form::hidden('tenantId', Auth::user()->tenantId, ['id' => 'tenantId']) }}

    <div id="master_service_index">
        <service-index-component tenantId="{{ Auth::user()->tenantId }}"></service-index-component>
    </div>

@endsection