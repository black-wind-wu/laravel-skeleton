<footer class="footer">
    <div class="container d-flex">
        <div class="d-none d-md-block px-2 align-self-center"><!-- 左侧 -->
            <a href="{{ url('/') }}" target="_blank"><img src="{{asset('img/logo.png')}}" width="64" height="64"></a>
        </div>
        <div class="d-flex flex-row flex-md-column"><!-- 中间 -->
            <ul class="d-none d-md-block list-inline mb-1">
                <li class="list-inline-item"><a href="{{route('page.about')}}">关于我们</a></li>
                <li class="list-inline-item"><a href="{{route('page.contact')}}">联系我们</a></li>
                <li class="list-inline-item"><a href="{{route('page.terms')}}">服务条款</a></li>
                <li class="list-inline-item"><a href="{{route('page.copyright')}}">法律声明</a></li>
                <li class="list-inline-item"><a href="{{route('page.adm')}}">广告服务</a></li>
                <li class="list-inline-item"><a href="{{route('page.delete')}}">侵删通道</a></li>
                <li class="list-inline-item"><a href="{{url('/sitemap.xml')}}">站点地图</a></li>
            </ul>
            <div class="copyright mb-1">
                Copyright © {{ gmdate('Y') }} <a href="{{ config('app.url') }}">{{ config('app.name', 'Laravel') }}</a>.
            </div>
            <div class="beian mb-1">
                <a href="https://beian.miit.gov.cn" target="_blank">{{settings('system.icp_record')}}</a>
                <a href="https://www.beian.gov.cn/" target="_blank">{{settings('system.police_record')}}</a>
                <!-- 统计代码 -->
            </div>
        </div>
        <div class="d-none d-lg-block p-2 ml-auto align-self-center"><!--  右侧 -->
            <img src="{{asset('img/wx_qrcode_430.jpg')}}" width="64" height="64">
        </div>
    </div>
</footer>
