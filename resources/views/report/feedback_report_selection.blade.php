@extends('home')

@section('content-header')
    <h3> Report Selection </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Report Selection </li>
    </ol>
@endsection

@section('main-content')
    <div class="container">

        <!-- Heading Row -->
        <div class="row">

            <div class="col-lg-6 col-md-4 col-sm-4">
                <img class="img-responsive img-rounded" src="{{ asset('default-images/37.svg') }}">
            </div>

            <div class="col-md-5 col-sm-4">
                <h4 class="text-danger">Welcome to Feedback Report Section</h4>
                <p align="justify">This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->
        <hr>
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-6">
                <h2 class="text-info">Feedback Product Report <i class="fa fa-line-chart"></i></h2>
                <p>View all feedback product report</p>
                <a href="{{ route('feedback_product_report.index') }}" class="btn btn-danger">
                    Show <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
            <div class="col-md-6">
                <h2 class="text-info">Feedback Service Report <i class="fa fa-line-chart"></i></h2>
                <p>View all feedback service report</p>
                <a href="{{ route('feedback_service_report.index') }}" class="btn btn-warning" role="button">
                    Show <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- /.row -->

    </div>
@endsection