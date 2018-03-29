@extends('home')
@push('styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.2.3/jquery.contextMenu.min.css" />
@endpush

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.2.3/jquery.contextMenu.min.js"></script>
    <script src="{{ asset('js/tree-crud/tree-master-product-function.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    {{--<h1 class="text-muted">Product Detail</h1>--}}
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('product.index') }}"><i class="fa fa-truck"></i> Master Product</a></li>
        <li class="active">{{ $product->name }}</li>
    </ol>

@endsection

@section('main-content')

    <div class="row">
        {{ Form::hidden('product_id', $product->systemId, ['id' => 'product_id']) }}
    </div>

    <div class="span8">
        <div class="media">
            <div class="media-left">
                <a href="#">
                    @if($product->img != null)
                        <img class="media-object" src="{{ asset($product->img) }}" alt="{{ $product->name }}" width="120" height="80">
                    @else
                        <img class="media-object" src="{{ asset('default-images/no-image.jpg') }}" alt="{{ $product->name }}" width="120">
                    @endif
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading">{{ $product->name }}</h4>
                <div class="form-group">
                    Tags :
                    @if(count($productTags) > 0)
                        @foreach($productTags as $tag)
                            <span class="label" style="background: {{ $tag->bgColor }}">{{ $tag->name }}</span>
                        @endforeach
                    @endif
                </div>
                <button class="btn btn-xs btn-default"
                        type="button"
                        data-toggle="collapse"
                        data-target="#product_description"
                        aria-expanded="false"
                        aria-controls="collapseExample">
                    Show Description
                </button>
            </div>
        </div>
        <br>
        <div class="collapse" id="product_description">
            <div class="well text-justify">
                @if($product->description != null)
                    {{ $product->description }}
                @else
                    This product doesn't have any description yet
                @endif
            </div>
        </div>

        <p class="text-justify">
            <b>Category list :</b>
            @if($hasCategory == false)
                <small class="text-muted">*please add category first</small>
            @endif
            <br>
        </p>
        <button type="button"
                class="btn btn-success"
                data-toggle="modal"
                data-target="#modal_add_product_category"
                data-product_id="{{ $product->systemId }}"
                data-type="root"
                onclick="setProductCategoryType(this)">
            <i class="ion ion-plus-circled"></i> Add Category
        </button>
        <button type="button"
                class="btn btn-primary"
                data-product_id="{{ $product->systemId }}"
                data-type="sub"
                onclick="setProductCategoryType(this)">
            <i class="ion ion-network" aria-hidden="true"></i> Add sub category
        </button>

        <div id="product_category_tree" class=""></div>

        <button type="button"
                class="btn btn-warning"
                data-product-id="{{ $product->systemId }}"
                data-type="edit"
                onclick="setProductCategoryType(this)">
            <i class="ion ion-edit" aria-hidden="true"></i> Rename
        </button>
        <button type="button"
                class="btn btn-danger"
                data-product-id="{{ $product->systemId }}"
                data-type="delete"
                onclick="setProductCategoryType(this)">
            <i class="ion ion-close-circled" aria-hidden="true"></i> Remove
        </button>

        @if($hasCategory == true)
            <div id="selected-action">Click right mouse button on a node.</div>
        @endif
    </div>

    @include('layouts.master_data.product_category.modal_crud_product_category')
@endsection