@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-multiselect/vue-multiselect.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/vue-assets/master_data/service/vue_edit_service.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue-multiselect/vue-multiselect.min.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3>Edit Service</h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('service.index') }}"><i class="fa fa-truck"></i> Master Service</a></li>
        <li class="active">Edit Service</li>
    </ol>
@endsection

@section('main-content')
    <div id="edit_service">
        <edit-service service_id="{{ $service->systemId }}" tenant_id="{{ $service->tenantId }}"></edit-service>
    </div>
@endsection