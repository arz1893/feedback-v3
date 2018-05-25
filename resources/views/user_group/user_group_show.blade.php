@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/user_group/vue_user_group_show.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3> Role Detail </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('user_group.index') }}"><i class="fa fa-sitemap"></i> Show Roles </a></li>
        <li class="active"> Show </li>
    </ol>
@endsection

@section('main-content')
    <div id="user_group_show">
        <user-group-show usergroup_id="{{ $userGroup->systemId }}"></user-group-show>
    </div>
@endsection