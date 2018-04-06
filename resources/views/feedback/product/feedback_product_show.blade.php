@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-multiselect/vue-multiselect.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/vue-assets/feedback/product/feedback_show.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue-multiselect/vue-multiselect.min.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <div class="media">
        <div class="media-left">
            <a href="#">
                @if($product->img != null)
                    <img class="media-object" src="{{ asset($product->img) }}" alt="..." width="64" height="64">
                @else
                    <img class="media-object" src="{{ asset('default-images/no-image.jpg') }}" alt="..." width="64" height="64">
                @endif
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">{{ $product->name }}</h4>
            @if(count($product->tags) > 0)
                @foreach($product->tags as $tag)
                    <span class="label" style="background: {{ $tag->bgColor }}">{{ $tag->name }}</span>
                @endforeach
            @endif
            <br>
            <small class="text-red">*Please choose category that you want to add a feedback</small>
        </div>
    </div>

    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('feedback_product.index') }}"><i class="fa ion-settings"></i> Feedback Product </a></li>
        <li class="active">Add Feedback</li>
    </ol>
@endsection

@section('main-content')
    <div id="feedback_show">
        <feedback-show product_id="{{ $product->systemId }}" tenant_id="{{ $product->tenantId }}" syscreator="{{ Auth::user()->systemId }}"></feedback-show>
    </div>
@endsection