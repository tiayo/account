@extends('app')

@section('title', '高手历史盈亏曲线图')

@section('content')
        <!--body wrapper start-->
        <div class="wrapper" style="margin-top: 2em;">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <h4>高手:{{ $login }}</h4>
                    </div>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="clearfix">
                                        <div id="main-chart-legend" class="pull-right">
                                        </div>
                                    </div>

                                    <div id="main-chart">
                                        <div id="main-chart-container" class="main-chart" style="height: 650px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--body wrapper end-->
@endsection

@section('script')
    <!-- jQuery Flot Chart-->
    <script src="{{ asset('/static/adminex/js/flot-chart/jquery.flot.js') }}"></script>
    <script src="{{ asset('/static/adminex/js/flot-chart/jquery.flot.tooltip.js') }}"></script>
    <script src="{{ asset('/static/adminex/js/flot-chart/jquery.flot.resize.js') }}"></script>
    <script>
        $(function() {

            var d1 = {!! $data !!};

            var data = ([{
                label: "收益率",
                data: d1,
                lines: {
                    show: true,
                    fill: true,
                    fillColor: {
                        colors: ["rgba(255,255,255,.4)", "rgba(183,236,240,.4)"]
                    }
                }
            },
            ]);

            var options = {
                grid: {
                    backgroundColor:
                        {
                            colors: ["#ffffff", "#f4f4f6"]
                        },
                    hoverable: true,
                    clickable: true,
                    tickColor: "#eeeeee",
                    borderWidth: 1,
                    borderColor: "#eeeeee"
                },
                // Tooltip
                tooltip: true,
                tooltipOpts: {
                    content: "%s X: %x Y: %y",
                    shifts: {
                        x: -60,
                        y: 25
                    },
                    defaultTheme: false
                },
                legend: {
                    labelBoxBorderColor: "#000000",
                    container: $("#main-chart-legend"), //remove to show in the chart
                    noColumns: 0
                },
                series: {
                    stack: true,
                    shadowSize: 0,
                    highlightColor: 'rgba(000,000,000,.2)'
                },
                points: {
                    show: true,
                    radius: 1,
                    symbol: "circle"
                },
                colors: ["#5abcdf", "#ff8673"]
            };
            var plot = $.plot($("#main-chart #main-chart-container"), data, options);
        });
    </script>
@endsection