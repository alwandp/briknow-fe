<div class="navbar-bg">
    <div class="d-flex justify-content-between">
        <div>
            <img src="{{asset_app('assets/img/logo/bri know white.png')}}" class="mt-3 ml-3" alt="">
        </div>
        <div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="{{asset_app('assets/img/avatar/avatar-1.png')}}" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, {{session('username')}}</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-title">Logged in 5 min ago</div>
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
                            <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="mb-4">w
        <div class="col-md-12 d-flex justify-content-center">
            <h2 class="font-weight-normal text-white text-center">
                {{-- Welcome to,<br> --}}
                <br>
                <div class="bri-welcome">
                    <strong>BRI Knowledge Center</strong>
                </div>
            </h2>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-search fa-lg" aria-hidden="true"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="button-addon2">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>