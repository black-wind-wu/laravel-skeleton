<div class="side_box mb-3">
    <div class="box-header">
        <div class="box-title">赞助链接</div>
    </div>
</div>

<div class="side_box mb-3">
    <div class="box-body">
        <div class="wx_qrcode">
            <img src="{{asset('img/wx_qrcode_430.jpg')}}" alt="{{ config('app.name', 'Larva') }}微信公众号">
            关注微信公众号<br>
            随时掌握互联网精彩
        </div>
    </div>
</div>

<div class="side_box mb-3">
    <div class="box-body">
        <x-widgets.ads id="1"/>
    </div>
</div>

<x-widgets.latest-news/>

<div class="side_box mb-3">
    <x-widgets.ads id="2"/>
</div>
