@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/faq/product/vue_add_faq_product.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/faq') }}"><i class="fa fa-question-circle"></i> FAQ Select</a></li>
        <li><a href="{{ route('faq_product.index') }}"><i class="fa fa-truck"></i> FAQ Product</a></li>
        <li class="active">Product</li>
    </ol>
@endsection

@section('main-content')
    <div id="add_faq_product">
        <add-faq-product product_id="{{ $product->systemId }}" syscreator="{{ Auth::user()->systemId }}"></add-faq-product>
    </div>
@endsection