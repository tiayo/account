@extends('app')

@section('title', '盘口')

@section('content')
    <!--body wrapper start-->
    <div class="wrapper" style="margin-top: 2em;">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading no-border">
                        盘口列表
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>分组</th>
                                <th>方向</th>
                                <th>手数</th>
                                <th>开/平仓</th>
                                <th>开/平仓价格</th>
                            </tr>
                            </thead>
                            <tbody id="tbody_1">
                                @foreach($trades as $trade)
                                    <tr>
                                        <td>{{ $trade['id'] }}</td>
                                        <td>{{ $trade['SYMBOL'] }}</td>
                                        <td>
                                            @if($trade['CMD'] == 0)
                                                多投
                                                @else
                                                空投
                                            @endif
                                        </td>
                                        <td>{{ number_format($trade['VOLUME'] / 100, 2) }}</td>
                                        <td>
                                            @if($trade['type'] == 0)
                                                开仓
                                            @else
                                                平仓
                                            @endif
                                        </td>
                                        <td>
                                            @if($trade['type'] == 0)
                                                开仓价：{{ $trade['OPEN_PRICE'] }}
                                            @else
                                                平仓价：{{ $trade['CLOSE_PRICE'] }}
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
    <!--body wrapper end-->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            ToggleConnectionClicked();
        });

        var ws;

        function ToggleConnectionClicked() {
            try {
                //连接服务器
                ws = new WebSocket("ws://192.168.1.253:9898");

                //连接成功
                ws.onopen = function(event){console.log("已经与服务器建立了连接\r\n当前连接状态："+this.readyState);};

                //接收数据
                ws.onmessage = function(event){
                    console.log(event.data);
                    insert(event.data);
                };

                //断开连接
                ws.onclose = function(event){console.log("已经与服务器断开连接\r\n当前连接状态："+this.readyState);};

                //异常
                ws.onerror = function(event){console.log("WebSocket异常！");};
            } catch (ex) {
                console.log(ex.message);
            }
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

            data  = eval('('+data+')');

            var html  = '<tr>' +
                '<td>'+data.id+'</td>' +
                '<td>'+data.symbol+'</td>';

            if (data.cmd === 0) {
                html += '<td>多投</td>';
            } else {
                html += '<td>空投</td>';
            }

            html += '<td>'+ (parseFloat(data.volume) / 100).toFixed(2) +'</td>';

            if (data.type === 0) {
                html += '<td>开仓</td>';
                html += '<td>开仓价：'+data.open_price+'</td>';
            } else {
                html += '<td>平仓</td>';
                html += '<td>平仓价：'+data.close_price+'</td>';
            }

            html += '</tr>';

            return html;
        }
    </script>
@endsection