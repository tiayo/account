@extends('app')

@section('title', '排行榜')

@section('content')
        <!--body wrapper start-->
        <div class="wrapper" style="margin-top: 2em;">
            <div class="row">
                @foreach($all_win_rate as $key => $win_rate_ch)
                <div class="col-sm-6">
                    <section class="panel">
                        <header class="panel-heading no-border">
                            @if($key == 'info')胜率@else败率@endif排行榜
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>mt4账号</th>
                                    <th>姓名</th>
                                    <th>交易总数</th>
                                    <th>胜率</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($win_rate_ch as $win_rate)
                                <tr>
                                    <td>{{ $win_rate['LOGIN'] }}</td>
                                    <td>{{ $win_rate['NAME'] }}</td>
                                    <td>{{ $win_rate['TRADE_CNT'] }}</td>
                                    <td>{{ $win_rate['WIN_RATE'] }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                @endforeach

                @foreach($all_follow as $key => $all_follow_ch)
                    <div class="col-sm-6">
                        <section class="panel">
                            <header class="panel-heading no-border">
                                @if($key == 'info')高手@else反指@endif排行榜
                                <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                            </header>
                            <div class="panel-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>mt4账号</th>
                                        <th>姓名</th>
                                        <th>平均收益率</th>
                                        <th>总收益率</th>
                                        <th>交易量</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($all_follow_ch as $follow)
                                        <tr>
                                            <td>{{ $follow['LOGIN'] }}</td>
                                            <td>{{ $follow['NAME'] }}</td>
                                            <td>{{ number_format($follow['PROFIT_AVG'], 2) }}</td>
                                            <td>{{ $follow['PROFIT_SUM'] }}</td>
                                            <td>{{ $follow['TRADE_CNT'] }}</td>
                                            <td>
                                                <button class="btn btn-info" type="button">查看历史盈亏</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                @endforeach
            </div>
        </div>
        <!--body wrapper end-->
@endsection

@section('script')

@endsection