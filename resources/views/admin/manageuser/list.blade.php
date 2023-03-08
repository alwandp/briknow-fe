{{-- TIDAK TERPAKAI, ADA DI BACKEND YG DIPAKAI --}}
@php
    $first = !empty($data)?reset($data->data->data):null;
    $last = !empty($data)?end($data->data->data):null;
    //dd($data->data);
@endphp
@forelse ($data->data->data as $user)
    @if($user == $first)
        <tr class="py-2 content-list">
            <td style="border-left: 1px solid rgba(214, 214, 214, 1);">
                @php $tempava = $user->avatar_id; @endphp
                <img src="{{asset_app("assets/img/gamification/avatar/avatar $tempava.png")}}"  class="rounded-circle border-0" width="44px">
            </td>
            <td><div>{{$user->name??"-"}}</div></td>
            <td>
                <div>
                    @if($user->role == 1)
                    Super Admin
                    @elseif($user->role == 2)
                    Maker
                    @elseif($user->role == 3)
                    Checker
                    @elseif($user->role == 4)
                    Signer
                    @else
                    User
                    @endif
                </div>
            </td>
            <td><div>Semua</div></td>
            <td><div>{{$user->email}}</div></td>
            <td><div>0896-7098-3489</div></td>
            <td style="border-right: 1px solid rgba(214, 214, 214, 1);">
                <button type="button" class="btn m-1 btn-primary" data-toggle="modal" data-target="#staticBackdrop" data-keyboard="true" onClick='getData({{$user->id}})'><i class="fas fa-pencil-alt"></i></button>
                <button type="button" class="btn m-1 btn-danger" onClick='hapus({{$user->id}})'><i class="far fa-trash-alt"></i></button>
            </td>
        </tr>
    @elseif ($user == $last)
        <tr class="py-2 content-list">
            <td style="border-left: 1px solid rgba(214, 214, 214, 1); border-end-start-radius: 12px;">
                @php $tempava = $user->avatar_id; @endphp
                <img src="{{asset_app("assets/img/gamification/avatar/avatar $tempava.png")}}"  class="rounded-circle border-0" width="44px">
            </td>
            <td><div>{{$user->name??"-"}}</div></td>
            <td>
                <div>
                    @if($user->role == 1)
                    Super Admin
                    @elseif($user->role == 2)
                    Maker
                    @elseif($user->role == 3)
                    Checker
                    @elseif($user->role == 4)
                    Signer
                    @else
                    User
                    @endif
                </div>
            </td>
            <td><div>Semua</div></td>
            <td><div>{{$user->email}}</div></td>
            <td><div>0896-7098-3489</div></td>
            <td style="border-right: 1px solid rgba(214, 214, 214, 1); border-end-end-radius: 12px;">
                <button type="button" class="btn m-1 btn-primary" data-toggle="modal" data-target="#staticBackdrop" data-keyboard="true" onClick='getData({{$user->id}})'><i class="fas fa-pencil-alt"></i></button>
                <button type="button" class="btn m-1 btn-danger" onClick='hapus({{$user->id}})'><i class="far fa-trash-alt"></i></button>
            </td>
        </tr>
    @else
        <tr class="py-2 content-list">
            <td style="border-left: 1px solid rgba(214, 214, 214, 1);">
                @php $tempava = $user->avatar_id; @endphp
                <img src="{{asset_app("assets/img/gamification/avatar/avatar $tempava.png")}}"  class="rounded-circle border-0" width="44px">
            </td>
            <td><div>{{$user->name??"-"}}</div></td>
            <td>
                <div>
                    @if($user->role == 1)
                    Super Admin
                    @elseif($user->role == 2)
                    Maker
                    @elseif($user->role == 3)
                    Checker
                    @elseif($user->role == 4)
                    Signer
                    @else
                    User
                    @endif
                </div>
            </td>
            <td><div>Semua</div></td>
            <td><div>{{$user->email}}</div></td>
            <td><div>0896-7098-3489</div></td>
            <td style="border-right: 1px solid rgba(214, 214, 214, 1);">
                <button type="button" class="btn m-1 btn-primary" data-toggle="modal" data-target="#staticBackdrop" data-keyboard="true" onClick='getData({{$user->id}})'><i class="fas fa-pencil-alt"></i></button>
                <button type="button" class="btn m-1 btn-danger" onClick='hapus({{$user->id}})'><i class="far fa-trash-alt"></i></button>
            </td>
        </tr>
    @endif
@empty
    <tr class="py-2 content-list">
        <td style="border-left: 1px solid rgba(214, 214, 214, 1);">
                <img src="{{asset_app('assets/img/avatar/avatar-1.png')}}" class="rounded-circle border-0" width="44px">
        </td>
        <td><div>-</div></td>
        <td><div>-</div></td>
        <td><div>-</div></td>
        <td><div>-</div></td>
        <td><div>-</div></td>
        <td style="border-right: 1px solid rgba(214, 214, 214, 1);">-</td>
    </tr>
@endforelse

{{-- {{$data->data->links()}} --}}