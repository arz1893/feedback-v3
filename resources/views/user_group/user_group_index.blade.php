@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/user_group/vue_user_group_index.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3> Manage Role </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Manage Role </li>
    </ol>
@endsection

@section('main-content')
    <div id="user_group_index">
        <user-group-index tenant_id="{{ Auth::user()->tenantId }}"></user-group-index>
    </div>
@endsection