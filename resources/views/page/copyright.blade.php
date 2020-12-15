@extends('layouts.app')

@section('title', __('Copyright'))

@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="d-none d-lg-block col-lg-2">
                @include('page._left')
            </div>
            <div class="d-block col-md-12 col-lg-10 bg-white">
                <div class="site-content">
                    <div class="entry-header">
                        <div class="entry-title">{{__('Copyright')}}</div>
                    </div>
                    <div class="entry-content">
                        <h6>免责条款</h6>
                        <ol>
                            <li>本站部分转载的文章非原创，其版权和文责属于原作者。</li>
                            <li>本站用户投递的原创文章，其版权和文责属于投递者，除非另有说明。</li>
                            <li>由{{config('app.name')}}编辑采写的文章均在文内有明显标记，责任编辑对文章的真实性和原创性负责。转载时只需标明出处和原作者即可，但对于擅自修改原文导致文意改变引发的问题，{{config('app.name')}}不承担任何责任。</li>
                            <li>报道中出现的商标、专利和其他版权所有的信息，其版权属于其合法持有人。</li>
                            <li>对可以提供充分证据的侵权信息， {{config('app.name')}}将在确认后12小时内删除。</li>
                            <li>{{config('app.name')}}服从其服务器节点所在地的法律管辖。</li>
                        </ol>
                        <h6>评论须知</h6>
                        <ol>
                            <li>{{config('app.name')}}不能对用户发表的回答或评论的正确性进行保证。</li>
                            <li>用户在{{config('app.name')}}发表的内容仅表明其个人的立场和观点，并不代表{{config('app.name')}}
                                的立场或观点。作为内容的发表者，需自行对所发表内容负责，因所发表内容引发的一切纠纷，由该内容的发表者承担全部法律及连带责任。{{config('app.name')}}
                                不承担任何法律及连带责任。
                            </li>
                            <li>{{config('app.name')}}不保证网络服务一定能满足用户的要求，也不保证网络服务不会中断，对网络服务的及时性、安全性、准确性也都不作保证。</li>
                            <li>对于因不可抗力或{{config('app.name')}}不能控制的原因造成的网络服务中断或其它缺陷，{{config('app.name')}}
                                不承担任何责任，但将尽力减少因此而给用户造成的损失和影响。
                            </li>
                        </ol>
                        <h6>知识产权</h6>
                        <p>{{config('app.name')}}是一个信息获取、分享及传播的平台，我们尊重和鼓励{{config('app.name')}}
                            用户创作的内容，认识到保护知识产权对{{config('app.name')}}生存与发展的重要性，承诺将保护知识产权作为{{config('app.name')}}
                            运营的基本原则之一。</p>
                        <ol>
                            <li>用户在{{config('app.name')}}
                                上发表的全部原创内容（包括但不仅限于回答、文章和评论），著作权均归用户本人所有。用户可授权第三方以任何方式使用，不需要得到{{config('app.name')}}的同意。
                            </li>
                            <li>{{config('app.name')}}
                                提供的网络服务中包含的标识、版面设计、排版方式、文本、图片、图形等均受著作权、商标权及其它法律保护，未经相关权利人（含{{config('app.name')}}
                                及其他原始权利人）同意，上述内容均不得在任何平台被直接或间接发布、使用、出于发布或使用目的的改写或再发行，或被用于其他任何商业目的。
                            </li>
                            <li>为了促进知识的分享和传播，用户将其在{{config('app.name')}}上发表的全部内容，授予{{config('app.name')}}
                                免费的、不可撤销的、非独家使用许可，{{config('app.name')}}有权将该内容用于{{config('app.name')}}
                                各种形态的产品和服务上，包括但不限于网站以及发表的应用或其他互联网产品。
                            </li>
                            <li>第三方若出于非商业目的，将用户在{{config('app.name')}}上发表的内容转载在{{config('app.name')}}
                                之外的地方，应当在作品的正文开头的显著位置注明原作者姓名（或原作者在{{config('app.name')}}
                                上使用的帐号名称），给出原始链接，注明「发表于{{config('app.name')}}
                                」，并不得对作品进行修改演绎。若需要对作品进行修改，或用于商业目的，第三方应当联系用户获得单独授权，按照用户规定的方式使用该内容。
                            </li>
                            <li>{{config('app.name')}}
                                为用户提供「保留所有权利，禁止转载」的选项。除非获得原作者的单独授权，任何第三方不得转载标注了「禁止转载」的内容，否则均视为侵权。
                            </li>
                            <li>在{{config('app.name')}}
                                上传或发表的内容，用户应保证其为著作权人或已取得合法授权，并且该内容不会侵犯任何第三方的合法权益。如果第三方提出关于著作权的异议，{{config('app.name')}}
                                有权根据实际情况删除相关的内容，且有权追究用户的法律责任。给{{config('app.name')}}或任何第三方造成损失的，用户应负责全额赔偿。
                            </li>
                            <li>如果任何第三方侵犯了{{config('app.name')}}用户相关的权利，用户同意授权{{config('app.name')}}
                                或其指定的代理人代表{{config('app.name')}}
                                自身或用户对该第三方提出警告、投诉、发起行政执法、诉讼、进行上诉，或谈判和解，并且用户同意在{{config('app.name')}}认为必要的情况下参与共同维权。
                            </li>
                            <li>{{config('app.name')}}
                                有权但无义务对用户发布的内容进行审核，有权根据相关证据结合《侵权责任法》、《信息网络传播权保护条例》等法律法规及{{config('app.name')}}
                                社区指导原则对侵权信息进行处理。
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
