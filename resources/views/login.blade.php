<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/colors.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="/assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="/assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="/assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->


    <!-- Theme JS files -->
    <script type="text/javascript" src="/assets/js/core/app.js"></script>
    <!-- /theme JS files -->

</head>

<body class="login-container">

<!-- Main navbar -->
<div class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><i class="icon-search4"></i> Amazon Team</a>

        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>
</div>
<!-- /main navbar -->


<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">

                <!-- Simple login form -->
                <form method="post">
                    <div class="panel panel-body login-form">
                        <div class="text-center">
                            <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                            <h5 class="content-group">Login to your account @if($errors->any())
                                    <small class="display-block text-danger">{{$errors->first()}}</small>
                                @endif</h5>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input type="text" class="form-control" placeholder="Email" name="email">
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input type="password" class="form-control" placeholder="Password" name="password">
                            <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                            </div>
                        </div>
                        @csrf
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 position-right"></i></button>
                        </div>
                    </div>
                </form>
                <!-- /simple login form -->


                <!-- Footer -->
                <div class="footer text-muted text-center">
                    &copy; 2018. <a href="#">Private server</a> by <a href="#" target="_blank">QuanDM</a>
                </div>
                <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

</body>
</html>
