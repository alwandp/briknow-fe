1<li class="dropdown">
    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user dropdown-myforum text-dark d-flex justify-content-center">
        <div class="d-flex align-items-center">
            <img alt="image" src="{{asset_app('assets/img/notif-icon.png')}}" @isset($count_unread)@if($count_unread > 0) id="read_notif" @endif @endisset class="w-75">
        </div>
        @isset($count_unread)
            @if($count_unread > 0)
                <label class="push-pop">{{$count_unread}}</label>
            @endif
        @endisset
    </a>
    <div class="dropdown-menu dropdown-menu-right" style="width:380px !important;">
        <div class="border-bottom border-black px-2">
            Notifications
        </div>
        <div class="dropdown-divider my-1"></div>
        <div class="w-100 h-100 notifikasi-content">
            @forelse($allnotification as $item)                                    
                @if($item->direct <> null)<a href="{{$item->direct}}" class="w-100 text-decoration-none">@endif
                    <div class="d-flex justify-content-start px-2" style="cursor: pointer;">
                        <div class="px-2">
                            <img alt="image" src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}" draggable="false" width="30px" class="rounded-circle icon-user-navbar mr-1">
                        </div>
                        <div>
                            <div>
                                <small class="d-block lh-15 text-wrap text-dark">{!!$item->pesan!!}</small>
                            </div>
                            <div class="lh-20 d-flex align-items-center">
                                <small class="text-secondary">{{\Carbon\carbon::create($item->created_at)->diffForHumans()}}</small>
                            </div>
                        </div>
                    </div>
                @if($item->direct <> null)</a>@endif
            @empty
                <div class="d-flex justify-content-center px-2">
                    <small>Notifikasi Masih Kosong</small>
                </div>
            @endforelse
        </div>
    </div>
</li>