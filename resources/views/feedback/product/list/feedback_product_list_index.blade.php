@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-multiselect/vue-multiselect.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/vue-assets/feedback/product/feedback_product_list.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3 class="text-red" style="margin-top: -0.5%;">Feedback Product List</h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Feedback Product List</li>
    </ol>
@endsection

@section('main-content')
    <div id="feedback_product_list">
        <feedback-list tenant_id="{{ Auth::user()->tenantId }}" user_id="{{ Auth::user()->systemId }}"></feedback-list>
    </div>
@endsection