@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-multiselect/vue-multiselect.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/vue-assets/master_data/service/vue_add_service.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue-multiselect/vue-multiselect.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vee-validate/vee-validate.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h4> Add Product </h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('service.index') }}"><i class="ion ion-bowtie"></i> Master Service</a></li>
        <li class="active">Add Product</li>
    </ol>
@endsection

@section('main-content')

    <div id="add_service">
        <add-service tenantId="{{ Auth::user()->tenantId }}"></add-service>
    </div>

@endsection