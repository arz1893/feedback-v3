@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/master_data/product/vue_add_product.js') }}" type="text/javascript"></script>
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

    {{ Form::hidden('tenantId', Auth::user()->tenantId, ['id' => 'tenantId']) }}

    <div id="add_product"></div>

@endsection