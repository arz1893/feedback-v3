@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-multiselect/vue-multiselect.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/vue-assets/feedback/service/feedback_service_edit.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h4 class="text-yellow">Edit Feedback Service</h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('feedback_service_list.index') }}"><i class="ion ion-clipboard"></i>Feedback Service List</a></li>
        <li class="active">Edit Feedback Product</li>
    </ol>
@endsection

@section('main-content')
    <div id="feedback_service_edit">
        <feedback-service-edit feedback_service_id="{{ $feedbackService->systemId }}" tenant_id="{{ $feedbackService->tenantId }}" syscreator="{{ Auth::user()->systemId }}"></feedback-service-edit>
    </div>
@endsection