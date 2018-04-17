@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/master_data/tag/vue_edit_tag.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h4> Edit Tag </h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('tag.index') }}"><i class="fa fa-tags"></i> Tags</a></li>
        <li class="active">Edit Tag</li>
    </ol>
@endsection

@section('main-content')
    <div id="tag_edit">
        <edit-tag tag_id="{{ $tag->systemId }}" sysupdater="{{ Auth::user()->systemId }}"></edit-tag>
    </div>
@endsection