<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('admin.title')}} | {{ trans('admin.login') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @if(!is_null($favicon = Admin::favicon()))
        <link rel="shortcut icon" href="{{$favicon}}">
@endif

<!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/font-awesome/css/font-awesome.min.css") }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/AdminLTE/dist/css/AdminLTE.min.css") }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/AdminLTE/plugins/iCheck/square/blue.css") }}">
    <link rel="stylesheet" href="{{ admin_asset("verify/css/verify.css") }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page" @if(config('admin.login_background_image'))style="background: url({{config('admin.login_background_image')}}) no-repeat;background-size: cover;"@endif>
<div class="login-box">
    <div class="login-logo"><strong style="color:white;">{{config('admin.name')}}</strong></div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">二次登陆验证</p>

        <form action="{{ admin_url('auth/validate2fa') }}" method="post">
            <div class="form-group has-feedback {!! !$errors->has('one_time_password') ?: 'has-error' !!}">

                @if($errors->has('one_time_password'))
                    @foreach($errors->get('one_time_password') as $message)
                        <label class="control-label" for="inputError"><em class="fa fa-times-circle-o"></em>{{$message}}</label><br>
                    @endforeach
                @endif

                <input type="number" class="form-control" placeholder="验证码" name="one_time_password" value="">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="row" style="margin-bottom: 15px;">
                <!-- /.col -->
                <div class="col-xs-4">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">验证</button>
                </div>
                <div class="col-xs-4">
                    <a href="{{admin_url('auth/logout')}}" class="btn btn-default btn-block btn-flat">取消</a>
                </div>
                <!-- /.col -->
            </div>
            <div class="row" style="margin-bottom: 15px;">
                <!-- /.col -->
                <div class="col-xs-12">
                    或者您可以使用 <a href="{{admin_url('auth/recovery')}}">恢复代码</a>
                </div>
                <!-- /.col -->
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="{{ admin_asset("vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js")}} "></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ admin_asset("vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- iCheck -->
<script src="{{ admin_asset("vendor/laravel-admin/AdminLTE/plugins/iCheck/icheck.min.js")}}"></script>
</body>
</html>