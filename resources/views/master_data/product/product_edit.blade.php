@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-multiselect/vue-multiselect.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/vue-assets/master_data/product/vue_edit_product.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue-multiselect/vue-multiselect.min.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3>Edit Product</h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('product.index') }}"><i class="fa fa-truck"></i> Master Product</a></li>
        <li class="active">Edit Product</li>
    </ol>
@endsection

@section('main-content')
    <div id="edit_product">
        <edit-product product_id="{{ $product->systemId }}" tenant_id="{{ $product->tenantId }}"></edit-product>
    </div>
@endsection