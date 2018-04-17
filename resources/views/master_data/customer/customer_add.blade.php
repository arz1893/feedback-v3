@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/master_data/customer/vue_add_customer.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3> Add Customer </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('customer.index') }}"><i class="fa fa-group"></i> Customer List</a></li>
        <li class="active">Add Customer</li>
    </ol>
@endsection

@section('main-content')
    <div id="add_customer">
        <add-customer tenant_id="{{ Auth::user()->tenantId }}"></add-customer>
    </div>
@endsection