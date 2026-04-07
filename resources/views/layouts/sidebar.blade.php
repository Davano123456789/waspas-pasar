            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="fas fa-tachometer-alt menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>

                    @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kriteria.index') }}">
                            <i class="fas fa-list-ul menu-icon"></i>
                            <span class="menu-title">Data Kriteria</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pasar.index') }}">
                            <i class="fas fa-store menu-icon"></i>
                            <span class="menu-title">Data Pasar</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pengguna.index') }}">
                            <i class="fas fa-users-cog menu-icon"></i>
                            <span class="menu-title">Kelola Akun</span>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->isAdmin() || auth()->user()->isKepalaPasar())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('penilaian.index') }}">
                            <i class="fas fa-poll-h menu-icon"></i>
                            <span class="menu-title">Penilaian</span>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->isAdmin() || auth()->user()->isDirektur() || auth()->user()->isKepalaPasar())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('waspas.index') }}">
                            <i class="fas fa-chart-line menu-icon"></i>
                            <span class="menu-title">Hasil Perhitungan</span>
                        </a>
                    </li>
                    @endif

                    <li class="nav-item border-top mt-3">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt menu-icon text-danger"></i>
                            <span class="menu-title">Keluar / Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
