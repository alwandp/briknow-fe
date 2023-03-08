@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-admin.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <style>
        img {
            border-radius: inherit;
        }
    </style>
@endpush

@section('breadcumb', 'Admin')
@section('back', route('home'))
@section('csrf',session()->get('token')??"")

@section('content')
    <div class="row">
        <div class="col-md-12" id="konten">
            <div class="d-flex bd-highlight mt-3">
                <div class="mr-auto p-2 bd-highlight">
                    <h3>Manage Gamification</h3>
                </div>
            </div>

            <form action="{{route('dashboard.gamesave_level')}}" id="form-level"  method="post" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="card" id="level-config">
                    <div class="card-body">
                        <h5>Level Configuration</h5>
                        <div class="table-responsive px-0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Badge</th>
                                        <th scope="col">Level</th>
                                        <th scope="col">Requirement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data->levels as $level)
                                        <input type="hidden" name="level_id[]" value="{{$level->id}}">
                                        <tr>
                                            <td><img src="{{asset_app($level->badge)}}" alt="" class="badge-achievement"></td>
					    <td><input type="text" class="form-control w-100" name="level_name[]" value="{{$level->name}}" placeholder="Nama Level" /></td>
                                            <td><input type="text" class="form-control w-100" name="level_xp[]" value="{{$level->xp}}" placeholder="Minimum XP" {{ $level->id == 1 ? 'readonly' : ''}} /></td>
					</tr>
                                    @empty
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end px-3">
                                <a href="{{route('managegamification')}}" class="btn btn-secondary mx-2" role="button">Discard</a>
                                <button type="button" class="btn btn-primary mx-2" id="btn-submit-level">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form action="{{route('dashboard.gamesave_activity')}}" id="form-act"  method="post" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="card" id="activity-config">
                    <div class="card-body">
                        <h5>XP Configuration</h5>
                        <div class="table-responsive px-0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Activity</th>
                                        <th scope="col">XP Earned</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data->activities as $act)
                                    <input type="hidden" name="act_id[]" value="{{$act->id}}">
                                        <tr>
                                            <td><input type="text" class="form-control w-100" name="activity[]" value="{{$act->name}}" placeholder="Nama Level" /></td>
                                            <td><input type="text" class="form-control w-100" name="xp_earned[]" value="{{$act->xp}}" placeholder="Target XP" /></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end px-3">
                                <a href="{{route('managegamification')}}" class="btn btn-secondary mx-2" role="button">Discard</a>
                                <button type="button" class="btn btn-primary mx-2" id="btn-submit-activity">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form action="{{route('dashboard.gamesave_achievement')}}" id="form-ach"  method="post" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="card" id="achievement-config">
                    <div class="card-body">
                        <h5>Achievement Configuration</h5>
                        <div class="table-responsive">
                            <table class="table table-striped bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Badge</th>
                                        <th scope="col">Achievement</th>
                                        <th scope="col">Task</th>
                                        <th scope="col">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data->achievements as $achievements)
                                    <input type="hidden" name="ach_id[]" value="{{$achievements->id}}">
                                        <tr>
                                            <td><img src="{{asset_app($achievements->badge)}}" alt="" class="badge-achievement"></td>
                                            <td><input type="text" class="form-control w-100" name="achievement[]" value="{{$achievements->name}}" placeholder="Nama Achievement" /></td>
                                            <td>{{$achievements->activity->name}}</td>
                                            <td><input type="text" class="form-control w-100" name="reward_value[]" value="{{$achievements->value}}" placeholder="Value XP" /></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end px-3">
                                <a href="{{route('managegamification')}}" class="btn btn-secondary mx-2" role="button">Discard</a>
                                <button type="button" class="btn btn-primary mx-2" id="btn-submit-achievement">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('popup')
    <!-- Modal -->
@endsection
@push('page-script')
    <script src="{{asset_app('assets/js/page/managegamification.js')}}"></script>
@endpush
