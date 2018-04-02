@extends('home')

@push('styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.2.3/jquery.contextMenu.min.css" />
@endpush

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.2.3/jquery.contextMenu.min.js"></script>
    <script src="{{ asset('js/tree-crud/tree-master-service-function.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h1 class="text-muted">Service Detail</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('service.index') }}"><i class="fa fa-trophy"></i> Master Service</a></li>
        <li class="active">{{ $service->name }}</li>
    </ol>
@endsection

@section('main-content')

    <div class="row">
        {{ Form::hidden('service_id', $service->systemId, ['id' => 'service_id']) }}
    </div>

    <div class="span8">

        <div class="media">
            <div class="media-left">
                <a href="#!">
                    @if($service->img != null)
                        <img class="media-object" src="{{ asset($service->img) }}" alt="{{ $service->name }}" width="120" height="80">
                    @else
                        <img class="media-object" src="{{ asset('default-images/no-image.jpg') }}" alt="{{ $service->name }}" width="120" height="80">
                    @endif
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading">{{ $service->name }}</h4>
                <div class="form-group">
                    Tags:
                    @if(count($serviceTags) > 0)
                        @foreach($serviceTags as $tag)
                            <span class="label" style="background: {{ $tag->bgColor }}">{{ $tag->name }}</span>
                        @endforeach
                    @endif
                </div>
                <button class="btn btn-xs btn-default"
                        type="button"
                        data-toggle="collapse"
                        data-target="#service_description"
                        aria-expanded="false"
                        aria-controls="collapseExample">
                    Show Description
                </button>
            </div>
        </div>
        <br>
        <div class="collapse" id="service_description">
            <div class="well text-justify">
                @if($service->description != null)
                    {{ $service->description }}
                @else
                    This service doesn't have any description yet
                @endif
            </div>
        </div>

        @include('layouts.errors.error_list')
        @if(\Session::has('status'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Info!</strong> {{ \Session::get('status') }}
            </div>
        @endif

        <br>

        <p class="text-justify">
            <b>Category list :</b>
            @if($hasCategory == false)
                <small class="text-muted">*please add category first</small>
            @endif
        </p>

        <button type="button"
                class="btn btn-success"
                data-toggle="modal"
                data-target="#modal_add_service_category"
                data-service_id="{{ $service->systemId }}"
                data-type="root"
                onclick="setServiceCategoryType(this)">
            <i class="ion ion-plus-circled"></i> Add category
        </button>
        <button type="button"
                class="btn btn-primary"
                data-service_id="{{ $service->systemId }}"
                data-type="sub"
                onclick="setServiceCategoryType(this)">
            <i class="ion ion-network"></i> Add sub category
        </button>

        <div id="service_category_tree"></div>

        <button type="button"
                class="btn btn-warning"
                data-service_id="{{ $service->systemId }}"
                data-type="rename"
                onclick="setServiceCategoryType(this)">
            <i class="ion ion-edit"></i> Rename
        </button>
        <button type="button"
                class="btn btn-danger"
                data-service_id="{{ $service->systemId }}"
                data-type="delete"
                onclick="setServiceCategoryType(this)">
            <i class="ion ion-close-circled"></i> Remove
        </button>

        @if($hasCategory == true)
            <div id="selected-action">Click right mouse button on a node.</div>
        @endif
    </div>

    @include('layouts.master_data.service_category.modal_crud_service_category')

@endsection