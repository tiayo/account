<meta name="_token" content="{{ csrf_token() }}"/>
<link rel="stylesheet" href="/dataStatistics/style/style.css" media="screen" type="text/css" />

<div class="dataStatistics">
    <div class="digit_set"></div>
    <div class="digit_set"></div>
    <div class="digit_set"></div>
    <div class="digit_set"></div>
    <div class="digit_set"></div>
    <div class="digit_set"></div>
    <div class="digit_set"></div>
    <div class="digit_set"></div>
    <div class="digit_set set_last"></div>
    <div style="display: none" id="dataStatistics_count">0</div>
</div>

<script src='{{ asset('/dataStatistics/js/jquery.js') }}'></script>
<script src="{{ asset('/dataStatistics/js/jquery.dataStatistics.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        //页面打开即执行
        setTimeout("dataStatistics_ajax('{{ route('user') }}', parseInt($('#dataStatistics_count').html()))");

        //定时执行
        setInterval("dataStatistics_ajax('{{ route('user') }}', parseInt($('#dataStatistics_count').html()))", 10000);
    });
</script>