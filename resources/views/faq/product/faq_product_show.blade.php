@extends('home')

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/faq') }}"><i class="fa fa-question-circle"></i> FAQ Select</a></li>
        <li><a href="{{ route('faq_product.index') }}"><i class="fa fa-truck"></i> FAQ Product</a></li>
        <li class="active">Product</li>
    </ol>
    <div class="media">
        <div class="media-left">
            <a href="#">
                @if($product->img != null)
                    <img class="media-object" src="{{ asset($product->img) }}" alt="..." width="80" height="64">
                @else
                    <img class="media-object" src="{{ asset('default-images/no-image.jpg') }}" alt="..." width="80" height="64">
                @endif
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">{{ $product->name }}</h4>
            <button class="btn btn-primary" data-toggle="modal" data-target="#modal_add_faq_product">
                Add FAQ <i class="fa fa-plus"></i>
            </button>
            <button class="btn btn-default" data-toggle="collapse" data-target="#collapse_description" aria-expanded="false" aria-controls="collapse_description">
                Show Description
            </button>
        </div>
    </div>
    <br>
    <div class="collapse" id="collapse_description">
        <div class="well">
            {{ $product->description }}
        </div>
    </div>
@endsection

@section('main-content')
    <!-- Modal Add FAQ -->
    <div class="modal fade" id="modal_add_faq_product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add FAQ</h4>
                </div>
                {{ Form::open(['action' => 'FAQ\FAQProductController@store', 'id' => 'form_add_faq_product']) }}
                    <div class="modal-body">
                        {{ Form::hidden('productId', $product->systemId) }}
                        <div class="modal-body">
                            <div class="form-group">
                                {{ Form::label('question', 'Question', ['class' => 'control-label']) }}
                                {{ Form::text('question', null, ['class' => 'form-control', 'placeholder' => 'Enter your FAQ question']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('answer', 'Answer', ['class' => 'control-label']) }}
                                {{ Form::textarea('answer', null, ['class' => 'form-control', 'placeholder' => 'Enter your answer to current question']) }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $('#form_add_faq_product').validate({
            errorClass: "my-error-class",
            validClass: "my-valid-class",
            rules: {
                question: 'required',
                answer: 'required'
            },
            messages: {
                question: 'Please enter question',
                answer: 'Please enter the answer'
            },

            submitHandler: function (form) {
                form.submit();
            }
        });
    </script>
@endpush