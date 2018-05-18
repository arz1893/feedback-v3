@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/user/vue_user_management_index.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3> Manage User </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Manage User </li>
    </ol>
@endsection

@section('main-content')
    <div id="user_management_index">
        <user-management-index tenant_id="{{ Auth::user()->tenantId }}" creator_id="{{ Auth::user()->systemId }}"></user-management-index>
    </div>
@endsection