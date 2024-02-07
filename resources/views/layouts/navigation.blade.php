<nav class="navbar fixed-top navbar-expand-lg bg-white rounded-desktop m-2">
    <div class="container-fluid">
        <a class="navbar-brand text-dark ms-2" href="/">LinkHive</a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-dark">
                <li class="nav-item text-dark">
                    <a class="nav-link active text-dark" aria-current="page" href="/"><i class="fa-solid fa-house me-1"></i>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('themes.appearance') }}"><i class="fa-solid fa-sliders me-1"></i>Appearance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('showListing') }}"><i class="fa-solid fa-bars-progress me-1"></i></i>Links</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('showLink') }}"><i class="fa-solid fa-gear me-1"></i>Settings</a>
                </li>
            </ul>
            
            <ul class="list-unstyled topbar-nav mb-0">
                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#shareModal">
                    Share <i class="fa-solid fa-share-alt me-1"></i>
                </button>
            </ul>
            <ul class="list-unstyled topbar-nav float-end mb-0">
                <li class="dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-light nav-user mx-3"
                        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                        aria-expanded="false">
                        <span class="ms-1 nav-user-name hidden-sm mx-2 text-dark">
                            <?= ucfirst(Auth::user()->name) ?>
                        </span>
                        {{-- <img src="" alt="profile-user"
                            class="rounded-circle thumb-xs" /> --}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}"><i data-feather="user"
                                class="align-self-center icon-xs icon-dual me-1"></i> Profile</a>
                        <div class="dropdown-divider mb-0"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                        this.closest('form').submit();"><i
                                    data-feather="power" class="align-self-center icon-xs icon-dual me-1"></i>
                                Logout</a>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
