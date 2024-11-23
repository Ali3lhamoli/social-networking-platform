<aside class="sidebar bg-dark text-white position-fixed h-100">
    <div class="p-3">
        <nav>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('site.home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('site.profile') }}">Profile</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Friends
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{route('site.connections.index')}}">Find People</a></li>
                      <li><a class="dropdown-item" href="{{route('site.connections.show', 'friends')}}">All Friends</a></li>
                      <li><a class="dropdown-item" href="{{route('site.connections.create')}}">Requests</a></li>
                    </ul>
                  </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{route('site.settings.index')}}">Settings</a>
                </li>
                @if (auth()->check())
                    <li class="nav-item">
                        <form action="{{ route('site.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link text-white">logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('site.login.show') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('site.register.show') }}">Register</a>
                    </li>
                @endif

            </ul>
        </nav>
    </div>
</aside>
