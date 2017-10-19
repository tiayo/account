@extends('app')

@section('title', '盘口')

@section('content')
    <!--body wrapper start-->
    <div class="wrapper" style="margin-top: 2em;">
        <div class="row">
            <div class="col-sm-6">
                <section class="panel">
                    <header class="panel-heading no-border">
                        盘口列表
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>

                    <div class="panel-body">
                        <form class="form-inline"role="form">
                            <div class="form-group">
                                <input type="text" id="subscribe_symbol" class="form-control" placeholder="请输入正确的品种组">
                            </div>
                            <div class="form-group">
                                <input type="number" id="subscribe_volume" class="form-control" placeholder="输入手数起点">
                            </div>
                            <button type="button" id="subscribe_from" class="btn btn-primary">确认筛选</button>
                        </form>
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>交易品种</th>
                                <th>开平</th>
                                <th>手数</th>
                                <th>价格</th>
                                <th>交易时间</th>
                            </tr>
                            </thead>
                            <tbody id="tbody_1">
                                @foreach($trades as $trade)
                                    <tr style="color: @if ($trade['type'] == $trade['CMD']) red @else green @endif">
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
                                        <td>{{ $trade['update_time'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!--body wrapper end-->
@endsection

@section('script')
    <script type="text/javascript">
        //加载完毕即加载
        $(document).ready(function () {
            ToggleConnectionClicked();

            $('#subscribe_from').click(function () {
                send_subscribe();
            });
        });

        var ws;

        //连接WebSocket
        function ToggleConnectionClicked() {
            try {
                //连接服务器
                ws = new WebSocket("ws://192.168.1.253:9898");

                //连接成功
                ws.onopen = function(event){console.log("已经与服务器建立了连接\r\n当前连接状态："+this.readyState);};

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
                            alert('筛选订阅成功！');
                        } else {
                            alert('失败:' + data.result_msg);
                        }
                    }

                    if (data.msg_type === 10) {
                        insert(data);
                    }
                };

                //断开连接
                ws.onclose = function(event){console.log("已经与服务器断开连接\r\n当前连接状态："+this.readyState);};

                //异常
                ws.onerror = function(event){console.log("WebSocket异常！");};
            } catch (ex) {
                console.log(ex.message);
            }
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
                	  alert(errorThrown);
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

            html += '<td>'+data.update_time+'</td>'+
                '</tr>';

            return html;
        }
    </script>
@endsection