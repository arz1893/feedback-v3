@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-multiselect/vue-multiselect.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/vue-assets/feedback/service/feedback_service_show.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue-multiselect/vue-multiselect.min.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <div class="media">
        <div class="media-left">
            <a href="#">
                @if($service->img != null)
                    <img class="media-object" src="{{ asset($service->img) }}" alt="..." width="64" height="64">
                @else
                    <img class="media-object" src="{{ asset('default-images/no-image.jpg') }}" alt="..." width="64" height="64">
                @endif
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">{{ $service->name }}</h4>
            @if(count($service->tags) > 0)
                @foreach($service->tags as $tag)
                    <span class="label" style="background: {{ $tag->bgColor }}">{{ $tag->name }}</span>
                @endforeach
            @endif
            <br>
            <small class="text-red">*Please choose category that you want to add a feedback</small>
        </div>
    </div>

    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('feedback_service.index') }}"><i class="fa ion-settings"></i> Feedback Service </a></li>
        <li class="active">Add Feedback</li>
    </ol>
@endsection

@section('main-content')
    <div id="feedback_service_show">
        <feedback-show service_id="{{ $service->systemId }}" tenant_id="{{ $service->tenantId }}" syscreator="{{ Auth::user()->systemId }}"></feedback-show>
    </div>
@endsection