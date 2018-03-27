@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/master_data/product/vue_index_product.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h4 class="text-danger"> Master Product </h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Product</li>
    </ol>
@endsection

@section('main-content')

    <a href="{{ route('product.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle"></i> Add Product
    </a>
    <br><br>

    <div id="master_product_index">
        <product-index-component tenantId="{{ Auth::user()->tenantId }}"></product-index-component>
    </div>

@endsection