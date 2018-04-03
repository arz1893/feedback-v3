@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-multiselect/vue-multiselect.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/vue-assets/master_data/tag/vue_index_tag.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue-multiselect/vue-multiselect.min.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h4> Master Tag </h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tag</li>
    </ol>
@endsection

@section('main-content')
    <a href="{{ route('tag.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle"></i> Add Tag
    </a> <br> <br>

    <div id="master_tag_index">
        <tag-index-component tenant_id="{{ Auth::user()->tenantId }}"></tag-index-component>
    </div>

@endsection