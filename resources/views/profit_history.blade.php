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
                                        <div id="main_chart_container" class="main-chart" style="height: 650px;">
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
    <script src="{{ asset('/js/echarts.js') }}"> </script>
    <script src="{{ asset('/js/ajax.js') }}"> </script>
    <script>

        data = [];
        var y = [];
        var x = [];

        $.ajax({
            type: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            url: "{{ route('profit_history', ['login' => 88020633]) }}",
            dataType: "json",
            success: function (result) {
                i = 0;
                $.each(result, function (key, item) {
                    data.push(item);
                    y[i] = item['value'][1];
                    x[i] = item['value'][0];
                    i++;
                });
                console.log(x);
                chart();
            }
        });

        function chart() {

            var char_name = echarts.init(document.getElementById('main_chart_container'));

            option = {
                dataZoom: [
                    {
                        type: 'slider',
                        show: false,
                        start: 0,
                        end: 100,
                        handleSize: 8
                    },
                    {
                        type: 'inside',
                        start: 0,
                        end: 100
                    },
                    {
                        type: 'slider',
                        show: false,
                        yAxisIndex: 0,
                        filterMode: 'empty',
                        width: 12,
                        height: '70%',
                        handleSize: 8,
                        showDataShadow: false,
                        left: '93%'
                    }
                ],
                title: {

                },
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        animation: false
                    }
                },
                xAxis: {
                    type: 'category',
                    data: x,
                    splitLine: {
                        show: false
                    }
                },
                yAxis: {
                    type: 'category',
                    data: y,
                    boundaryGap: [0, '100%'],
                    splitLine: {
                        show: false
                    }
                },
                series: [{
                    name: '盈亏曲线',
                    type: 'line',
                    showSymbol: false,
                    hoverAnimation: false,
                    data: data
                }]
            };

            char_name.setOption(option);
        }

    </script>
@endsection