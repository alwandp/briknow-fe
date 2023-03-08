            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{session()->get('success')}}
            </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        <span class="font-weight-bold d-block">Mohon Dilengkapi :</span>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif