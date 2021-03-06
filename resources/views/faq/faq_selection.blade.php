@extends('home')

@section('content-header')
    <h1 class="text-muted">Select FAQ</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">FAQ</li>
    </ol>
@endsection

@section('main-content')
    <div class="" style="margin-top: 2%">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <a role="button" href="{{ route('faq_product.index') }}">
                    <div class="info-box bg-aqua">
                        <span class="info-box-icon"><i class="ion ion-filing"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">FAQ Product</span>
                            {{--<span class="product-description">--}}
                            {{--{{ $productCounter }} item--}}
                            {{--</span>--}}
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description" style="font-size: 0.8em;">
                                Add FAQ to product
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </a>
            </div>
            <!-- /.col -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <a role="button" href="{{ route('faq_service.index') }}">
                    <div class="info-box bg-aqua">
                        <span class="info-box-icon"><i class="ion ion-bowtie"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">FAQ Service</span>
                            <span class="info-box-number"></span>
                            {{--<span class="progress-description">--}}
                            {{--{{ $serviceCounter }} item--}}
                            {{--</span>--}}
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description" style="font-size: 0.8em;">
                                Add FAQ to service
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </a>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection