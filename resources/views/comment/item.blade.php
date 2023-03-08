    <div class="card shadow">
        <form action="#" class="form" onsubmit="komen(event,this,'',{{$data->id}},'');">
            <div class="card-header d-flex">
                <div>
                  <img alt="image" src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}" draggable="false" width="30px" class="rounded-circle icon-user-navbar mr-1">
                </div>
                <div class="pl-2">
                    <b>{{session('username')}}</b>
                </div>
            </div>
            <div class="px-3 pt-3">
                <textarea class="px-0 w-100 commentform" name="komentar" placeholder="Tulis komentar" data-emoji-input="unicode" data-emojiable="true" required></textarea>
            </div>
            <div class="d-flex justify-content-end px-3 py-2">
                <button type="submit" class="btn btn-primary btn-sm">Comment</button>
            </div>
        </form>
    </div>
    <hr>
    <?php $urut = 0; ?>
    @forelse($data->comment as $value)
    <?php $urut++; ?>
    <div id="comment-{{$urut}}">
        <div class="border-bottom pb-3">
            <div class="d-flex px-0" id="header-comment">
                <div>
                    @php $tempava = $value->user->avatar_id; @endphp
                    <img alt="image" src="{{asset_app("assets/img/gamification/avatar/avatar $tempava.png")}}" draggable="false" width="30px" class="rounded-circle icon-user-navbar mr-1">
                </div>
                <div class="pl-2">
                <b>{{$value->user->name??'-'}}</b>
                </div>
            </div>
            <div class="px-0 pt-2">
                @empty($value->reply_user)
                <p id="comment-x">{{ $value->comment??'-' }}</p>
                @else
                <p id="comment-x">{!!"<h6><span class='badge badge-secondary p-1 mr-1'>".$value->reply_user->name."</span></h6>"??''!!}{{ $value->comment??'-' }}</p>
                @endempty
            </div>
            <div class="px-0 w-100 d-flex justify-content-between reply-{{$urut}}">
                <div>
                @if(count($value->child) > 0)
                    <button class="btn bg-white px-0" type="button" id="handle-comment-{{$urut}}" onclick="showc('comment-{{$urut}}');">
                    <span class="label-handle-comment-{{$urut}}">
                        <svg class="w-6 h-6" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> {{count($value->child)??0}} Replies
                    </span>
                    </button>
                @endif
                </div>
                <button class="btn bg-white px-0 reply{{$urut}}" onclick="reply(this);" id="{{$urut}}" data-parent="{{$value->id}}" data-prj="{{$data->id}}" data-reply="{{$value->user->personal_number}}" style="text-decoration: none;">Reply</button>
            </div>
            <?php $urut2 = $urut; ?>
            @forelse($value->child as $value2)
                <?php $urut2++; ?>
                <div class="sub sub-comment-{{$urut}} comment-{{$urut2}} d-n">
                <div class="d-flex px-0 pl-1" id="header-comment">
                    <div>
                        @php $tempava = $value2->user->avatar_id; @endphp
                        <img alt="image" src="{{asset_app("assets/img/gamification/avatar/avatar $tempava.png")}}" draggable="false" width="30px" class="rounded-circle icon-user-navbar mr-1">
                    </div>
                    <div class="pl-2">
                    <b>{{$value2->user->name??'-'}}</b>
                    </div>
                </div>
                <div class="px-0 pl-1">
                    @empty($value2->reply_user)
                    <p id="comment-x">{{ $value2->comment??'-'  }}</p>
                    @else
                    <p id="comment-x">{!!"<span class='badge badge-secondary p-1 mr-1'>".$value2->reply_user->name."</span>"??''!!}{{ $value2->comment??'-'}}</p>
                    @endempty
                </div>
                <div class="px-0 pl-1 w-100 d-flex justify-content-between reply-{{$urut2}}">
                    <div>
                    @if(count($value2->child) > 0)
                        <button class="btn bg-white px-0" type="button" id="handle-comment-{{$urut2}}" onclick="showc('comment-{{$urut2}}');">
                        <span class="label-handle-comment-{{$urut2}}">
                            <svg class="w-6 h-6" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> {{count($value2->child)??0}} Replies
                        </span>
                        </button>
                    @endif
                    </div>
                    <button class="btn bg-white reply{{$urut2}} px-0" onclick="reply(this);" id="{{$urut2}}" data-parent="{{$value2->id}}" data-prj="{{$data->id}}" data-reply="{{$value2->user->personal_number}}" style="text-decoration: none;">Reply</button>
                </div>
                <?php $urut3 = $urut2; ?>
                @forelse($value2->child as $value3)
                    <?php $urut3++; ?>
                    <div class="sub sub-comment-{{$urut2}} comment-{{$urut3}} d-n">
                    <div class="d-flex px-0 pl-1" id="header-comment">
                        <div>
                            @php $tempava = $value3->user->avatar_id; @endphp
                            <img alt="image" src="{{asset_app("assets/img/gamification/avatar/avatar $tempava.png")}}" draggable="false" width="30px" class="rounded-circle icon-user-navbar mr-1">
                        </div>
                        <div class="pl-2">
                        <b>{{$value3->user->name??'-'}}</b>
                        </div>
                    </div>
                    <div class="px-0 pl-1">
                        @empty($value3->reply_user)
                        <p id="comment-x">{{ $value3->comment??'-'  }}</p>
                        @else
                        <p id="comment-x">{!!"<span class='badge badge-secondary p-1 mr-1'>".$value3->reply_user->name."</span>"??''!!}{{ $value3->comment??'-' }}</p>
                        @endempty
                    </div>
                    <div class="px-0 pl-1 w-100 d-flex justify-content-between reply-{{$urut3}}">
                        <div></div>
                        <div></div>
                    </div>
                    </div>
                @empty
                @endforelse
                <?php $urut2 = $urut3; ?>
                </div>
            @empty
            @endforelse
        </div>
    </div>
    <?php $urut = $urut2; ?>
    @empty
    <div class="w-100 d-flex justify-content-center text-secondary">
        Belum Ada Komentar
    </div>
    @endforelse