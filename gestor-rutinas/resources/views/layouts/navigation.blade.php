<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000000; ">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-dumbbell me-2"></i>Mis rutinas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('exercises.showAll') ? 'active' : '' }}" href="{{ route('exercises.showAll') }}">
                        <i class="fas fa-running me-2"></i>Mis ejercicios
                    </a>
                </li>

                @if(Auth::user()->is_admin)
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <i class="fas fa-users me-2"></i>Usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('statistics.index') ? 'active' : '' }}" href="{{ route('statistics.index') }}">
                        <i class="fas fa-chart-bar me-2"></i>Estadísticas
                    </a>
                </li>
                @endif
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-3" href="#" id="userDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if (Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Foto de perfil"
                            class="rounded-circle" width="35" height="35" style="object-fit: cover; border: 2px solid #76B4AA;">
                        @else
                        <img src="{{ asset('images/default-avatar.jpg') }}" alt="Avatar por defecto"
                            class="rounded-circle" width="35" height="35" style="object-fit: cover; border: 2px solid #76B4AA;">
                        @endif

                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>

                        @if (Auth::user()->is_admin)
                        <span class="badge bg-danger">Admin</span>
                        @endif
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-edit me-2"></i>Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('exercises.showAll') ? 'active' : '' }}" href="{{ route('exercises.showAll') }}">
                                <i class="fas fa-running me-2"></i>Mis ejercicios
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-dumbbell me-2"></i>Mis rutinas
                            </a>
                        </li>
                        @if(Auth::user()->is_admin)
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                <i class="fas fa-users me-2"></i>Usuarios
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('statistics.index') ? 'active' : '' }}" href="{{ route('statistics.index') }}">
                                <i class="fas fa-chart-bar me-2"></i>Estadísticas
                            </a>
                        </li>
                        @endif

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth

                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-2"></i>Iniciar sesión
                    </a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        <i class="fas fa-user-plus me-2"></i>Registrarse
                    </a>
                </li>
                @endif
                @endguest
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand .logo {
        height: 50px;

        width: auto;

        max-width: 160px;

        transition: transform 0.3s ease;
    }


    .navbar-brand:hover .logo {
        transform: scale(1.1);
    }

    .nav-link {
        color: #FFFFFF !important;
        padding: 0.5rem 1rem !important;
        transition: all 0.3s ease;
    }

    .nav-link:hover {
        background-color: rgba(118, 180, 170, 0.2);
        border-radius: 5px;
    }

    .nav-link.active {
        background-color: #76B4AA;
        color: #000000 !important;
        border-radius: 5px;
        font-weight: 600;
    }

    .dropdown-menu {
        background-color: #FFFFFF;
        border: 1px solid #76B4AA;
        border-radius: 8px;
    }

    .dropdown-item {
        color: #000000;
        padding: 0.5rem 1rem;
    }

    .dropdown-item:hover {
        background-color: rgba(118, 180, 170, 0.1);
    }

    .dropdown-item.active {
        background-color: #76B4AA;
        color: #000000;
    }
</style>