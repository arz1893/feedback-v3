@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/question/vue_question_list.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3> Question List </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Question List </li>
    </ol>
@endsection

@section('main-content')
    <div id="question_list">
        <question-list tenant_id="{{ Auth::user()->tenantId }}" user="{{ Auth::user()->systemId }}" user_group_id="{{ Auth::user()->user_group->systemId }}"></question-list>
    </div>
@endsection