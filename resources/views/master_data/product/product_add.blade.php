@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-multiselect/vue-multiselect.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/vue-assets/master_data/product/vue_add_product.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue-multiselect/vue-multiselect.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vee-validate/vee-validate.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h4> Add Product </h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('product.index') }}"><i class="ion ion-filing"></i> Master Product</a></li>
        <li class="active">Add Product</li>
    </ol>
@endsection

@section('main-content')

    @include('layouts.errors.error_list')

    <div id="add_product">
        <add-product tenantId="{{ Auth::user()->tenantId }}"></add-product>
    </div>

@endsection