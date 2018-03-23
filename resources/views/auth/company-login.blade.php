@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/functions/auth/login_function.js') }}" type="text/javascript"></script>
@endpush

@section('content')
    @include('layouts.errors.error_list')
    <div class="container">
        <div class="login-box">
            <div class="login-logo">
                <a href="#"><b>Customer</b>Feedback</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Enter your company email address</p>
                {{ Form::open(['action' => 'Auth\LoginController@checkTenant', 'id' => 'form-check-tenant']) }}
                <div class="form-group has-feedback">
                    {{ Form::email('tenant_email', null, ['class' => 'form-control', 'id' => 'txt_tenant_email', 'placeholder' => 'Your company email address']) }}
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                {{ Form::close() }}
                <div class="row">
                {{--<div class="col-xs-7"></div>--}}
                <!-- /.col -->
                    <div class="col-xs-12">
                        <button
                                type="submit"
                                class="btn btn-primary"
                                onclick="checkTenantName(this)"
                                data-toggle="popover"
                                data-placement="bottom"
                                data-trigger="focus"
                                title="Info"
                                data-content="Please enter your company email address"
                                style="width: 100%;">

                            Sign In <i class="fa fa-sign-in"></i>
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
    </div>
@endsection