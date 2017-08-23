/**
 * Created by zxj on 17-8-19.
 */

/**
 * ataStatistics页面获取user表总统计数据
 * post
 *
 * @param count
 */
function dataStatistics_ajax(route, count) {
    $.ajax({
        type: "post",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data: {type:1},
        url: route,
        dataType: "json",
        success: function (data) {

            if (count === 0) {
                time = 500;
                min = parseInt(data.TRADE_VOL) - 1000;
                max = parseInt(data.TRADE_VOL);
            } else {
                time = 9000;
                max = parseInt(data.TRADE_VOL);
            }

            // console.log(time);
            // console.log(min);
            // console.log(max);

            if (min != max) {
                //清空之前数据
                $('.dataStatistics .digit_set').each(function () {
                    $(this).html('');
                });

                //添加数字
                $('.dataStatistics').dataStatistics({min:min,max:max,time:time,len:9});
            }

            min = parseInt(data.TRADE_VOL);

            //计数器加1
            $('#dataStatistics_count').html(++count);

            return min;
        }
    });
}

/**
 * 首页获取user表总统计数据
 *
 * @param route
 */
function index_user(route) {
    $.ajax({
        type: "post",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data: {type:2},
        url: route,
        dataType: "json",
        success: function (data) {
            $('#user_cnt').html(data.USER_CNT);
            $('#user_margin').html('$ '+parseFloat(data.MARGIN).toFixed(2));
            $('#user_trade_cnt').html(data.TRADE_CNT);
            $('#user_equity').html('$ '+parseFloat(data.EQUITY).toFixed(2));
            $('#user_balance').html('$ '+parseFloat(data.BALANCE).toFixed(2));
            // $('#user_trade_vol').html(data.TRADE_VOL);
        }
    });
}

/**
 * 实时订单
 *
 * @param route
 */
function index_trades(route) {
    $.ajax({
        type: "post",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        url: route,
        dataType: "json",
        success: function (data) {

            id = $('#index_trades');
            html = '';

            for (i=0; i<10; i++) {

                if (data[i].CMD == 1) {
                    data[i].CMD = '多';
                } else {
                    data[i].CMD = '空';
                }

                html += "<tr style='display: none'>"+
                    "<td>"+data[i].LOGIN+"</td>"+
                    "<td>"+data[i].TICKET+"</td>"+
                    "<td>"+data[i].SYMBOL+"</td>"+
                    "<td>"+data[i].VOLUME/100+"</td>"+
                    "<td>"+data[i].CMD+"</td>"+
                    "<td>"+data[i].OPEN_TIME+"</td>"+
                    "<td>"+parseFloat(data[i].OPEN_PRICE).toFixed(2)+"</td>"+
                    "</tr>";
            }

            id.html(html);
            id.children('tr').fadeIn();
        }
    });
}

/**
 * 货币对持仓多空力量对比
 *
 * @param num
 * @param route
 */
function holdingsymbol_ajax(num, route) {
    $.ajax({
        type: "post",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        url: route,
        dataType: "json",
        success: function (data) {
            console.log(data);
            Morris.Donut({
                element: 'graph-donut-' + num,
                data: [
                    {value: data[0].value, label: '空', formatted: data[0].value + '%' },
                    {value: data[1].value, label: '多', formatted: data[1].value + '%' }
                ],
                backgroundColor: false,
                labelColor: '#fff',
                colors: [
                    '#4acacb','#6a8bc0'
                ],
                formatter: function (x, data) { return data.formatted; }
            });

            $('#holding_symbol_' + num).find('#btnGroupDrop1_span').html(data.symbol);
        }
    });
}



/**
 * 分布图 图表ajax
 *
 * @param grouping
 */
function holding_cost_chart_ajax(route){

    $.ajax({
        url: route,
        type: 'GET',
        dataType:'json',
        success:function(result){
            $.each(result,function(k, v){

                var count = v.length;

                //数组不为空
                if (count != 0) {

                    var char_name = echarts.init(document.getElementById('bar-ECharts-js' + k));
                    var max = 1;
                    var x = [];
                    var y = [];
                    var num = parseInt(count/4);

                    y = [];

                    x = [];

                    $.each(v, function (a, b) {

                        x.push(parseFloat(b.VOLUME).toFixed(2));

                        if (max%num == 0 || max == 1) {
                            console.log(a+":" + b.PRICE);
                            y.push(parseFloat(b.PRICE).toFixed(2));
                        } else {
                            y.push('');
                        }

                        max++;
                    });

                    genenal.yAxis = [{
                        type: 'category',
                        data: y,
                        splitNumber: 5,
                        axisLabel: {
                            interval: 0,
                            rotate: 30
                        },
                        splitLine: {
                            show: false
                        }
                    }];

                    genenal.series = [{
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
                        data: x
                    }];

                    char_name.setOption(genenal);

                    $('#holding_cost_' + k).removeClass('hidden');

                    return true;
                }

                //数组为空，隐藏该栏目
                $('#holding_cost_' + k).addClass('hidden');

            });
        }
    });
}

