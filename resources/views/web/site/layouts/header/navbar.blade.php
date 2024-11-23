<nav class="navbar navbar-expand-lg bg-dark border-bottom border-body fixed-top" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('site.home') }}">Sharikna</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('site.home') }}">Home</a>
                </li>
                @if (!auth()->check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('site.login.show') }}">Login</a>
                    </li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Profile
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item"
                                href="{{ route('site.profile') }}">{{ auth()->check() ? Auth::user()->name : 'profile' }}</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('site.settings.index') }}">Settings</a></li>
                    </ul>
                </li>
            </ul>
            <form action="{{ route('site.search') }}" method="POST" class="d-flex" role="search">
                @csrf
                <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>
