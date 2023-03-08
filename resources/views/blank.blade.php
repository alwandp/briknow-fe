@extends('layouts.master')
@section('title', 'BRIKNOW')
@push('style')
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa.css') }}">
    <style>
        .navbar-bg{
            height:auto;
            background-color: #0e3984;
        }
    </style>
@endpush
@section('content')
<div class="navbar-bg">
    <div class="d-flex justify-content-between">
        <div>
            <a href="{{ route('home') }}">
                <img src="{{ asset_app('assets/img/logo/bri know white.png') }}"
                    class="mt-3 ml-3" alt="" />
            </a>
        </div>
        <div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="{{asset_app('assets/img/avatar/avatar-1.png')}}" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, {{ session('username') }}
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-title">
                                {{ \Carbon\Carbon::parse(session('login_at'))->diffForHumans() }}
                            </div>
                            <a href="features-profile.html" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <a href="features-activities.html" class="dropdown-item has-icon">
                                <i class="fas fa-bolt"></i> Activities
                            </a>
                            <a href="features-settings.html" class="dropdown-item has-icon">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}"
                                class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Blank Page</h1>
      </div>

      <div class="section-body">
      </div>
    </section>
  </div>
@endsection
