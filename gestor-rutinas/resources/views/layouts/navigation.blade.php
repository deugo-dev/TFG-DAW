<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom p-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">Gestor de Rutinas</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        Mis rutinas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('exercises.showAll') ? 'active' : '' }}" href="{{ route('exercises.showAll') }}">
                        Mis ejercicios
                    </a>
                </li>

                @if(Auth::user()->is_admin)
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        Usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('statistics.index') ? 'active' : '' }}" href="{{ route('statistics.index') }}">
                        Estadísticas
                    </a>
                </li>
                @endif


                @endauth


            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">

                        {{-- Foto de perfil --}}
                        @if (Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Foto de perfil"
                            class="rounded-circle" width="32" height="32">
                        @else
                        <img src="{{ asset('images/default-avatar.jpg') }}" alt="Avatar por defecto"
                            class="rounded-circle" width="32" height="32">
                        @endif

                        {{-- Nombre de usuario --}}
                        {{ Auth::user()->name }}

                        {{-- Badge de admin --}}
                        @if (Auth::user()->is_admin)
                        <span class="badge bg-danger ms-2">Admin</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                                Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('exercises.showAll') ? 'active' : '' }}" href="{{ route('exercises.showAll') }}">
                                Mis ejercicios
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                Mis rutinas
                            </a>
                        </li>
                        @if(Auth::user()->is_admin)
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                Usuarios
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('statistics.index') ? 'active' : '' }}" href="{{ route('statistics.index') }}">
                                Estadísticas
                            </a>
                        </li>
                        @endif

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Cerrar sesión</button>
                            </form>
                        </li>

                    </ul>
                </li>
                @endauth

                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                </li>
                @endif
                @endguest
            </ul>

        </div>
    </div>
</nav>