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

            @include('layouts.alert')

            <div class="card" id="level-config">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h5>Level Configuration</h5>
                        </div>
                        <div class="ml-auto">
                            <a href="{{route('managegamification_edit')}}" style="text-decoration: none; cursor: pointer;">
                                <img src="{{asset_app('assets/img/edit_pencil.svg')}}" alt="Edit" class="img-fluid">
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive px-0">
                        <table class="table table-striped bordered">
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
                                        <td>{{$level->name}}</td>
                                        <td>{{$level->xp}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card" id="activity-config">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h5>XP Configuration</h5>
                        </div>
                        <div class="ml-auto">
                            <a href="{{route('managegamification_edit')}}" style="text-decoration: none; cursor: pointer;">
                                <img src="{{asset_app('assets/img/edit_pencil.svg')}}" alt="Edit" class="img-fluid">
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive px-0">
                        <table class="table table-striped bordered">
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
                                        <td>{{$act->name}}</td>
                                        <td>{{$act->xp}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card" id="achievement-config">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h5>Achievement Configuration</h5>
                        </div>
                        <div class="ml-auto">
                            <a href="{{route('managegamification_edit')}}" style="text-decoration: none; cursor: pointer;">
                                <img src="{{asset_app('assets/img/edit_pencil.svg')}}" alt="Edit" class="img-fluid">
                            </a>
                        </div>
                    </div>
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
                                        <td>{{$achievements->name}}</td>
                                        <td>{{$achievements->activity->name}}</td>
                                        <td>{{$achievements->value}}</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('popup')
    <!-- Modal -->
@endsection
@push('page-script')
    {{-- <script src="{{asset_app('assets/js/page/managegamification.js')}}"></script> --}}
@endpush
