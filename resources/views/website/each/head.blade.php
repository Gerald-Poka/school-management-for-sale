<nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="index">
            <img src="{{ URL::asset('school/logo.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="67">
            <img src="{{ URL::asset('school/logo.png') }}" class="card-logo card-logo-light" alt="logo light"
                height="67">
        </a>
        <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <i class="mdi mdi-menu"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                <li class="nav-item">
                    <a class="nav-link fs-15 active" href="#hero">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-15" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-15" href="#features">Partiner</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link fs-15" href="#team">Team</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link fs-15" href="#contact">Contact</a>
                </li>
            </ul>

            <div class="">
                <a href="{{ route('loginpage') }}" class="btn" style="background-color: #282757; color: #fff; border: none; padding: 10px 20px; border-radius: 5px;">
                    <i class="mdi mdi-login me-2"></i> Sign In
                </a>
            </div>
        </div>

    </div>
</nav>