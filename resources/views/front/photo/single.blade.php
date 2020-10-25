@extends('front.layout')
@section('pageTitle', "$photo->title by $userUpload->name $userUpload->f_name")
@section('body')
    <style>
        /* To move the arrows buttons out of the Ninja Slider when in fullscreen: */
        #ninja-slider {
            padding-top: 1px;
        }

        #ninja-slider.fullscreen #ninja-slider-prev {
            left: -50px;
        }

        #ninja-slider.fullscreen #ninja-slider-next {
            right: -50px;
        }

        /*Hide the arrow buttons on mobile phones as users can nav by touch/swipe*/
        @media only screen and (max-width: 500px) {
            #ninja-slider-prev, #ninja-slider-next {
                display: none;
            }
        }

        #ninja-slider.fullscreen div.slider-inner {
            max-width: 900px;
            max-height: 80%;
        }

    </style>

    <div class="container-fluid" style="background-color: rgb(247, 248, 250);">
        <div class="row">
            <div id='ninja-slider' style="position: relative">
                <div id="cover" style="position: absolute;
height: 28px;
width: 100%;
top: 0px;
bottom: 0;
/*background-color: rgba(0,0,0,0.8);*/
background-color:black;
z-index: 999;"></div>
                <div style="background-color: #212529">
                    <div class="slider-inner">
                        <ul>
                            <li><a class="ns-img"
                                   href="{{url($photo->sources)}}"></a>
                            </li>
                        </ul>
                        <div class="fs-icon" title="Expand/Close"></div>
                    </div>
                </div>
            </div>
            <div id="cover" style="position: relative;
