@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/faq/service/vue_add_faq_service.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/faq') }}"><i class="fa fa-question-circle"></i> FAQ Select</a></li>
        <li><a href="{{ route('faq_service.index') }}"><i class="fa fa-truck"></i> FAQ Service</a></li>
        <li class="active">Service</li>
    </ol>
@endsection

@section('main-content')
    <div id="add_faq_service">
        <faq-service service_id="{{ $service->systemId }}" user="{{ Auth::user()->systemId }}"></faq-service>
    </div>
@endsection