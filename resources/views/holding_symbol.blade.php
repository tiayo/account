@extends('app')

@section('title', '持仓多空力量对比')

@section('content')
        <!--body wrapper start-->
        <div class="wrapper" style="margin-top: 2em;">
            <div class="row">
                @for($i=1;$i<=$count;$i++)
                    <div class="col-md-6" id="holding_symbol_{{ $i }}">
                        <!--more statistics box start-->
                        <div class="panel deep-purple-box">
                            <header class="panel-heading" style="color:white;">
                                品种组：{{ $init_array[$i]['symbol'] }}
                            </header>
                            <div class="panel-body">
                                <div class="col-md-4  pull-left row">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" id="btnGroupDrop1">
                                            <span id="btnGroupDrop1_span">选择品种组</span>
                                            <span class="caret"></span>
                                        </button>
                                        <ul aria-labelledby="btnGroupDrop1" role="menu" class="dropdown-menu" id="dropdown-menu">
                                            @foreach($symbols as $symbol)
                                                <li><a onclick="symbol_click({{ $i }}, '{{ $symbol['SYMBOL'] }}')">{{ $symbol['SYMBOL'] }}</a> </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-8  pull-right row">
                                    <div class="col-md-7 col-sm-7 col-xs-7">
                                        <div id="graph-donut-{{ $i }}" class="revenue-graph"></div>

                                    </div>
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <ul class="bar-legend">
                                            <li><span class="purple"></span>空</li>
                                            <li><span class="green"></span>多</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--more statistics box end-->
                    </div>
                @endfor
             </div>
        <!--body wrapper end-->
        </div>
@endsection

@section('script')
    <!--Morris Chart-->
    <script src="{{ asset('/static/adminex/js/morris-chart/morris.js') }}"></script>
    <script src="{{ asset('/static/adminex/js/morris-chart/raphael-min.js') }}"></script>

    <script>

        $(document).ready(function () {

            var init_value = {!! $init_value !!};

            for (i=1; i<={{ $count }}; i++) {
                console.log(init_value);
                Morris.Donut({
                    element: 'graph-donut-' + i,
                    data: [
                        {value: init_value[i][0].value, label: '多', formatted: init_value[i][0].value + '%' },
                        {value: init_value[i][1].value, label: '空', formatted: init_value[i][1].value + '%' }
                    ],
                    backgroundColor: false,
                    labelColor: '#fff',
                    colors: [
                        '#4acacb','#6a8bc0','#5ab6df','#fe8676'
                    ],
                    formatter: function (x, data) { return data.formatted; }
                });
            }
        });


        function symbol_click(num, symbol) {
            holdingsymbol_ajax(num, "{{ route('holdingsymbol_value', [ 'symbol' => null]) }}" + "/" + symbol);
            $('#holding_symbol_'+num).find(".panel-heading").html("品种组："+symbol);
        }

    </script>
@endsection