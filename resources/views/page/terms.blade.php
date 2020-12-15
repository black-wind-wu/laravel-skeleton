@extends('layouts.app')

@section('title', __('Terms'))

@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="d-none d-lg-block col-lg-2">
                @include('page._left')
            </div>
            <div class="d-block col-md-12 col-lg-10 bg-white">
                <div class="site-content">
                    <div class="entry-header">
                        <div class="entry-title">{{__('Terms')}}</div>
                    </div>
                    <div class="entry-content">
                        <p>欢迎您使用{{config('app.name')}}服务（以下称“我们”或“{{config('app.name')}}
                            ”），您在使用本服务前请认真阅读以下协议（下称：本协议）。</p>
                        <p>请您仔细阅读以下条款，如果您对本协议的任何条款表示异议，您可以选择不进入{{config('app.name')}}。当您注册成功，无论是进入{{config('app.name')}}
                            ，还是在{{config('app.name')}}上发布任何内容（即「内容」），均意味着您（即「用户」）完全接受本协议项下的全部条款。</p>
                        <h6>使用规则</h6>
                        <ol>
                            <li>用户注册成功后，{{config('app.name')}}
                                将给予每个用户一个用户帐号及相应的密码，该用户帐号和密码由用户负责保管；用户应当对以其用户帐号进行的所有活动和事件负法律责任。
                            </li>
                            <li>用户须对在{{config('app.name')}}
                                的注册信息的真实性、合法性、有效性承担全部责任，用户不得冒充他人；不得利用他人的名义发布任何信息；不得恶意使用注册帐号导致其他用户误认；否则{{config('app.name')}}
                                有权立即停止提供服务，收回其帐号并由用户独自承担由此而产生的一切法律责任。
                            </li>
                            <li>用户直接或通过各类方式（如 RSS 源和站外 API 引用等）间接使用{{config('app.name')}}
                                服务和数据的行为，都将被视作已无条件接受本协议全部内容；若用户对本协议的任何条款存在异议，请停止使用{{config('app.name')}}所提供的全部服务。
                            </li>
                            <li>{{config('app.name')}}是一个信息分享、传播及获取的平台，用户通过{{config('app.name')}}
                                发表的信息为公开的信息，其他第三方均可以通过{{config('app.name')}}
                                获取用户发表的信息，用户对任何信息的发表即认可该信息为公开的信息，并单独对此行为承担法律责任；任何用户不愿被其他第三人获知的信息都不应该在{{config('app.name')}}
                                上进行发表。
                            </li>
                            <li>用户承诺不得以任何方式利用{{config('app.name')}}直接或间接从事违反中国法律以及社会公德的行为，{{config('app.name')}}
                                有权对违反上述承诺的内容予以删除。
                            </li>
                            <li>
                                <p>用户不得利用{{config('app.name')}}服务制作、上载、复制、发布、传播或者转载如下内容：</p>
                                <ul>
                                    <li>反对宪法所确定的基本原则的；</li>
                                    <li>危害国家安全，泄露国家秘密，颠覆国家政权，破坏国家统一的；</li>
                                    <li>损害国家荣誉和利益的；</li>
                                    <li>煽动民族仇恨、民族歧视，破坏民族团结的；</li>
                                    <li>侮辱、滥用英烈形象，否定英烈事迹，美化粉饰侵略战争行为的；</li>
                                    <li>破坏国家宗教政策，宣扬邪教和封建迷信的；</li>
                                    <li>散布谣言，扰乱社会秩序，破坏社会稳定的；</li>
                                    <li>散布淫秽、色情、赌博、暴力、凶杀、恐怖或者教唆犯罪的；</li>
                                    <li>侮辱或者诽谤他人，侵害他人合法权益的；</li>
                                    <li>含有法律、行政法规禁止的其他内容的信息。</li>
                                </ul>
                            </li>
                            <li>所有用户同意遵守[{{config('app.name')}}管理规定]；</li>
                            <li>{{config('app.name')}}有权对用户使用{{config('app.name')}}
                                的情况进行审查和监督，如用户在使用{{config('app.name')}}时违反任何上述规定，{{config('app.name')}}
                                或其授权的人有权要求用户改正或直接采取一切必要的措施（包括但不限于更改或删除用户张贴的内容、暂停或终止用户使用{{config('app.name')}}
                                的权利）以减轻用户不当行为造成的影响。
                            </li>
                        </ol>

                        <h6>个人隐私</h6>
                        <p>尊重用户个人隐私信息的私有性是{{config('app.name')}}的一贯原则，{{config('app.name')}}
                            将通过技术手段、强化内部管理等办法充分保护用户的个人隐私信息，除法律或有法律赋予权限的政府部门要求或事先得到用户明确授权等原因外，{{config('app.name')}}
                            保证不对外公开或向第三方透露用户个人隐私信息，或用户在使用服务时存储的非公开内容。同时，为了运营和改善{{config('app.name')}}
                            的技术与服务，{{config('app.name')}}将可能会自行收集使用或向第三方提供用户的非个人隐私信息，这将有助于{{config('app.name')}}
                            向用户提供更好的用户体验和服务质量。</p>
                        <p>您使用或继续使用我们的服务，即意味着同意我们按照{{config('app.name')}}《隐私政策》收集、使用、储存和分享您的相关信息。</p>
                        <h6>协议修改</h6>
                        <ol>
                            <li>根据互联网的发展和有关法律、法规及规范性文件的变化，或者因业务发展需要，{{config('app.name')}}
                                有权对本协议的条款作出修改或变更，一旦本协议的内容发生变动，{{config('app.name')}}将会直接在{{config('app.name')}}
                                网站上公布修改之后的协议内容，该公布行为视为{{config('app.name')}}已经通知用户修改内容。{{config('app.name')}}
                                也可采用电子邮件或私信的传送方式，提示用户协议条款的修改、服务变更、或其它重要事项。
                            </li>
                            <li>如果不同意{{config('app.name')}}对本协议相关条款所做的修改，用户有权并应当停止使用{{config('app.name')}}
                                。如果用户继续使用 {{config('app.name')}}，则视为用户接受{{config('app.name')}}对本协议相关条款所做的修改。
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
