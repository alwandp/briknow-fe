<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="pages" content="{{ url('') }}">
  <meta name="BE" content="{{ config('app.url_be') }}">
  <meta name="csrf" content="@yield('csrf',csrf_token())">
  <meta name="kunci" content="@yield('kunci','*')">
  <title>@yield('title',config('app.name'))</title>
  <link rel="icon" type="image/png" href="{{asset_app('assets/img/logo/Logo BRI.png')}}" />
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset_app('css/app.css')}}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset_app('assets/css/temp/style.css')}}">
  <link rel="stylesheet" href="{{asset_app('assets/css/temp/components.css')}}">
  <link rel="stylesheet" href="{{asset_app('assets/css/adm.css')}}">
  <link rel="stylesheet" href="{{ asset_app('assets/css/fa.css') }}"/>
  @isset($congrats->achievements_id)
    {{-- congrats --}}
    <link rel="stylesheet" href="{{asset_app('assets/css/congrats.css')}}">
  @endisset
  @stack('style')
</head>
<body>
  <div class="senddataloader">
    <div class="loading">
      <img src="{{asset_app('assets/img/senddataloader.gif')}}" style="width:50px;height:50px">
    </div>
  </div>
  @isset($congrats->achievements_id)
    <div class="layar-back">
        <div id="tsparticles"></div>
        <div class="congrats">
            <h1>Congratulations!</h1>
        </div>
        <div class="message-congrats">
            <div class="d-flex justify-content-center">
                <img src="{{asset_app($congrats->achievement->badge)}}" width="120px" style="z-index: 999;" alt="">
            </div>
            <h3 class="name-badge mb-0">{{$congrats->achievement->name}}</h3>
            <h6 class="task-badge mb-3">{{$congrats->achievement->activity->name}} Sebanyak {{$congrats->achievement->value}} Kali</h6>
            <div class="d-flex justify-content-center">
                <button class="btn btn-warning btn-continue">Continue</button>
            </div>
        </div>
    </div>
  @endisset
  <div id="app">
    <div class="main-wrapper">
      <nav class="navbar navbar-expand-lg main-navbar bg-primary">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav">
            <li>
              <a href="{{route('home')}}">
                <img src="{{asset_app('assets/img/logo/bri know white.png')}}" draggable="false" width="75%">
              </a>
            </li>
            <li><a href="#" data-toggle="sidebar" class="pl-0 pr-0 nav-link nav-link-lg" id="trigger-sidebar"><i class="fas fa-bars"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right align-items-center">
          <li class="dropdown">
            <a href="{{route('kontribusi')}}" class="btn bg-white addin btn-sm" role="button" aria-pressed="true"><i class="fas fa-upload mr-1"></i>Upload Dokumen</a>
          </li>
          @include('layouts.notifikasi')
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}" draggable="false" class="rounded-circle mr-1">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              @php
              if (session('role') == 3) {
                  $role = 'Admin';
              } else {
                  $role = 'User';
              }
              @endphp
              <div class="dropdown-item">
                  <a href="{{route('home.profile')}}" class="d-flex justify-content-left align-items-center w-100 text-decoration-none">
                      <div class="d-flex align-items-center mr-2">
                      <img alt="image" src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}" draggable="false" width="30px" class="rounded-circle icon-user-navbar mr-1">
                      </div>
                      <div>
                          <div>
                              <small class="d-block lh-10 text-dark">{{\Str::limit(session('username'),15)}}</small>
                          </div>
                          <div class="lh-20 d-flex align-items-center mt-1">
                              <span class="badge badge-info px-1 py-0"><small>{{$role}}</small></span>
                          </div>
                      </div>
                  </a>
              </div>
              <div class="dropdown-divider my-1"></div>
              <a href="{{ route('home') }}" class="dropdown-item">Home</a>
              <a href="#" data-toggle='modal' data-target='#editprofil' class="dropdown-item">Edit Profile</a>
              <a href="{{ route('myproject') }}" class="dropdown-item">My Project</a>
              <a href="{{ route('mycomsupport.myimplementation') }}" class="dropdown-item">My Implementation</a>
              <a href="{{ route('myfavorite') }}" class="dropdown-item">My Favorite</a>
              <a href="{{ route('forum.index') }}" class="dropdown-item">Forum</a>
              @if(session('role') == 3)
                <a href="{{ route('dashboard.performance') }}" class="dropdown-item">Dashboard Admin</a>
              @endif
              <div class="dropdown-divider"></div>
              <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                  <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-forum">
        <aside id="sidebar-wrapper">
          <ul class="sidebar-menu text-center border-bottom nav-back-forum sticky-top bg-white">
                <li class="nav-item d-flex justify-content-start align-items-center dropdown">
                    <a href="{{route('katalog.index')}}" class="text-left menu-kiri w-25 d-flex justify-content-center text-decoration-none" tabindex="-1" role="button">
                        <svg class="w-6 h-6" width="35px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <span class="f-15 text-primary"><a href="{{route('home')}}" class="text-decoration-none p-0 ">Home</a> / Forum</span>
                </li>
            </ul>

            <ul class="sidebar-menu text-center mt-2">
              @yield('myforum')
            </ul>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content forum">
        <section class="section">
          <div class="section-body">
            @yield('content')
          </div>
        </section>
        <div class="w-100" id="popupin">
          @yield('popup')
        </div>
      </div>
    </div>
    @include('layouts.edit_profile')
  </div>

  <!-- General JS Scripts -->
  <script src="{{asset_app('js/app.js')}}"></script>
  <script src="{{asset_app('assets/js/plugin/jquery.nicescroll.min.js')}}"></script>

  <script src="{{asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js')}}"></script>
  @isset($congrats->achievements_id)
    {{-- congrats --}}
    <script src="{{asset_app('assets/js/plugin/TweenMax.min.js')}}" ></script>
    <script type="text/javascript" src="{{asset_app('assets/js/plugin/lodash.min.js')}}"></script>
    <script src="{{asset_app('assets/js/congrats.js')}}" ></script>
    <script>
        $('.btn-continue').click(function(){
          var token_congrats  = "{{session('token')}}";
          var id_congrats     = "{{$congrats->id}}";
          var be_congrats     = "{{config('app.url')}}";
          // update
          var url = `${be_congrats}congrats`;
          $.ajax({
              url: url,
              type: "post",
              data: {id:id_congrats, token:token_congrats},
              beforeSend: function(xhr)
              {
                  xhr.setRequestHeader("X-CSRF-TOKEN",csrf);
                  $('.layar-back').hide();
              },
              success: function(data){
                  console.log(data.data.message);
              },
              error : function(e){
                  console.log(e.responseJSON.message);
              }
          });
        });
      </script>
  @endisset
  @if (Session::has('error'))
    <script>
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });

      var tampung = `{{ Session::get('error')}}`;
      Toast.fire({icon: 'error',title: tampung});
    </script>
  @endif
  @if (Session::has('success'))
    <script>
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });

      var tampung = `{{ Session::get('success')}}`;
      Toast.fire({icon: 'success',title: tampung});
    </script>
  @endif
  <!-- JS page -->
  @stack('page-script')
  <!-- Template JS File -->
  <script src="{{asset_app('assets/js/temp/scripts2.js')}}"></script>
  <script src="{{asset_app('assets/js/temp/custom.js')}}"></script>
  <script src="{{asset_app('assets/js/page/notification.js')}}"></script>
</body>
</html>
