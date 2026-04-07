        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="{{ url('/') }}">
                    <h3 class="font-weight-bold text-primary mb-0">WASPAS</h3>
                </a>
                <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
                    <h3 class="font-weight-bold text-primary mb-0">W</h3>
                </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item">
                        <span class="nav-link font-weight-bold text-dark">
                            <i class="icon-head mr-2 text-primary"></i> {{ auth()->user()->nama_lengkap }} ({{ auth()->user()->peran }})
                        </span>
                    </li>
                </ul>

                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
