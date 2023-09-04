<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{route('home')}}">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNav">
            <ul class="navbar-nav w-100">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('home')}}">Home</a>
                </li>
                @guest
                    <li class="nav-item ms-auto">
                        <a class="nav-link" href="{{route('login')}}">Login</a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Cities
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('cities.create')}}">Create City</a></li>
                        </ul>
                    </li>
                    <li class="nav-item ms-auto">
                        <a class="nav-link" aria-disabled="true">Logout</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
