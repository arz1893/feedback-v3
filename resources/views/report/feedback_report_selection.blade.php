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

            <div class="col-lg-6 col-md-5 col-sm-4">
                <h4 class="text-danger">Welcome to Feedback Report Section</h4>
                <p align="justify">This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>

                <div class="row">
                    <div class="col-lg-6">
                        <a role="button">
                            <div class="panel panel-default">
                                <div class="panel-body text-center">
                                    All
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <a role="button">
                            <div class="panel panel-default">
                                <div class="panel-body text-center">
                                    Tag
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <a role="button">
                            <div class="panel panel-default">
                                <div class="panel-body text-center">
                                    Product
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <a role="button">
                            <div class="panel panel-default">
                                <div class="panel-body text-center">
                                    Service
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->
    </div>
@endsection