<?php $urut = 0; ?>
@forelse ($data->forumcomment as $value)
    <?php $urut++; ?>
    <div class="col-md-12" id="comment-{{$urut}}">
        <!-- KOMENTAR 1 -->
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-left pt-2">
                            <div class="profile-comment d-flex align-items-center">
                                @php $tempava = $value->user->avatar_id; @endphp
                                <img alt="image" src="{{asset_app("assets/img/gamification/avatar/avatar $tempava.png")}}" width="40px" class="rounded-circle p-0 mr-2 detail-ava">
                                <label class="font-weight-bolder mb-0">{{$value->user->name}}</label> &middot;
                                <small class="text-secondary">{{\Carbon\Carbon::create($value->created_at)->diffForHumans()}}</small>
                            </div>
                            <div class="subforum w-100">
                                <div class="py-2 text-justify comment-sub-1">
                                    {!!$value->comment??'-'!!}
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

                                {{-- sub comment --}}
                                <?php $urut2 = $urut; ?>
                                @forelse($value->child as $value2)
                                    <?php $urut2++; ?>
                                    <div class="w-100 sub-comment-{{$urut}} comment-{{$urut2}} d-n">
                                        <div class="profile-comment d-flex align-items-center">
                                            @php $tempava = $value2->user->avatar_id; @endphp
                                            <img alt="image" src="{{asset_app("assets/img/gamification/avatar/avatar $tempava.png")}}" width="40px" class="rounded-circle p-0 mr-2 detail-ava">
                                            <label class="font-weight-bolder mb-0">{{$value2->user->name}}</label> &middot;
                                            <small class="text-secondary">{{\Carbon\Carbon::create($value2->created_at)->diffForHumans()}}</small>
                                        </div>
                                    </div>
                                    <div class="subforum sub-comment-{{$urut}} comment-{{$urut2}} d-n w-100">
                                        <div class="py-2 text-justify comment-sub-2">
                                            {!!$value2->comment??'-'!!}
                                        </div>
                                        <div class="px-0 w-100 d-flex justify-content-between reply-sub-1 reply-{{$urut2}}">
                                            <div>
                                                @if(count($value2->child) > 0)
                                                    <button class="btn bg-white px-0" type="button" id="handle-comment-{{$urut2}}" onclick="showc('comment-{{$urut2}}');">
                                                    <span class="label-handle-comment-{{$urut2}}">
                                                        <svg class="w-6 h-6" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> {{count($value2->child)??0}} Replies
                                                    </span>
                                                    </button>
                                                @endif
                                            </div>
                                            <button class="btn bg-white px-0 reply{{$urut2}}" onclick="reply(this);" id="{{$urut2}}" data-parent="{{$value2->id}}" data-prj="{{$data->id}}" data-reply="{{$value2->user->personal_number}}" style="text-decoration: none;">Reply</button>
                                        </div>
                                        
                                        <?php $urut3 = $urut2; ?>
                                            @forelse($value2->child as $value3)
                                                <?php $urut3++; ?>
                                                <div class="w-100 sub-comment-{{$urut2}} comment-{{$urut3}} d-n">
                                                    <div class="profile-comment d-flex align-items-center">
                                                        @php $tempava = $value3->user->avatar_id; @endphp
                                                        <img alt="image" src="{{asset_app("assets/img/gamification/avatar/avatar $tempava.png")}}" width="40px" class="rounded-circle p-0 mr-2 detail-ava">
                                                        <label class="font-weight-bolder mb-0">{{$value3->user->name}}</label> &middot;
                                                        <small class="text-secondary">{{\Carbon\Carbon::create($value3->created_at)->diffForHumans()}}</small>
                                                    </div>
                                                </div>
                                                <div class="subforum sub-comment-{{$urut2}} comment-{{$urut3}} d-n">
                                                    <div class="py-2 text-justify">
                                                        {!!$value3->comment??'-'!!}
                                                    </div>
                                                </div>
                                                <div class="px-0 w-100 d-flex justify-content-between reply-sub-2 reply-{{$urut3}}">
                                                    <div>
                                                    </div>
                                                </div>
                                            @empty
                                            @endforelse
                                        <?php $urut2 = $urut3; ?>
                                    </div>
                                @empty
                                @endforelse
                                {{-- /sub comment --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- END -->
    <?php $urut = $urut2; ?>
</div>
@empty
@endforelse