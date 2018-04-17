@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/master_data/customer/vue_edit_customer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/moment/moment.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3> Edit Customer </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('customer.index') }}"><i class="fa fa-group"></i> Customer List</a></li>
        <li class="active">Edit Customer</li>
    </ol>
@endsection

@section('main-content')
    <div id="edit_customer">
        <edit-customer customer_id="{{ $customer->systemId }}" sysupdater="{{ Auth::user()->systemId }}"></edit-customer>
    </div>
@endsection