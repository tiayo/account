@extends('app')

@section('title', '多空持仓成本、止损、止盈分布图')

@section('style')

@endsection

@section('content')
        <!-- /btn-group -->
        <div class="btn-group" style="margin:4em 0 0 15px;">
            <button data-toggle="dropdown" type="button" class="btn btn-info btn-sm dropdown-toggle" id="btnGroupDrop1">
            <b>{{ $symbols[0]['SYMBOL'] }}</b> <span class="caret"></span>
            </button>
            <ul aria-labelledby="btnGroupDrop1" role="menu" class="dropdown-menu" id="dropMenuUlLi">
                @foreach($symbols as $symbol)
                    <li><a onclick='active_symbol("{{ $symbol['SYMBOL'] }}")'>{{ $symbol['SYMBOL'] }}</a></li>
                @endforeach
            </ul>
        </div>
        <!-- /btn-group -->
        
        <!--body wrapper start-->
        <div class="wrapper">
            <div class="row">
                @for($i=0; $i <= 5; $i++)
                    <div class="col-sm-6" id="holding_cost_{{ $i }}">
                        <div class="panel">
                            <header class="panel-heading">
                                {{ $type[$i] }}
                                <span class="tools pull-right">
                                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                                    <a href="javascript:;" class="fa fa-times"></a>
                                 </span>
                            </header>
                            <div class="panel-body">
                                <div class="chartJS">
                                    <canvas id="bar-ECharts-js{{ $i }}" height="400" width="700" ></canvas>
                                </div>

                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
@endsection

@section('script')
<script src="{{ asset('/js/echarts.js') }}"> </script>
<script>
var waterMarkText = '星科技';

var canvas = document.createElement('canvas');
var ctx = canvas.getContext('2d');
canvas.width = canvas.height = 100;
ctx.textAlign = 'center';
ctx.textBaseline = 'middle';
ctx.globalAlpha = 0.08;
ctx.font = '20px Microsoft Yahei';
ctx.translate(50, 50);
ctx.rotate(-Math.PI / 4);
ctx.fillText(waterMarkText, 0, 0);

genenal = {
    backgroundColor: {
        type: 'pattern',
        image: canvas,
        repeat: 'repeat'
    },
    tooltip: {},
    title: [{
        // text: '在线构建',
        // subtext: '总计 ' + builderJson.all,
        x: '25%',
        textAlign: 'center'
    }],
    grid: [{
        top: 50,
        width: '93%',
        // bottom: '0',
        left: 10,
        containLabel: true
    }],
    xAxis: [{
        type: 'value',
        splitLine: {
            show: false
        }
    }],
    yAxis: [{
        type: 'category',
        data: [],
        splitNumber: 5,
        axisLabel: {
            interval: 0,
            rotate: 30
        },
        splitLine: {
            show: false
        }
    }],
    series: [{
        type: 'bar',
        stack: 'chart',
        barWidth:1,
        barCategoryGap:'1%',
        z: 3,
        label: {
            normal: {
                position: 'right',
                show: false
            }
        },
        data: []
    }]
};

$(document).ready(function () {
    //执行显示图表
    holding_cost_chart_ajax('{{ route('holdingcost_value', ['symbol' => $symbols[0]['SYMBOL']]) }}');
});

function active_symbol(group)
{
    $('canvas').html('');

    holding_cost_chart_ajax('{{ route('holdingcost_value', ['symbol' => '']) }}' + '/' + group);

    $('#btnGroupDrop1').find('b').html(group);
}
</script>
@endsection