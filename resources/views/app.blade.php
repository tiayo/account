<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link rel="shortcut icon" href="#" type="image/png">

    <title>@yield('title')-星科技监控系统</title>

    <!--icheck-->
    <link href="{{ asset('/static/adminex/js/iCheck/skins/minimal/minimal.css') }}" rel="stylesheet">
    <link href="{{ asset('/static/adminex/js/iCheck/skins/square/square.css') }}" rel="stylesheet">
    <link href="{{ asset('/static/adminex/js/iCheck/skins/square/red.css') }}" rel="stylesheet">
    <link href="{{ asset('/static/adminex/js/iCheck/skins/square/blue.css') }}" rel="stylesheet">

    <!--dashboard calendar-->
    <link href="{{ asset('/static/adminex/css/clndr.css') }}" rel="stylesheet">

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ asset('/static/adminex/js/morris-chart/morris.css') }}">

    <!--common-->
    <link href="{{ asset('/static/adminex/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/static/adminex/css/style-responsive.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="{{ asset('/static/adminex/js/html5shiv.js') }}"></script>
    <script src="{{ asset('/static/adminex/js/respond.min.js') }}"></script>
    <![endif]-->
    @section('style')

    @show
    <style>

        #user_id .value{
            font-size: 35px;
            margin-top: 24px;
            height:100%;
        }
        #user_id .title{
            font-size: 30px;
            margin-top: 38px;
            height:100%;
        }
        #user_id .symbol
        {
            float: left;
            margin-top: 35px;
        }
    </style>
</head>

<body class="sticky-header">

<section>
    @include('sidebar')

    <!-- main content start-->
    <div class="main-content" style="padding: 30px;overflow: hidden">

        <!-- header section start-->
        <div class="header-section">

            <!--toggle button start-->
            <a class="toggle-btn"><i class="fa fa-bars"></i></a>
            <!--toggle button end-->

            <!--search start-->
            <h4 class="col-lg-4" style="margin-top: 15px;">@yield('title')</h4>
            <!--notification menu start -->
            <div class="menu-right">

            </div>
            <!--notification menu end -->

        </div>
        <!-- header section end-->

        <!--body wrapper stsr-->
    @section('content')

    @show
    <!--body wrapper end-->

    <!--footer section start-->
    <footer>
        Copyright © 2015 - 2017 startce. All Rights Reserved <script src="https://s19.cnzz.com/z_stat.php?id=1263749482&web_id=1263749482" language="JavaScript"></script>
    </footer>
    <!--footer section end-->


    </div>
    <!-- main content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="{{ asset('/static/adminex/js/jquery-1.10.2.min.js') }}"></script>
<script src="{{ asset('/static/adminex/js/jquery-ui-1.9.2.custom.min.js') }}"></script>
<script src="{{ asset('/static/adminex/js/jquery-migrate-1.2.1.min.js') }}"></script>
<script src="{{ asset('/static/adminex/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/static/adminex/js/modernizr.min.js') }}"></script>
<script src="{{ asset('/static/adminex/js/jquery.nicescroll.js') }}"></script>

{{--<!--easy pie chart-->--}}
{{--<script src="{{ asset('/static/adminex/js/easypiechart/jquery.easypiechart.js') }}"></script>--}}
{{--<script src="{{ asset('/static/adminex/js/easypiechart/easypiechart-init.js') }}"></script>--}}

{{--<!--Sparkline Chart-->--}}
{{--<script src="{{ asset('/static/adminex/js/sparkline/jquery.sparkline.js') }}"></script>--}}
{{--<script src="{{ asset('/static/adminex/js/sparkline/sparkline-init.js') }}"></script>--}}

{{--<!--icheck -->--}}
{{--<script src="{{ asset('/static/adminex/js/iCheck/jquery.icheck.js') }}"></script>--}}
{{--<script src="{{ asset('/static/adminex/js/icheck-init.js') }}"></script>--}}

{{--<!-- jQuery Flot Chart-->--}}
{{--<script src="{{ asset('/static/adminex/js/flot-chart/jquery.flot.js') }}"></script>--}}
{{--<script src="{{ asset('/static/adminex/js/flot-chart/jquery.flot.tooltip.js') }}"></script>--}}
{{--<script src="{{ asset('/static/adminex/js/flot-chart/jquery.flot.resize.js') }}"></script>--}}

{{--<!--Morris Chart-->--}}
{{--<script src="{{ asset('/static/adminex/js/morris-chart/morris.js') }}"></script>--}}
{{--<script src="{{ asset('/static/adminex/js/morris-chart/raphael-min.js') }}"></script>--}}

{{--<!--Calendar-->--}}
{{--<script src="{{ asset('/static/adminex/js/calendar/clndr.js') }}"></script>--}}
{{--<script src="{{ asset('/static/adminex/js/calendar/evnt.calendar.init.js') }}"></script>--}}
{{--<script src="{{ asset('/static/adminex/js/calendar/moment-2.2.1.js') }}"></script>--}}
{{--<script src="{{ asset('/static/adminex/js/underscore-min.js') }}"></script>--}}

<!--common scripts for all pages-->
<script src="{{ asset('/static/adminex/js/scripts.js') }}"></script>

{{--<!--Dashboard Charts-->--}}
{{--<script src="{{ asset('/static/adminex/js/dashboard-chart-init.js') }}"></script>--}}

<script src="{{ asset('/js/ajax.js') }}"></script>

@section('script')

@show

</body>
</html>
