@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/master_data/customer/vue_index_customer.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3> Customer List </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Customer</li>
    </ol>
    <a role="button" class="btn btn-primary" href="{{ route('customer.create') }}">
        Add Customer
    </a>
@endsection

@section('main-content')
    <div id="master_customer_index">
        <customer-index tenant_id="{{ Auth::user()->tenantId }}"></customer-index>
    </div>
@endsection