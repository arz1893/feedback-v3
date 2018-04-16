@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/master_data/tag/vue_add_tag.js') }}"></script>
@endpush

@section('content-header')
    <h4> Add Tag </h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('tag.index') }}"><i class="ion ion-pricetag"></i> Master Tag</a></li>
        <li class="active">Add Tag</li>
    </ol>
@endsection

@section('main-content')
    <div id="tag_add">
        <tag-add-component tenant_id="{{ Auth::user()->tenantId }}" syscreator="{{ Auth::user()->systemId }}"></tag-add-component>
    </div>
@endsection