@extends('layouts.app')

@section('title', __('Infringement Deletion'))

@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="d-none d-lg-block col-lg-2">
                @include('page._left')
            </div>
            <div class="d-block col-md-12 col-lg-10 bg-white">
                <div class="site-content">
                    <div class="entry-header">
                        <div class="entry-title">{{__('Infringement Deletion')}}</div>
                    </div>

                    <div class="entry-content">
                        <p>依照法律规定删除违法信息是{{ config('app.name', 'Laravel') }}团队的法定义务，当事方不需要委托第三方进行投诉，<strong
                                style="color: red;">此服务为免费服务，拉瓦科技未与任何中介机构合作开展此项业务，不接受任何付费删帖、亦未授权任何代理公司负责删帖，请勿轻信任何谣传谨防上当受骗！</strong>
                        </p>
                        <h6>受理范围</h6>
                        <p>{{ config('app.name', 'Laravel') }}侵删通道仅处理涉及泄露隐私、造谣、诽谤、严重人身攻击等删帖申请，除此之外一概不予受理。</p>
                        <p>① 泄露个人隐私：文章内容中直接涉及个人姓名、家庭住址、身份证号码、工作单位、私人电话等详细个人隐私；<br>
                            ② 造谣、诽谤、严重人身攻击：文章内容中指名道姓的直接谩骂、侮辱、虚构中伤、恶意诽谤等。
                        </p>
                        <p>无论出于何种目的要求本站删除内容，您均需要提供相关证明，否则不予处理；</p>

                        <h6>主体要求</h6>
                        <ol>
                            <li>无论是因我站侵权还是刊发内容可能影响到“您”的权益，所有删除、修改请求仅允许直接权利人申请；</li>
                            <li>您如果希望删除、修改内容，首先您必须是直接权利人且必须可以提供相关证明文件；</li>
                            <li>非直接权利人例如关联公司、朋友等，需持有直接权利人的授权证明；</li>
                        </ol>

                        <h6>处理流程</h6>
                        <p>请直接点击《<a style="color: #3490dc" href="https://pan.baidu.com/s/1aHpGIbJDKL29NE_pi8JrwA"
                                    target="_blank"
                                    rel="nofollow">{{config('app.name')}}删帖申请表</a>》提取码: eey1
                            下载表格填写投诉内容（所有选项均为必填），打印出来后请签写当事人/企业/机构亲笔手写签名/盖章；</p>
                        <ol>
                            <li>涉及个人的请附个人身份证复印件，并在复印件上签署“仅{{config('app.name')}}删帖申请专用”和当事人亲笔签名；</li>
                            <li>涉及企事业单位的请附加盖公章的营业执照、组织机构代码复印件，并在复印件上签署“仅{{config('app.name')}}删帖申请专用”和法人代表亲笔签名；</li>
                            <li>如有相关法院判决书、公文函件等有力证明材料，务必请一并附上；</li>
                            <li>
                                原则上我们不建议当事方委托第三方进行投诉及申请，若当事方是选择委托律师事务所或个人进行申请的，除了第2项相关材料之外，还须提供当事方亲笔签名的授权委托书，并且受委托方还须提供相关资质证明（律师事务所执业许可证复印件、律师工作执照复印件，个人身份证复印件）；
                            </li>
                        </ol>
                        <p>请您务必提交真实有效、完整清晰的材料，并在提交的申请投诉函中声明：<strong style="color: red;">“我保证，本函中所述信息是充分、真实、准确的，如果本函内容不完全属实，本人将承担由此产生的一切法律责任。” </strong>
                        </p>
                        <p>唯一侵权删改文章内容处理邮箱：{{str_replace('@','#',settings('system.lawyer_email'))}} ( 请将#替换为@再发送邮件 )</p>

                        <h6>特别声明</h6>
                        <ol>
                            <li>为保证本站正常运作，凡是无法提供完整证明文件的请求本站一律不予处理，请谅解；</li>
                            <li>因时间精力有限，凡是无法提供完整证明文件的请求本站均不会回复邮件，请谅解；</li>
                            <li>符合删改条件的请求本站会在72小时内进行处理，无论是否按照您的要求删改页面，我们均会通过邮件回复您。</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
