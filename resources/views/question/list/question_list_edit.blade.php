@extends('home')

@push('scripts')
    <script src="{{ mix('js/vue-assets/question/vue_question_edit.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3> Question Edit </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Question Edit </li>
    </ol>
@endsection

@section('main-content')
    <div id="question_edit">
        <question-edit question_id="{{ $question->systemId }}" user="{{ Auth::user()->systemId }}" tenant_id="{{ Auth::user()->tenantId }}"></question-edit>
    </div>
@endsection