height: 28px;
width: 100%;
top: -26px;
bottom: 0;
/*background-color: rgba(0,0,0,0.8);*/
background-color: black;
z-index: 999;"></div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-7">
                @if(auth()->check())
                    @if(auth()->user()->id == $photo->user_id)
                        <form onsubmit="return formValidate(this)" action="{{route('user.photo.destroy',['id'=>$photo->id])}}" method="post">
                            @csrf
                            @method('delete')
                            @if($photo->status == 'فعال')
                                <button class="btn btn-danger" id="delete" type="submit">عدم قابلیت نمایش برای دیگران</button>
                            @else
                                <button class="btn btn-success" id="delete" type="submit"> قابلیت نمایش برای دیگران</button>
                            @endif
                        </form>
                    @endif
                @endif
                <div style="background-color: white;padding: 25px;">
                    <div id="social">
                    <span style="position: absolute" id="like" onclick="rate(event,'{{$photo->id}}',1)">
                         <i style="font-size: 31px;cursor: pointer" class="fa fa-heart-o" aria-hidden="true"></i>
                    </span>
                        <span hidden style="position: absolute" id="dis_like" onclick="rate(event,'{{$photo->id}}',0)">
                   <i hidden style="font-size: 31px;cursor: pointer" class="fa fa-heart" aria-hidden="true"></i>
                    </span>
                        <span>
                        <p id="count" style="margin-right: 55px">{{$photo->rate}}</p>
                    </span>
                    </div>
                    <div id="info" style="margin-top: 25px;margin-bottom: 25px;">
                        <div class="row">
                            <div class="col-xs-12 col-md-2">
                                <div id="photo">
                            <span
                                style="display: inline-block; width: 80px; border-radius: 50%; overflow: hidden;height: 80px;">
                                <img style="width: 100%;height: 100%" src="{{ $userUpload->photo }}" alt="">
                            </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-10">
                                <div id="title">
                                    <h3>{{$photo->title}}</h3>
                                    <p id="name">
                            <span>توسط
                                <a href="{{route('welcomeaccount',['username'=>$userUpload->user_name])}}">{{ $userUpload->name }} {{$userUpload->f_name}}</a>
                                بارگذاری شده
                            </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <ul class="list-group list-group-flush" id="exif">
                        <li class="list-group-item">
                            <label>نام</label>
                            <input type="text"
                                   value="{{ isset($exif->info->firstName) ? $exif->info->firstName : '_'}}"/>
                        </li>
                        <li class="list-group-item">
                            <label>نام خانوادگی</label>
                            <input type="text"
                                   value="{{ isset($exif->info->lastName) ? $exif->info->lastName : '' }}"/>
                        </li>
                        <li class="list-group-item">
                            <label>موقعیت</label>
                            <?php
                            if (isset($exif->GPS->GPSLatitude['2'])) {
                                $lat = explode('/', $exif->GPS->GPSLatitude['2']);
                                $lat = $lat[0] / $lat[1];
                                $long = explode('/', $exif->GPS->GPSLongitude['2']);
                                $long = $long[0] / $long[1];
                            }
                            ?>
                            <input type="text"
                                   value="{{ isset($exif->GPS->GPSLatitude['2']) ? $lat.'/'.$long : '' }}"/>
                        </li>
                        <li class="list-group-item">
                            <label>مدل دوربین</label>
                            <input type="text" value="{{isset($exif->IFD0->Model) ? $exif->IFD0->Model : '_'}}"
                                   name="cameraModel" id="cameraModel"/>
                        </li>
                        <li class="list-group-item">
                            <label>سازنده دوربین</label>
                            <input type="text" value="{{isset($exif->IFD0->Make) ? $exif->IFD0->Make : '_'}}"
                                   name="cameraMake" id="cameraMake"/>
                        </li>
                        <li class="list-group-item">
                            <label>زمان</label>
                            <input type="text"
                                   value="{{isset($exif->IFD0->DateTime) ? $exif->IFD0->DateTime : '_'}}"
                                   name="DateTime" id="DateTime"/>
                        </li>
                        <li class="list-group-item">
                            <label>ISO/Pelicula دوربین</label>
                            <input type="text"
                                   value="{{isset($exif->EXIF->ISOSpeedRatings) ? $exif->EXIF->ISOSpeedRatings : '_'}}"
                                   name="iso" id="ISO"/>
                        </li>
                        <li class="list-group-item">
                            <label>دسته بندی</label>
                            <input type="text"
                                   value="{{$photo->category->title}}"
                                   name="cat" id="CAT"/>
                        </li>
                        <li class="list-group-item">
                            <label>کلید عمومی</label>
                            <input type="text"
                                   value="{{$photo->f_hash}}"
                                   name="p_key" id="P_KEY"/>
                        </li>
                        @if (auth()->check())
                            @if(auth()->user()->id == $photo->user_id)
                                <li class="list-group-item">
                                    <label>کلید خصوصی</label>
                                    <input type="text"
                                           value="{{$photo->p_hash}}"
                                           name="p_key" id="P_KEY"/>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>

            </div>
            <div class="col-xs-12 col-md-5 comment">
                <div style="background-color: white;padding: 20px;">
                    <h6 style="margin-bottom: 15px;"><span >{{$countComments}} کامنت </span></h6>
                    <span style="margin-bottom: 15px;display: inline-block;margin-left: 50px;"> آپلود شده: {{ $diff }}</span>
                    <span style="margin-bottom: 15px;display: inline-block;"> گرفته شده: {{ $exif->IFD0->DateTime ? $exif->IFD0->DateTime : '' }}</span>
                    @if (auth()->check())
                        @if(auth()->user()->id != $photo->user_id)
                            <div class="StyledLayout__Box-b9gazd-0 fSOPsj">
                                <div class="StyledLayout__Box-b9gazd-0 crOACl">
                                    <div class="StyledUserAvatar__UserAvatarWrapper-sc-1q2i94h-0 ceVayd"><a
                                            href="" style="line-height: 0;"><img
                                                alt="{{$photo->user->id}}"
                                                src="{{auth()->user()->photo}}"
                                                data-id="user-avatar"
                                                class="StyledUserAvatar__UserAvatarImage-sc-1q2i94h-1 dBxlhE"></a>
                                    </div>
                                    {{--                                    <div class="Elements__CommentReplyMarker-sc-1e3xy9t-22 fYcCPw"></div>--}}
                                    <div class="Elements__CommentInputWrapper-sc-1e3xy9t-19 hRAlPC">
                                        <textarea
                                            id="txtarea-0"
                                            placeholder="Add a comment"
                                            class="txtarea ant-input Elements__CommentInput-sc-1e3xy9t-21 kATyLo"
                                            style="height: 52px; min-height: 52px; max-height: 152px;"></textarea>
                                        <div
                                            class="StyledIcons__StyledIcon-sc-1tde1rj-0 Elements__CommentInputIcon-sc-1e3xy9t-20 gakMEr">
                                            <i class="fas fa-2x fa-comment"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="send" style="display: none" class="StyledLayout__Box-b9gazd-0 kumJBc">
                                <a style="cursor: pointer;" id="cancel"
                                   onclick="closeReplay()"
                                   class="StyledLink-xjskmb-0 fhYBdP"><span>انصراف</span>
                                </a>
                                <a style="cursor: pointer;"
                                   onclick="comment('{{$photo->id}}', 0, 0)"
                                   disabled="" data-id="photo-comment"
                                   class="Elements__OldButton-tze21g-0 iCSAvO"><span>ارسال</span>
                                </a>
                            </div>
                        @endif
                    @endif

                    <div class="StyledLayout__Box-b9gazd-0 hljCCo" style="" id="comment_appnd">
                        {{-- with jquery --}}
                        @foreach($comments as $comment)
                            <div id="cmd-{{$comment->id}}" class="StyledLayout__Box-b9gazd-0 jCpAGn">
                                <div>
                                    <div class="StyledUserAvatar__UserAvatarWrapper-sc-1q2i94h-0 ceVayd"><a
                                            href="" style="line-height: 0;"><img
                                                alt="{{ $comment->user->name }}"
                                                src="{{ $comment->user->photo }}"
                                                data-id="user-avatar"
                                                class="StyledUserAvatar__UserAvatarImage-sc-1q2i94h-1 dBxlhE"></a>
                                    </div>
                                    @if ( count($comment->childrens) )
                                        <div class="Elements__CommentReplyMarker-sc-1e3xy9t-22 fYcCPw"></div>
                                    @endif
                                </div>
                                <div class="StyledLayout__Box-b9gazd-0 jbeXaE">
                                    <div class="StyledLayout__Box-b9gazd-0 dZZYQd">
                                        {{--                                                <a href="" class="StyledLink-xjskmb-0 CDvRO">--}}
                                        <div><a href="{{route('welcomeaccount',['username'=>$comment->user->user_name])}}">{{ $comment->user->name }} {{ $comment->user->f_name }}</a></div>
                                        {{--                                                </a>--}}
                                        <p class="StyledTypography__Caption-sc-1un6cv3-5 lnRqSn">
                                            <span>{{ $comment->created_at }}</span></p></div>
                                    <p class="StyledTypography__Paragraph-sc-1un6cv3-4 guluxS">{{ $comment->description }}</p>
                                    <div class="StyledLayout__Box-b9gazd-0 fSOPsj">
                                        <div class="StyledLayout__Box-b9gazd-0 bymfaQ"><a
                                                onclick="showReply({{ $comment->id }})"
                                                id="reply-{{ $comment->id }}"
                                                class="StyledLink-xjskmb-0 cQVcgi"><p
                                                    class="StyledTypography__Paragraph-sc-1un6cv3-4 dNVGMJ">
                                                    <span>Reply</span>
                                                </p></a>
                                            <div class="StyledPopover__PopoverMask-sc-1279jqe-7 knbWgb"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--// for replay--}}
                            @if(\Illuminate\Support\Facades\Auth::check())
                                <div style="display: none"
                                     class="reply-{{$comment->id}} reply StyledLayout__Box-b9gazd-0 dYGmnD">
                                    <div class="StyledLayout__Box-b9gazd-0 dMahZL">
                                        <div
                                            class="info StyledUserAvatar__UserAvatarWrapper-sc-1q2i94h-0 jXpWgu">
                                            <a
                                                href="" style="line-height: 0;"><img
                                                    alt=""
                                                    src="{{ $user->photo}}"
                                                    data-id="user-avatar"
                                                    class="StyledUserAvatar__UserAvatarImage-sc-1q2i94h-1 qzlyw"></a>
                                        </div>
                                        <div class="Elements__CommentInputWrapper-sc-1e3xy9t-19 hRAlPC">
                                                        <textarea id="txtarea-{{$comment->id}}"
                                                                  placeholder="Add a comment"
                                                                  class="desc txtarea ant-input Elements__CommentInput-sc-1e3xy9t-21 kATyLo"
                                                                  style="height: 52px; min-height: 52px; max-height: 152px;"></textarea>
                                            <div
                                                class="StyledIcons__StyledIcon-sc-1tde1rj-0 Elements__CommentInputIcon-sc-1e3xy9t-20 gakMEr">
                                                <i class="fas fa-2x fa-comment"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="send" class="StyledLayout__Box-b9gazd-0 kumJBc">
                                        <a style="cursor: pointer;" id="cancel"
                                           onclick="closeReplay()"
                                           class="StyledLink-xjskmb-0 fhYBdP"><span>انصراف</span>
                                        </a>
                                        <a style="cursor: pointer;"
                                           onclick="comment('{{$photo->id}}', '{{$comment->id}}', '{{$comment->id}}');"
                                           disabled="" data-id="photo-comment"
                                           class="Elements__OldButton-tze21g-0 iCSAvO"><span>ارسال</span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @foreach($comment->childrens as $child)
                                <div id="cmd-{{$child->id}}" class="StyledLayout__Box-b9gazd-0 jCpAGn">
                                    <div>
                                        <div class="StyledUserAvatar__UserAvatarWrapper-sc-1q2i94h-0 ceVayd"><a
                                                href="" style="line-height: 0;"><img
                                                    alt="{{ $child->user->name }}"
                                                    src="{{ $child->user->photo }}"
                                                    data-id="user-avatar"
                                                    class="StyledUserAvatar__UserAvatarImage-sc-1q2i94h-1 dBxlhE"></a>
                                        </div>
                                        @if ( count($comment->childrens) && !$loop->last)
                                            <div
                                                class="Elements__CommentReplyMarker-sc-1e3xy9t-22 fYcCPw"></div>
                                        @endif
                                    </div>
                                    <div class="StyledLayout__Box-b9gazd-0 jbeXaE">
                                        <div class="StyledLayout__Box-b9gazd-0 dZZYQd">
                                            {{--                                                    <a href="" class="StyledLink-xjskmb-0 CDvRO">--}}
                                            <div><a href="{{route('welcomeaccount',['username'=>$child->user->user_name])}}">{{ $child->user->name }} {{ $child->user->f_name }}</a></div>
                                            {{--                                                    </a>--}}
                                            <p class="StyledTypography__Caption-sc-1un6cv3-5 lnRqSn">
                                                <span>{{ $child->created_at }}</span></p></div>
                                        <p class="StyledTypography__Paragraph-sc-1un6cv3-4 guluxS">{{ $child->description }}</p>
                                        <div class="StyledLayout__Box-b9gazd-0 fSOPsj">
                                            <div class="StyledLayout__Box-b9gazd-0 bymfaQ"><a
                                                    onclick="showReply({{ $child->id }})"
                                                    id="reply-{{ $child->id }}"
                                                    class="StyledLink-xjskmb-0 cQVcgi"><p
                                                        class="StyledTypography__Paragraph-sc-1un6cv3-4 dNVGMJ">
                                                        <span>Reply</span>
                                                    </p></a>
                                                <div
                                                    class="StyledPopover__PopoverMask-sc-1279jqe-7 knbWgb"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--                                    // for replay--}}
                                @if(\Illuminate\Support\Facades\Auth::check())
                                    <div style="display: none"
                                         class="reply-{{$child->id}} reply StyledLayout__Box-b9gazd-0 dYGmnD">
                                        <div class="StyledLayout__Box-b9gazd-0 dMahZL">
                                            <div
                                                class="info StyledUserAvatar__UserAvatarWrapper-sc-1q2i94h-0 jXpWgu">
                                                <a
                                                    href="" style="line-height: 0;"><img
                                                        alt=""
                                                        src="{{ $user->photo}}"
                                                        data-id="user-avatar"
                                                        class="StyledUserAvatar__UserAvatarImage-sc-1q2i94h-1 qzlyw"></a>
                                            </div>
                                            <div class="Elements__CommentInputWrapper-sc-1e3xy9t-19 hRAlPC">
                                                        <textarea id="txtarea-{{$child->id}}"
                                                                  placeholder="Add a comment"
                                                                  class="desc txtarea ant-input Elements__CommentInput-sc-1e3xy9t-21 kATyLo"
                                                                  style="height: 52px; min-height: 52px; max-height: 152px;"></textarea>
                                                <div
                                                    class="StyledIcons__StyledIcon-sc-1tde1rj-0 Elements__CommentInputIcon-sc-1e3xy9t-20 gakMEr">
                                                    <i class="fas fa-2x fa-comment"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="send" class="StyledLayout__Box-b9gazd-0 kumJBc">
                                            <a style="cursor: pointer;" id="cancel"
                                               onclick="closeReplay()"
                                               class="StyledLink-xjskmb-0 fhYBdP"><span>انصراف</span>
                                            </a>
                                            <a style="cursor: pointer;"
                                               onclick="comment('{{$photo->id}}', '{{$comment->id}}', '{{$child->id}}');"
                                               disabled="" data-id="photo-comment"
                                               class="Elements__OldButton-tze21g-0 iCSAvO"><span>ارسال</span>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                @foreach($child->childrens as $child3)
                                    <div id="cmd-{{$child3->id}}" class="StyledLayout__Box-b9gazd-0 jCpAGn">
                                        <div>
                                            <div
                                                class="StyledUserAvatar__UserAvatarWrapper-sc-1q2i94h-0 ceVayd">
                                                <a
                                                    href="" style="line-height: 0;"><img
                                                        alt="{{ $child3->user->name }}"
                                                        src="{{ $child3->user->photo }}"
                                                        data-id="user-avatar"
                                                        class="StyledUserAvatar__UserAvatarImage-sc-1q2i94h-1 dBxlhE"></a>
                                            </div>
                                            @if ( count($child3->childrens) )
                                                {{--                                                        <div class="Elements__CommentReplyMarker-sc-1e3xy9t-22 fYcCPw"></div>--}}
                                            @endif
                                        </div>
                                        <div class="StyledLayout__Box-b9gazd-0 jbeXaE">
                                            <div class="StyledLayout__Box-b9gazd-0 dZZYQd">
                                                {{--                                                        <a href="" class="StyledLink-xjskmb-0 CDvRO">--}}
                                                <div><a href="{{route('welcomeaccount',['username'=>$child3->user->user_name])}}">{{ $child3->user->name }} {{ $child3->user->f_name }}</a></div>
                                                {{--                                                        </a>--}}
                                                <p class="StyledTypography__Caption-sc-1un6cv3-5 lnRqSn">
                                                    <span>{{ $child3->created_at }}</span></p></div>
                                            <p class="StyledTypography__Paragraph-sc-1un6cv3-4 guluxS">{{ $child3->description }}</p>
                                            <div class="StyledLayout__Box-b9gazd-0 fSOPsj">
                                                <div class="StyledLayout__Box-b9gazd-0 bymfaQ"><a
                                                        onclick="showReply({{ $child3->id }})"
                                                        id="reply-{{ $child3->id }}"
                                                        class="StyledLink-xjskmb-0 cQVcgi"><p
                                                            class="StyledTypography__Paragraph-sc-1un6cv3-4 dNVGMJ">
                                                            <span>Reply</span>
                                                        </p></a>
                                                    <div
                                                        class="StyledPopover__PopoverMask-sc-1279jqe-7 knbWgb"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--                                        // for reply--}}
                                    @if (\Illuminate\Support\Facades\Auth::check())
                                        <div style="display: none"
                                             class="reply-{{$child3->id}} reply StyledLayout__Box-b9gazd-0 dYGmnD">
                                            <div class="StyledLayout__Box-b9gazd-0 dMahZL">
                                                <div
                                                    class="info StyledUserAvatar__UserAvatarWrapper-sc-1q2i94h-0 jXpWgu">
                                                    <a
                                                        href="" style="line-height: 0;"><img
                                                            alt=""
                                                            src="{{ $user->photo}}"
                                                            data-id="user-avatar"
                                                            class="StyledUserAvatar__UserAvatarImage-sc-1q2i94h-1 qzlyw"></a>
                                                </div>
                                                <div class="Elements__CommentInputWrapper-sc-1e3xy9t-19 hRAlPC">
                                                        <textarea id="txtarea-{{$child3->id}}"
                                                                  placeholder="Add a comment"
                                                                  class="desc txtarea ant-input Elements__CommentInput-sc-1e3xy9t-21 kATyLo"
                                                                  style="height: 52px; min-height: 52px; max-height: 152px;"></textarea>
                                                    <div
                                                        class="StyledIcons__StyledIcon-sc-1tde1rj-0 Elements__CommentInputIcon-sc-1e3xy9t-20 gakMEr">
                                                        <i class="fas fa-2x fa-comment"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="send" class="StyledLayout__Box-b9gazd-0 kumJBc">
                                                <a style="cursor: pointer;" id="cancel"
                                                   onclick="closeReplay()"
                                                   class="StyledLink-xjskmb-0 fhYBdP"><span>انصراف</span>
                                                </a>
                                                <a style="cursor: pointer;"
                                                   onclick="comment('{{$photo->id}}', '{{$comment->id}}', '{{$child3->id}}');"
                                                   disabled="" data-id="photo-comment"
                                                   class="Elements__OldButton-tze21g-0 iCSAvO"><span>ارسال</span>
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                @endforeach
                            @endforeach
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

        <div id="foo" style="background-color: rgb(247, 248, 250);"></div>
        @endsection
        <style>
            @media only screen and (max-width: 600px) {
                #foo {
                    height: 210px;
                }
            }

            @media only screen and (min-width: 601px) {
                #foo {
                    height: 70px;
                }
            }

            .hljCCo {
                word-break: break-word;
                max-width: 100%;
            }

            .dYGmnD {
                word-break: break-word;
                max-width: 100%;
                margin-bottom: 24px;
            }

            .dMahZL {
                word-break: break-word;
                max-width: 100%;
                -webkit-box-pack: justify;
                justify-content: space-between;
                display: flex;
            }

            .jXpWgu {
                display: flex;
                -webkit-box-align: center;
                align-items: center;
                min-width: 32px;
            }

            .qzlyw {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                overflow: hidden;
            }

            .kumJBc {
                word-break: break-word;
                max-width: 100%;
                -webkit-box-pack: end;
                justify-content: flex-end;
                -webkit-box-align: center;
                align-items: center;
                display: flex;
                margin-top: 16px;
            }

            .fhYBdP {
                position: relative;
                font-weight: bold;
                cursor: pointer;
                margin-left: 16px;
                font-size: 16px;
                color: rgb(8, 112, 209);
                text-decoration: none;
                transition: color 0.1s ease 0s;
            }

            .iCSAvO {
                display: inline-flex;
                -webkit-box-pack: center;
                justify-content: center;
                -webkit-box-align: center;
                align-items: center;
                background-color: rgb(8, 112, 209);
                color: rgb(255, 255, 255);
                font-size: 16px;
                line-height: 16px;
                font-weight: bold;
                height: 32px;
                padding: 0px 16px;
                border-width: 2px;
                border-color: rgb(8, 112, 209);
                border-radius: 100px;
                border-style: solid;
                margin: 0px;
            }

            .jCpAGn {
                word-break: break-word;
                max-width: 100%;
                display: flex;
            }

            .ceVayd {
                display: flex;
                -webkit-box-align: center;
                align-items: center;
                min-width: 32px;
            }

            .dBxlhE {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                overflow: hidden;
            }

            .fYcCPw {
                width: 3px;
                height: calc(100% - 40px);
                background-color: rgb(238, 239, 242);
                margin: 4px auto 0px;
            }

            .jbeXaE {
                word-break: break-word;
                max-width: 100%;
                width: 100%;
                margin-right: 16px;
            }

            .dZZYQd {
                word-break: break-word;
                max-width: 100%;
                -webkit-box-pack: justify;
                justify-content: space-between;
                -webkit-box-align: center;
                align-items: center;
                display: flex;
            }

            .CDvRO {
                position: relative;
                font-weight: bold;
                cursor: pointer;
                font-size: 16px;
                line-height: 20px;
                color: rgb(34, 34, 34);
                text-decoration: none;
                transition: color 0.1s ease 0s;
            }

            .lnRqSn {
                font-size: 12px;
                line-height: 16px;
                text-transform: none;
                color: rgb(109, 115, 120);
                white-space: nowrap;
                margin: 0px 0px 0px 16px;
            }

            .guluxS {
                font-size: 16px;
                line-height: 20px;
                letter-spacing: 0px;
                text-transform: none;
                color: rgb(34, 34, 34);
                margin: 0px;
            }

            .fSOPsj {
                word-break: break-word;
                max-width: 100%;
                margin-bottom: 24px;
            }

            .bymfaQ {
                word-break: break-word;
                max-width: 100%;
                -webkit-box-pack: justify;
                justify-content: space-between;
                -webkit-box-align: center;
                align-items: center;
                display: flex;
                margin-top: 4px;
            }

            .cQVcgi {
                position: relative;
                font-weight: normal;
                cursor: pointer;
                font-size: 16px;
                color: rgb(8, 112, 209);
                text-decoration: none;
                transition: color 0.1s ease 0s;
            }

            .dNVGMJ {
                font-size: 14px;
                line-height: 20px;
                letter-spacing: 0px;
                text-transform: none;
                color: rgb(109, 115, 120);
                margin: 0px;
            }

            .fSOPsj {
                word-break: break-word;
                max-width: 100%;
                margin-bottom: 24px;
            }

            .fYcCPw {
                width: 3px;
                height: calc(100% - 40px);
                background-color: rgb(238, 239, 242);
                margin: 4px auto 0px;
            }

            .crOACl {
                word-break: break-word;
                max-width: 100%;
                -webkit-box-pack: justify;
                justify-content: space-between;
                display: flex;
            }

            .ceVayd {
                display: flex;
                -webkit-box-align: center;
                align-items: center;
                min-width: 32px;
            }

            .dBxlhE {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                overflow: hidden;
            }

            #thumbnail-slider-prev, #thumbnail-slider-next {
                display: none;
            }

            .ixLGmf.ant-input {
                resize: none;
            }

            .ant-input:placeholder-shown {
                -o-text-overflow: ellipsis;
                text-overflow: ellipsis;
            }

            .gakMEr {
                position: absolute;
                left: 6px;
                top: 25%;
                bottom: 25%;
            }

            .ant-input {
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
                margin: 0;
                padding: 0;
                font-variant: tabular-nums;
                list-style: none;
                -webkit-font-feature-settings: "tnum";
                font-feature-settings: "tnum";
                position: relative;
                display: inline-block;
                width: 100%;
                height: 32px;
                padding: 4px 11px;
                color: rgba(0, 0, 0, .65);
                font-size: 14px;
                line-height: 1.5;
                background-color: #fff;
                background-image: none;
                border: 1px solid #d9d9d9;
                border-radius: 4px;
                -webkit-transition: all .3s;
                -o-transition: all .3s;
                transition: all .3s;
            }

            textarea {
                overflow: auto;
            }

            .hRAlPC {
                display: flex;
                position: relative;
                width: 80%;
                margin-left: 16px;
                border-width: 1px;
                border-style: solid;
                border-color: rgb(109, 115, 120);
                border-image: initial;
                border-radius: 4px;
            }

            /* @media (min-width: 1025px) and (max-width: 1280px) {
                 #exif input {
                     width: 74%;
                 }
                 label{
                     width: 25%;
                 }
             }*/

            #exif input {
                background: transparent;
                border: 0px solid #EEE;
                color: #08F;
                display: inline-table;
                margin: 5px auto;
                padding-left: 80px;
                outline-width: 0;
                outline-color: #08F;
                *width: calc(50% - 22px);
            }
        </style>
        @section('js')
            <script>
                // $('#reply-1').on('click', function () {
                //     $('.reply-1').toggle('6000');
                // });
                $('#txtarea-0').on('click', function () {
                    $('#send').toggle('6000');
                });
                $('#cancel').on('click', function () {
                    $('#send').toggle('9000');
                });
                function closeReplay() {
                    $(".reply").hide();
                }
                function showReply(reply_id) {
                    $(".reply").hide();
                    $(".reply-" + reply_id).toggle();
                }

                @if(\Illuminate\Support\Facades\Auth::check())
                function comment(image_id, parent_id, child_id) {
                    event.preventDefault();
                    var comment = $('#txtarea-' + child_id).val();
                    var obj = "";
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('comment.add') }}',
                        data: {
                            '_token': '<?php echo csrf_token()?>',
                            'image_id': image_id,
                            'parent_id': parent_id,
                            'comment': comment
                        },
                        success: function (data) {
                            // console.log(data.parent_id)

                            if (child_id == 0) {
                                $('#comment_appnd').prepend("<div id=\"cmd-" + data.parent_id + "\" class=\"StyledLayout__Box-b9gazd-0 jCpAGn\">\n" +
                                    "                                        <div>\n" +
                                    "                                            <div class=\"StyledUserAvatar__UserAvatarWrapper-sc-1q2i94h-0 ceVayd\"><a\n" +
                                    "                                                    href=\"\" style=\"line-height: 0;\"><img\n" +
                                    "                                                        alt=\"{{ $comment->user->name ?? ''}}\"\n" +
                                    "                                                        src=\"{{ $user->photo ?? '' }}\"\n" +
                                    "                                                        data-id=\"user-avatar\"\n" +
                                    "                                                        class=\"StyledUserAvatar__UserAvatarImage-sc-1q2i94h-1 dBxlhE\"></a>\n" +
                                    "                                            </div>\n" +
                                    "                                        </div>\n" +
                                    "                                        <div class=\"StyledLayout__Box-b9gazd-0 jbeXaE\">\n" +
                                    "                                            <div class=\"StyledLayout__Box-b9gazd-0 dZZYQd\"><a\n" +
                                    "                                                    href='{{ $comment->user->username ?? '' }}' class=\"StyledLink-xjskmb-0 CDvRO\">\n" +
                                    "                                                    <div>{{ $comment->user->name ?? '' }} {{ $comment->user->f_name ?? '' }}</div>\n" +
                                    "                                                </a>\n" +
                                    "                                                <p class=\"StyledTypography__Caption-sc-1un6cv3-5 lnRqSn\">\n" +
                                    "                                                    <span>" + data.created_at + "</span></p></div>\n" +
                                    "                                            <p class=\"StyledTypography__Paragraph-sc-1un6cv3-4 guluxS\">" + data.description + "</p>\n" +
                                    "                                            <div class=\"StyledLayout__Box-b9gazd-0 fSOPsj\">\n" +
                                    "                                                <div class=\"StyledLayout__Box-b9gazd-0 bymfaQ\" ><a onclick=\"showReply(" + data.id + ")\"\n" +
                                    "                                                                                                   id=\"reply-" + data.id + "\"\n" +
                                    "                                                                                                   class=\"StyledLink-xjskmb-0 cQVcgi\"><p\n" +
                                    "                                                            class=\"StyledTypography__Paragraph-sc-1un6cv3-4 dNVGMJ\"><span>Reply</span>\n" +
                                    "                                                        </p></a>\n" +
                                    "                                                    <div class=\"StyledPopover__PopoverMask-sc-1279jqe-7 knbWgb\"></div>\n" +
                                    "                                                </div>\n" +
                                    "                                            </div>\n" +
                                    "                                        </div>\n" +
                                    "                                    </div>\n" +
                                    "                                    {{--// for replay--}}\n" +
                                    "                                    <div  style=\"display: none\" class=\"reply-" + data.id + " reply StyledLayout__Box-b9gazd-0 dYGmnD\">\n" +
                                    "                                        <div class=\"StyledLayout__Box-b9gazd-0 dMahZL\">\n" +
                                    "                                            <div class=\"info StyledUserAvatar__UserAvatarWrapper-sc-1q2i94h-0 jXpWgu\"><a\n" +
                                    "                                                    href=\"\" style=\"line-height: 0;\"><img\n" +
                                    "                                                        alt=\"\"\n" +
                                    "                                                        src=\"{{ $user->photo}}\"\n" +
                                    "                                                        data-id=\"user-avatar\"\n" +
                                    "                                                        class=\"StyledUserAvatar__UserAvatarImage-sc-1q2i94h-1 qzlyw\"></a>\n" +
                                    "                                            </div>\n" +
                                    "                                            <div class=\"Elements__CommentInputWrapper-sc-1e3xy9t-19 hRAlPC\">\n" +
                                    "                                                        <textarea id=\"txtarea-" + data.id + "\"\n" +
                                    "                                                                  placeholder=\"Add a comment\"\n" +
                                    "                                                                  class=\"desc txtarea ant-input Elements__CommentInput-sc-1e3xy9t-21 kATyLo\"\n" +
                                    "                                                                  style=\"height: 52px; min-height: 52px; max-height: 152px;\"></textarea>\n" +
                                    "                                                <div\n" +
                                    "                                                    class=\"StyledIcons__StyledIcon-sc-1tde1rj-0 Elements__CommentInputIcon-sc-1e3xy9t-20 gakMEr\">\n" +
                                    "                                                    <i class=\"fas fa-2x fa-comment\"></i>\n" +
                                    "                                                </div>\n" +
                                    "                                            </div>\n" +
                                    "                                        </div>\n" +
                                    "                                        <div id=\"send\" class=\"StyledLayout__Box-b9gazd-0 kumJBc\">\n" +
                                    "                                            <a  style=\"cursor: pointer;\" id=\"cancel\" class=\"StyledLink-xjskmb-0 fhYBdP\"><span>انصراف</span>\n" +
                                    "                                            </a>\n" +
                                    "                                            <a style=\"cursor: pointer;\"\n" +
                                    "                                               onclick=\"comment('" + data.photo_id + "', '0', '" + data.id + "');\"\n" +
                                    "                                               disabled=\"\" data-id=\"photo-comment\" class=\"Elements__OldButton-tze21g-0 iCSAvO\"><span>ارسال</span>\n" +
                                    "                                            </a>\n" +
                                    "                                        </div>\n" +
                                    "                                    </div>");
                            } else {
                                $('.reply-' + child_id).toggle();
                                $('#cmd-' + child_id).after("<div id=\"cmd-" + data.parent_id + "\" class=\"StyledLayout__Box-b9gazd-0 jCpAGn\">\n" +
                                    "                                        <div>\n" +
                                    "                                            <div class=\"StyledUserAvatar__UserAvatarWrapper-sc-1q2i94h-0 ceVayd\"><a\n" +
                                    "                                                    href=\"\" style=\"line-height: 0;\"><img\n" +
                                    "                                                        alt=\"{{ $comment->user->name ?? '' }}\"\n" +
                                    "                                                        src=\"{{ $user->photo ?? '' }}\"\n" +
                                    "                                                        data-id=\"user-avatar\"\n" +
                                    "                                                        class=\"StyledUserAvatar__UserAvatarImage-sc-1q2i94h-1 dBxlhE\"></a>\n" +
                                    "                                            </div>\n" +
                                    "                                        </div>\n" +
                                    "                                        <div class=\"StyledLayout__Box-b9gazd-0 jbeXaE\">\n" +
                                    "                                            <div class=\"StyledLayout__Box-b9gazd-0 dZZYQd\"><a\n" +
                                    "                                                    href=\"\" class=\"StyledLink-xjskmb-0 CDvRO\">\n" +
                                    "                                                    <div>{{ $comment->user->name ?? '' }} {{ $comment->user->f_name ?? '' }}</div>\n" +
                                    "                                                </a>\n" +
                                    "                                                <p class=\"StyledTypography__Caption-sc-1un6cv3-5 lnRqSn\">\n" +
                                    "                                                    <span>" + data.created_at + "</span></p></div>\n" +
                                    "                                            <p class=\"StyledTypography__Paragraph-sc-1un6cv3-4 guluxS\">" + data.description + "</p>\n" +
                                    "                                            <div class=\"StyledLayout__Box-b9gazd-0 fSOPsj\">\n" +
                                    "                                                <div class=\"StyledLayout__Box-b9gazd-0 bymfaQ\" ><a onclick=\"showReply(" + data.id + ")\"\n" +
                                    "                                                                                                   id=\"reply-" + data.id + "\"\n" +
                                    "                                                                                                   class=\"StyledLink-xjskmb-0 cQVcgi\"><p\n" +
                                    "                                                            class=\"StyledTypography__Paragraph-sc-1un6cv3-4 dNVGMJ\"><span>Reply</span>\n" +
                                    "                                                        </p></a>\n" +
                                    "                                                    <div class=\"StyledPopover__PopoverMask-sc-1279jqe-7 knbWgb\"></div>\n" +
                                    "                                                </div>\n" +
                                    "                                            </div>\n" +
                                    "                                        </div>\n" +
                                    "                                    </div>\n" +
                                    "                                    {{--// for replay--}}\n" +
                                    "                                    <div  style=\"display: none\" class=\"reply-" + data.id + " reply StyledLayout__Box-b9gazd-0 dYGmnD\">\n" +
                                    "                                        <div class=\"StyledLayout__Box-b9gazd-0 dMahZL\">\n" +
                                    "                                            <div class=\"info StyledUserAvatar__UserAvatarWrapper-sc-1q2i94h-0 jXpWgu\"><a\n" +
                                    "                                                    href=\"\" style=\"line-height: 0;\"><img\n" +
                                    "                                                        alt=\"\"\n" +
                                    "                                                        src=\"{{ $user->photo ?? ''}}\"\n" +
                                    "                                                        data-id=\"user-avatar\"\n" +
                                    "                                                        class=\"StyledUserAvatar__UserAvatarImage-sc-1q2i94h-1 qzlyw\"></a>\n" +
                                    "                                            </div>\n" +
                                    "                                            <div class=\"Elements__CommentInputWrapper-sc-1e3xy9t-19 hRAlPC\">\n" +
                                    "                                                        <textarea id=\"txtarea-" + data.id + "\"\n" +
                                    "                                                                  placeholder=\"Add a comment\"\n" +
                                    "                                                                  class=\"desc txtarea ant-input Elements__CommentInput-sc-1e3xy9t-21 kATyLo\"\n" +
                                    "                                                                  style=\"height: 52px; min-height: 52px; max-height: 152px;\"></textarea>\n" +
                                    "                                                <div\n" +
                                    "                                                    class=\"StyledIcons__StyledIcon-sc-1tde1rj-0 Elements__CommentInputIcon-sc-1e3xy9t-20 gakMEr\">\n" +
                                    "                                                    <i class=\"fas fa-2x fa-comment\"></i>\n" +
                                    "                                                </div>\n" +
                                    "                                            </div>\n" +
                                    "                                        </div>\n" +
                                    "                                        <div id=\"send\" class=\"StyledLayout__Box-b9gazd-0 kumJBc\">\n" +
                                    "                                            <a  style=\"cursor: pointer;\" id=\"cancel\" class=\"StyledLink-xjskmb-0 fhYBdP\"><span>انصراف</span>\n" +
                                    "                                            </a>\n" +
                                    "                                            <a style=\"cursor: pointer;\"\n" +
                                    "                                               onclick=\"comment('" + data.photo_id + "', '0', '" + data.id + "');\"\n" +
                                    "                                               disabled=\"\" data-id=\"photo-comment\" class=\"Elements__OldButton-tze21g-0 iCSAvO\"><span>ارسال</span>\n" +
                                    "                                            </a>\n" +
                                    "                                        </div>\n" +
                                    "                                    </div>");
                            }

                            $('.txtarea').val('');
                        }
                    })
                }

                @endif
                function rate(event, id, val) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('rate.add') }}',
                        data: {'_token': '<?php echo csrf_token()?>', 'id': id, 'val': val},
                        success: function (data) {
                            $('#count').text(data);
                            if (val == 0) {
                                $('#like i').removeAttr('hidden');
                                $('#like').removeAttr('hidden');
                                $('#dis_like i').attr('hidden', 'hidden');
                                $('#dis_like').attr('hidden', 'hidden');
                            } else {
                                $('#dis_like i').removeAttr('hidden');
                                $('#dis_like').removeAttr('hidden');
                                $('#like i').attr('hidden', 'hidden');
                                $('#like').attr('hidden', 'hidden');
                            }
                            // document.getElementById('#count').innerText=data;
                        },

                    })

                }

            </script>

@endsection
