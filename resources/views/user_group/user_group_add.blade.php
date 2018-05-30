@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/user_group/vue_user_group_add.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3> Add Role </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('user_group.index') }}"><i class="fa fa-sitemap"></i> Manage Role</a></li>
        <li class="active"> Add Role </li>
    </ol>
@endsection

@section('main-content')
    <div id="user_group_add">
        <user-group-add tenant_id="{{ Auth::user()->tenantId }}" creator_id="{{ Auth::user()->systemId }}"></user-group-add>
    </div>
@endsection