    <div class="left-side sticky-left-side">
        <div class="logo">
            <a href="/"><img src="{{ asset('images/logo_2.png') }}" width="188px"></a>
        </div>
        <div class="left-side-inner" style="margin-top: 6em;">
            <!--sidebar nav start-->
            <ul class="nav nav-pills nav-stacked custom-nav">
                <li class=""><a href="/"><i class="fa fa-home"></i> <span>全局监控</span></a></li>
                <li class=""><a href="{{ route('holdingsymbol_view') }}"><i class="fa fa-laptop"></i> <span>多空力量对比</span></a></li>
                <li class=""><a href="{{ route('holdingcost_view') }}"><i class="fa fa-book"></i> <span>成本、止损、止盈分布</span></a>
                <li class=""><a href="{{ route('ranking_list') }}"><i class="fa fa-book"></i> <span>排行榜</span></a>
                </li>
            </ul>
            <!--sidebar nav end-->
        </div>
    </div>