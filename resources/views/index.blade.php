@extends('app')

@section('title', '全局监控')

@section('style')
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
@endsection

@section('content')
        <!--body wrapper start-->
        <div class="wrapper" style="margin-top: 2em;" id="user_id">
            <div class="row">
                    <!--statistics start-->
                <div class="row state-overview">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="panel deep-purple-box" style="padding: 0;overflow: hidden">
                            <div class="symbol" style="padding: 34px 0 0 29px;">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="state-value">
                                <div class="value">
                                    <iframe id="iframe" src="{{ route('dataStatistics') }}" frameborder="0" width="100%" style="margin-top: -49px;margin-left: -72px;" scrolling="no"></iframe>
                                </div>
                                <div class="title" style="margin:0 0 27px 0">净值</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="panel blue">
                            <div class="symbol">
                                <i class="fa fa-legal"></i>
                            </div>
                            <div class="state-value">
                                <div class="value" id="user_trade_cnt"></div>
                                <div class="title">交易次数</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="panel green">
                            <div class="symbol">
                                <i class="fa fa-eye"></i>
                            </div>
                            <div class="state-value">
                                <div class="value" id="user_balance"></div>
                                <div class="title">余额</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="panel purple">
                            <div class="symbol">
                                <i class="fa fa-eye"></i>
                            </div>
                            <div class="state-value">
                                <div class="value" id="user_trade_vol"></div>
                                <div class="title">总交易量</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="panel purple">
                            <div class="symbol">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="state-value">
                                <div class="value" id="user_cnt"></div>
                                <div class="title">会员总数</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="panel red">
                            <div class="symbol">
                                <i class="fa fa-money"></i>
                            </div>
                            <div class="state-value">
                                <div class="value" id="user_margin"></div>
                                <div class="title">保证金</div>
                            </div>
                        </div>
                    </div>
                </div>

                </div>
            </div>
            <!--statistics end-->
        <div class="row">
            {{--实时订单开始--}}
            @include('trade')
            {{--实时订单结束--}}
        </div>
    <!--body wrapper end-->
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            index_user('{{ route('user') }}');
            index_trades('{{ route('trades') }}');

            setInterval("index_user('{{ route('user') }}')", 10000);
            setInterval("index_trades('{{ route('trades') }}')", 10000);
        })
    </script>
@endsection

