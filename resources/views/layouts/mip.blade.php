<!DOCTYPE html>
<html mip>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://c.mipcdn.com/static/v2/mip.css">
    <style mip-custom>
        html{background:#0a89c0}
        body{background:#fff;color:#353535;font-family:-apple-system,BlinkMacSystemFont,"Helvetica Neue","PingFang SC","Microsoft YaHei","Source Han Sans SC","Noto Sans CJK SC","WenQuanYi Micro Hei",sans-serif;font-weight:400;line-height:1.75em}
        figure,ol,p,ul{margin:0 0 1em;padding:0}
        a,a:visited{color:#0a89c0}a:active,a:focus,a:hover{color:#353535}blockquote{color:#353535;background:rgba(127,127,127,.125);border-left:2px solid #0a89c0;margin:8px 0 24px 0;padding:16px}
        blockquote p:last-child{margin-bottom:0}
        .mip-header{background-color:#0a89c0}
        .mip-header div{color:#fff;font-size:1em;font-weight:400;margin:0 auto;max-width:calc(840px - 32px);padding:.875em 16px;position:relative}
        .mip-header a{color:#fff;text-decoration:none}
        .mip-article{color:#353535;font-weight:400;margin:1.5em auto;max-width:840px;overflow-wrap:break-word;word-wrap:break-word}
        .mip-article-header{align-items:center;align-content:stretch;display:flex;flex-wrap:wrap;justify-content:space-between;margin:1.5em 16px 0}
        .mip-title{color:#353535;display:block;flex:1 0 100%;font-weight:900;margin:0 0 .625em;width:100%}
        .mip-meta{color:#696969;display:inline-block;flex:2 1 50%;font-size:.875em;line-height:1.5em;margin:0 0 1.5em;padding:0}
        .mip-article-header .mip-meta:last-of-type{text-align:right}
        .mip-article-header .mip-meta:first-of-type{text-align:left}
        .mip-byline .mip-author,.mip-byline mip-img{display:inline-block;vertical-align:middle}
        .mip-byline mip-img{border:1px solid #0a89c0;border-radius:50%;position:relative;margin-right:6px}
        .mip-posted-on{text-align:right}
        .mip-article-content{margin:0 16px}
        .mip-article-content ol,.mip-article-content ul{margin-left:1em}
        .mip-article-content .caption{max-width:100%}
        .mip-article-content mip-img{margin:0 auto}
        .mip-article-footer .mip-meta{display:block}
        .caption{padding:0}
        .mip-tax-category{color:#696969;font-size:.875em;line-height:1.5em;margin:1.5em 16px}
        .mip-footer{border-top:1px solid #c2c2c2;margin:calc(1.5em - 1px) 0 0}
        .mip-footer div{margin:0 auto;max-width:calc(840px - 32px);padding:1.25em 16px 1.25em;position:relative}
        .mip-footer h2{font-size:1em;line-height:1.375em;margin:0 0 .5em}
        .mip-footer p{color:#696969;font-size:.8em;line-height:1.5em;margin:0 85px 0 0}
        .mip-footer a{text-decoration:none}.back-to-top{bottom:1.275em;font-size:.8em;font-weight:600;line-height:2em;position:absolute;right:16px}
    </style>
    @stack('head')
</head>
<body>
<header id="top" class="mip-header">
    <div>
        <a href="{{ url('/') }}">
            <span class="mip-site-title">{{ config('app.name', 'Laravel') }}</span>
        </a>
    </div>
</header>

@yield('content')
<footer class="mip-footer">
    <div>
        <h2>{{ config('app.name', 'Laravel') }}</h2>
        <a href="#top" class="back-to-top">Back to top</a>
    </div>
</footer>
<script src="https://c.mipcdn.com/static/v2/mip.js" async="async"></script>
</body>
</html>


