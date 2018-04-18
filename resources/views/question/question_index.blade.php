@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-multiselect/vue-multiselect.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/vue-assets/question/vue_question_index.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3> Add Question </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Add Question </li>
    </ol>
@endsection

@section('main-content')
    <div id="question_index">
        <question-index tenant_id="{{ Auth::user()->tenantId }}" syscreator="{{ Auth::user()->systemId }}"></question-index>
    </div>
@endsection