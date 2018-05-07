@extends('home')

@section('content-header')
    <h3 style="margin-top: -0.5%;"> Report Selection </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Report Selection </li>
    </ol>
@endsection

@section('main-content')
    <div class="container">

        <!-- Heading Row -->
        <div class="row">

            <div class="col-lg-4 col-md-4 col-sm-4">
                <img class="img-responsive" src="{{ asset('default-images/37.svg') }}">
            </div>

            <div class="col-lg-6 col-md-5 col-sm-4">
                <h4 class="text-danger">Welcome to Feedback Report Section</h4>
                <p align="justify">This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>
            </div>
            <!-- /.col-md-4 -->
        </div>
    </div>
    <br>
    <!-- /.row -->
    <div class="col-lg-12">
        <div class="col-lg-3">
            <a class="btn btn-lg btn-block btn-social btn-default bg-blue" role="button" data-toggle="collapse" href="#collapse_all_report" aria-expanded="false" aria-controls="collapse_all_report">
                <i class="fa fa-bar-chart"></i> <span class="pull-left">All Report</span>
            </a>

            <div class="collapse" id="collapse_all_report">
                <div class="well">
                    <div class="text-center">
                        <a href="{{ route('all_feedback_rating_yearly') }}" class="btn btn-app">
                            <i class="fa fa-bar-chart"></i> Rating
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <a class="btn btn-lg btn-block btn-social btn-default bg-green" role="button" data-toggle="collapse" href="#collapse_all_tag" aria-expanded="false" aria-controls="collapse_all_tag">
                <i class="fa fa-tags"></i> <span class="pull-left">Tag</span>
            </a>
            <div class="collapse" id="collapse_all_tag">
                <div class="well">
                    <div class="text-center">
                        <a class="btn btn-app">
                            <i class="fa fa-play"></i> Action 1
                        </a>
                        <a class="btn btn-app">
                            <i class="fa fa-repeat"></i> Action 2
                        </a>
                        <a class="btn btn-app">
                            <i class="fa fa-pause"></i> Action 3
                        </a>
                        <a class="btn btn-app">
                            <i class="fa fa-save"></i> Action 4
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <a class="btn btn-lg btn-block btn-social btn-default bg-red" role="button" data-toggle="collapse" href="#collapse_all_product" aria-expanded="false" aria-controls="collapse_all_product">
                <i class="ion ion-filing"></i> <span class="pull-left">Product</span>
            </a>
            <div class="collapse" id="collapse_all_product">
                <div class="well">
                    <div class="text-center">
                        <a href="{{ route('feedback_product_report_top_yearly') }}" class="btn btn-app">
                            <i class="fa fa-bar-chart"></i> Satisfaction
                        </a>
                        <a href="{{ route('feedback_product_report_all_monthly') }}" class="btn btn-app">
                            <i class="fa fa-object-group"></i> All
                        </a>
                        <a href="{{ route('feedback_product_report.index') }}" class="btn btn-app">
                            <i class="fa fa-object-ungroup"></i> Specific
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <a class="btn btn-lg btn-block btn-social btn-default bg-yellow" role="button" data-toggle="collapse" href="#collapse_all_service" aria-expanded="false" aria-controls="collapse_all_service">
                <i class="ion ion-bowtie"></i> <span class="pull-left">Service</span>
            </a>
            <div class="collapse" id="collapse_all_service">
                <div class="well">
                    <div class="text-center">
                        <a href="{{ route('feedback_service_report_top_yearly') }}" class="btn btn-app">
                            <i class="fa fa-bar-chart"></i> Satisfaction
                        </a>
                        <a href="{{ route('feedback_service_report_all_monthly') }}" class="btn btn-app">
                            <i class="fa fa-object-group"></i> All
                        </a>
                        <a href="{{ route('feedback_service_report.index') }}" class="btn btn-app">
                            <i class="fa fa-object-ungroup"></i> Specific
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection