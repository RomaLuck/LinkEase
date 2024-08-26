<header class="border-bottom py-3 mb-4">
    @use(Symfony\Component\HttpFoundation\Session\Session)
    <div class="container-fluid d-flex flex-wrap align-items-center justify-content-center justify-content-md-between">
        <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                <use xlink:href="#bootstrap"></use>
            </svg>
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="/" class="nav-link px-2 link-dark">Main</a></li>
            <li><a href="/contact" class="nav-link px-2 link-dark">Contact</a></li>
            <li><a href="/about" class="nav-link px-2 link-dark">About</a></li>
        </ul>

        <div class="col-md-3 d-flex flex-row-reverse">
            @if (!(new Session())->has('user'))
                <a href="/register" type="button" class="btn btn-primary">Sign-up</a>
                <a href="/login" type="button" class="btn btn-outline-primary me-2">Login</a>
            @endif
            @if ((new Session())->has('user'))
                <div class="mx-1">
                    <form method="POST" action="/session">
                        <input type="hidden" name="_method" value="DELETE"/>
                        <button class="btn btn-outline-primary">Log Out</button>
                    </form>
                </div>
                <div class="mx-1">
                    <a href="/profile" class="btn btn-outline-primary">Profile</a>
                </div>
            @endif
        </div>
    </div>
</header>
