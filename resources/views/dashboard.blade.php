<!-- Small boxes (Stat box) -->
<div class="row">

    @if(Auth::user()->user_group->getFaqCrudRights->view == 1)
        <a href="{{ url('/faq') }}">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="ion ion-clipboard"></i></span>

                    <div class="info-box-content">
                        {{--<span class="info-box-text">FAQ</span>--}}
                        <span class="info-box-number">FAQ</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                        </div>
                        <span class="progress-description">
                    frequently asked question
                  </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        </a>
    @endif

    <a href="{{ route('feedback.index') }}">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>

                <div class="info-box-content">
                    {{--<span class="info-box-text">FAQ</span>--}}
                    <span class="info-box-number">Feedback</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                        customer's feedback
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </a>

    @if(Auth::user()->user_group->getQuestionCrudRights->view == 1)
        <a href="{{ route('question.index') }}">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="ion ion-help-circled"></i></span>

                    <div class="info-box-content">
                        {{--<span class="info-box-text">FAQ</span>--}}
                        <span class="info-box-number">Questions</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                        </div>
                        <span class="progress-description">
                            customer's question
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        </a>
    @endif
</div>
<!-- /.row -->

<div class="row">
    <section class="content-header">
        <div class="page-header">
            <h3>Master Data <small>All of main data source</small></h3>
        </div>
    </section>
    <div class="content">
        <div class="row">

            @if(Auth::user()->user_group->getMasterDataRights->view == 1)
                <a href="{{ route('product.index') }}">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box bg-gray-light">
                            <span class="info-box-icon bg-blue"><i class="ion ion-filing"></i></span>

                            <div class="info-box-content">
                                <b>Products</b> <br>
                                @if($totalProduct == 0)
                                    <span class="info-box-text">You don't have any products registered yet</span>
                                @else
                                    <span class="info-box-text">{{ 'You have :' . $totalProduct . ' product' }}</span>
                                @endif
                                <span class="info-box-number"></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                </a>

                <a href="{{ route('service.index') }}">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box bg-gray-light">
                            <span class="info-box-icon bg-orange"><i class="ion ion-bowtie"></i></span>

                            <div class="info-box-content">
                                <b>Services</b> <br>
                                @if($totalService == 0)
                                    <span class="info-box-text">You don't have any services registered yet</span>
                                @else
                                    <span class="info-box-text">{{ 'You have :' . $totalService . ' service' }}</span>
                                @endif
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                </a>

                <a href="{{ route('tag.index') }}">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box bg-gray-light">
                            <span class="info-box-icon bg-teal"><i class="ion ion-pricetag"></i></span>

                            <div class="info-box-content">
                                <b>Tags</b> <br>
                                @if($totalTag == 0)
                                    <span class="info-box-text">You don't have any tag registered yet</span>
                                @else
                                    <span class="info-box-text">{{ 'You have :' . $totalTag . ' tag' }}</span>
                                @endif
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                </a>
            @endif

            @if(Auth::user()->user_group->getCustomerCrudRights->view == 1)
                <a href="{{ route('customer.index') }}">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box bg-gray-light">
                            <span class="info-box-icon bg-navy"><i class="fa fa-group"></i></span>

                            <div class="info-box-content">
                                <b>Customer</b> <br>
                                @if($totalTag == 0)
                                    <span class="info-box-text">You don't have any customer added yet</span>
                                @else
                                    <span class="info-box-text">{{ 'You have :' . $totalCustomer . ' customer' }}</span>
                                @endif
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                </a>
            @endif
        </div>
    </div>
</div>

@if(Auth::user()->user_group->getReportViewRights->view == 1)
    <div class="row" style="margin-top: -4%;">
        <section class="content-header">
            <div class="page-header">
                <h3>Report & Charts <small>All data information</small></h3>
            </div>
        </section>
        <div class="content">
            <div class="row">
                <div class="col-lg-3">
                    <a href="{{ url('/feedback_report_selection')  }}">
                        <img class="img-circle center-block" src="{{ asset('default-images/chart-icon.png') }}" alt="Generic placeholder image" width="140" height="140">
                    </a>
                    <a href="{{ url('/feedback_report_selection')  }}">
                        <h3 class="text-center">Feedback Report</h3>
                    </a>
                    <p align="center">Contains all feedback charts and statistic</p>
                </div><!-- /.col-lg-4 -->
            </div><!-- /.row -->
        </div>
    </div>
@endif