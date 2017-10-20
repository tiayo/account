@extends('app')

@section('title', '盘口')

@section('style')
    <link href="{{ asset('/static/adminex/js/c3-chart/c3.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    <!--body wrapper start-->
    <div class="wrapper" style="margin-top: 2em;">
        <div class="row">
            <div class="col-sm-6">
                <section class="panel">
                    <header class="panel-heading">
                        盘口统计-多头
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <label class="control-label" style="float: left">大单</label>
                            <div class="progress progress-striped active progress-sm col-md-9">
                                <div id="account_0_3" aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-success"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="control-label" style="float: left">中单</label>
                            <div class="progress progress-striped active progress-sm col-md-9">
                                <div id="account_0_2" aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-info"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="control-label" style="float: left">小单</label>
                            <div class="progress progress-striped active progress-sm col-md-9">
                                <div id="account_0_1" aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-danger"></div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="panel">
                    <header class="panel-heading">
                        盘口统计-空头
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <label class="control-label" style="float: left">大单</label>
                            <div class="progress progress-striped active progress-sm col-md-9">
                                <div id="account_1_3" aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-success"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="control-label" style="float: left">中单</label>
                            <div class="progress progress-striped active progress-sm col-md-9">
                                <div id="account_1_2" aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-info"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="control-label" style="float: left">小单</label>
                            <div class="progress progress-striped active progress-sm col-md-9">
                                <div id="account_1_1" aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-danger"></div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="panel">
                    <header class="panel-heading">
                        自定义盘口统计
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                        <form class="form-inline" role="form" id="account_form">
                            <div class="form-group">
                                <div class="col-md-3">
                                    <input type="text" name="account_min" class="form-control"
                                           placeholder="输入小单小于手数，如：1">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-3">
                                    <input type="number" name="account_max" class="form-control"
                                           placeholder="输入大单大于手数，如：10">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-3">
                                    <input type="number" name="account_before" class="form-control"
                                           placeholder="几小时前，如：1">
                                </div>
                            </div>

                            <div class="form-group" style="margin-top: 1em">
                                <div class="col-md-3">
                                    <button type="button" id="account_submit" class="btn btn-primary">确认调整</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>

            <div class="col-md-6">
                <section class="panel">
                    <header class="panel-heading no-border">
                        盘口列表
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                        <form class="form-inline" role="form">
                            <div class="form-group">
                                <div class="col-md-3">
                                    <input type="text" id="subscribe_symbol" class="form-control"
                                           placeholder="输入交易品种，如：USDJPY">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-3">
                                    <input type="number" id="subscribe_volume" class="form-control"
                                           placeholder="手数大于值，如：0">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-10">
                                    <button type="button" id="subscribe_from" class="btn btn-primary">确认筛选</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>交易时间</th>
                                <th>交易品种</th>
                                <th>开平</th>
                                <th>手数</th>
                                <th>价格</th>
                            </tr>
                            </thead>
                            <tbody id="tbody_1">
                                @foreach($trades as $trade)
                                    <tr style="color: @if ($trade['type'] == $trade['CMD']) red @else green @endif">
                                        <td>{{ $trade['update_time'] }}</td>
                                        <td>{{ $trade['SYMBOL'] }}</td>
                                        <td>
                                            @php
                                                if($trade['type'] == 0){
                                                    $str = '开';
                                                }  else {
                                                    $str = '平';
                                                }

                                                if($trade['CMD'] == 0) {
                                                    $str .= '多';
                                                } else {
                                                    $str .= '空';
                                                }

                                                echo htmlspecialchars($str, ENT_QUOTES);
                                            @endphp
                                        </td>
                                        <td>{{ number_format($trade['VOLUME'] / 100, 2) }}</td>
                                        <td>
                                            @if($trade['type'] == 0)
                                                {{ $trade['OPEN_PRICE'] }}
                                            @else
                                                {{ $trade['CLOSE_PRICE'] }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <input type="hidden" value="0" id="jishuqi">
    <!--body wrapper end-->
@endsection

@section('script')
    <script type="text/javascript">
        //加载完毕即加载
        $(document).ready(function () {
            ToggleConnectionClicked();

            setTimeout("account()", 10);
            setInterval("account()", 10000);

            $('#account_submit').click(function () {
                setTimeout("account()", 10);
            });

            $('#subscribe_from').click(function () {
                send_subscribe();
            });
        });

        //加载盘口统计
        function account() {
            $.ajax({
                type: "get",
                url: "{{ route('current_trade_account') }}",
                data: $('#account_form').serialize(),
                dataType: "json",
                success: function (account_data) {
                    var i = b = 0;

                    for (i=0; i<1; i++) {
                        for(b=1; b<=3; b++) {
                            $('#account_' + i + '_' + b).css("width", account_data[i][b] + "%");
                        }
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }

        var ws;

        //连接WebSocket
        function ToggleConnectionClicked() {
            try {
                //连接服务器
                ws = new WebSocket("ws://192.168.1.253:9898");

                //连接成功
                ws.onopen = function(event){
                    //计数器清0
                    $('#jishuqi').val(0);

                    console.log("已经与服务器建立了连接\r\n当前连接状态："+this.readyState);
                };

                //接收数据
                ws.onmessage = function(event){

                    //数据转为json
                    var data  = eval('('+event.data+')');

                    //验证或读取操作
                    console.log(data);

                    if (data.msg_type === 1) {
                        send_ws_secret(data.seed);
                    }

                    if (data.msg_type === 1003) {
                        if (data.result_code === 0) {
                            //筛选数据初始化（同步）
                            screen_init();
                        } else {
                            alert('筛选订阅失败:' + data.result_msg);
                        }
                    }

                    if (data.msg_type === 10) {
                        insert(data);
                    }
                };

                //断开连接
                ws.onclose = function(event){
                    console.log("已经与服务器断开连接\r\n当前连接状态："+this.readyState+"\r\n尝试重连中...");
                    var jishuqi = parseInt($('#jishuqi').val());

                    if (jishuqi < 20) {
                        $('#jishuqi').val(jishuqi + 1);
                        //重连
                        return setTimeout("ToggleConnectionClicked()", 3000);
                    }

                    console.log("重连超过"+jishuqi+"次，已断开！");
                };

                //异常
                ws.onerror = function(event){console.log("WebSocket异常！");};
            } catch (ex) {
                console.log(ex.message);
            }
        }

        //筛选初始化
        function screen_init() {
            $.ajax({
                type: "get",
                url: "{{ route('current_trade_get') }}?symbol=" + $('#subscribe_symbol').val() + '&volume=' + $('#subscribe_volume').val(),
                dataType: "json",
                async: false,
                success: function (screen_init_data) {
                    //全部清除
                    $('#tbody_1').children("tr").each(function () {
                        $(this).remove();
                    });

                    //重新逐条插入
                    $.each(screen_init_data, function(key, value) {
                        insert(value);
                    });
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }

        //发送信息筛选
        function send_subscribe() {
            var subscribe_symbol = $('#subscribe_symbol').val();
            var subscribe_volume = $('#subscribe_volume').val();
            var symbol_count = 1;

            if (subscribe_symbol === '') {
                subscribe_symbol = 0;
                symbol_count = 0;
            } else {
                subscribe_symbol = '["'+subscribe_symbol+'"]';
            }

            if (subscribe_volume === '') {
                subscribe_volume = 0;
            } else {
                subscribe_volume = subscribe_volume * 100;
            }

            console.log('{"msg_type":1002, "symbol_count":'+symbol_count+',"symbol":'+subscribe_symbol+',"volume":'+subscribe_volume+'}');

            ws.send('{"msg_type":1002, "symbol_count":'+symbol_count+',"symbol":'+subscribe_symbol+',"volume":'+subscribe_volume+'}');
        }

        //发送验证信息
        function send_ws_secret(str) {
            $.ajax({
                type: "get",
                url: "{{ route('ws_secret') }}?str=" + str,
                dataType: "json",
                success: function (data) {
                    ws.send(JSON.stringify(data));
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                	  console.log(errorThrown);
                }
            });
        }

        //插入页面
        function insert(data) {
            //生成html
            var html = htmlGenerate(data);

            var tbody_1 = $('#tbody_1');

            //插入
            tbody_1.prepend(html);

            //移除
            if (tbody_1.find('tr').length > 15) {
                tbody_1.children("tr:last-child").remove();
            }
        }

        //生成html
        function htmlGenerate(data) {

            var color = 'green';

            if (data.type === data.cmd) {
                color = 'red';
            }

            var html  = '<tr style="color: '+ color +'">' +
                '<td>'+data.update_time+'</td>'+
                '<td>'+data.symbol+'</td>';

            if (data.type === 0) {
                html += '<td>开';
            } else {
                html += '<td>平';
            }

            if (data.cmd === 0) {
                html += '多</td>';
            } else {
                html += '空</td>';
            }

            html += '<td>'+ (parseFloat(data.volume) / 100).toFixed(2) +'</td>';

            if (data.type === 0) {
                html += '<td>'+data.open_price+'</td>';
            } else {
                html += '<td>'+data.close_price+'</td>';
            }

            html += '</tr>';

            return html;
        }
    </script>
@endsection