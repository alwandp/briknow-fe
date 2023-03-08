@extends('layouts.master')
@section('title', 'BRIKNOW')
@section('csrf',csrf_token())

@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/gamification.css')}}">
@endpush

@section('breadcumb', 'Forum / Gamification')
@section('back', route('home.profile'))

@section('content')
    <div class="row judul">
        <div class="col-md-12">
            <h3 id="nama-kanan">Gamification Details</h3>
            <span class="font-weight-bold text-black-50">
                BRIKNOW / {{\Carbon\Carbon::now()->format('d F Y')}}
            </span>
        </div>

        <hr class="w-100 pb-2">

        <div class="col-md-12 text-justify">
            <h5>Experience Points (XP)</h5>
            <p>
                Setiap user yang menggunakan BRIKNOW akan mendapatkan Experience Points (XP) dengan cara menyelesaikan aktivitas tertentu. Jumlah XP yang diperoleh akan dihitung dengan menggunakan perhitungan berikut:
            </p>
            <div class="table-responsive">
            
                <table class="table table-striped bordered">
                    <thead>
                        <tr>
                            <th scope="col">Activities</th>
                            <th scope="col">XP Earned</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data->activity as $activity)
                            <tr>
                                <td>{{$activity->name}}</td>
                                <td>{{$activity->xp}}</td>
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
            <p>
                *) Jumlah XP pada tabel tersebut dapat berubah sewaktu-waktu demi memaksimalkan pengalaman pengguna yang lebih baik.
            </p>
            <h5>Level</h5>
            <p>
                XP yang telah didapatkan oleh user akan diakumulasikan. Jika seorang user telah mengumpulkan XP yang dibutuhkan dalam jumlah tertentu, maka user akan naik ke level berikutnya. Jenis dan jumlah kebutuhan XP untuk setiap level adalah sebagai berikut:
            </p>
            <div class="table-responsive">
                <table class="table table-striped bordered">
                    <thead>
                        <tr>
                            <th scope="col">Level</th>
                            <th scope="col">Requirement</th>
                            <th scope="col">Badge</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data->levels as $level)
                            <tr>
                                <td>{{$level->name}}</td>
                                <td>{{$level->xp}} XP</td>
                                <td><img draggable='false'src="{{asset_app($level->badge)}}" alt="{{$level->name}}" class="img-fluid"></td>
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
            <h5>Achievement</h5>
            <p>
                Achievement dalam bentuk badge akan didapatkan dengan menyelesaikan tantangan tertentu. Jenis achievement, tantangan dan reward yang diberikan adalah sebagai berikut:
            </p>
            <div class="table-responsive">
                <table class="table table-striped bordered">
                    <thead>
                        <tr>
                            <th scope="col">Achievement</th>
                            <th scope="col">Task</th>
                            <th scope="col">Badge</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data->achievements as $achievements)
                            <tr>
                                <td>{{$achievements->name}}</td>
                                <td>{{$achievements->activity->name}} Sebanyak {{$achievements->value}} Kali</td>
                                <td><img draggable='false'src="{{asset_app($achievements->badge)}}" alt="{{$achievements->name}}" class="img-fluid logo-achievements"></td>
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
@endsection

@push('page-script')
    <script src="{{asset_app('assets/js/page/forum-profile.js')}}"></script>
@endpush