<body>
    <div class="col-auto col-md-3 col-xl-2 px-sm-4 px-0 bg-light" style="box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);">
        <div class="d-flex flex-column px-3 pt-2 text-white min-vh-100">
            <h2 class="text-center mb-4" style="padding-top: 3rem; padding-bottom: 2rem;">
                <img src="{{ asset('assets/logo-2.svg') }}" alt="TopIT Logo" width="150" height="50">
            </h2>
            <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100"
                id="menu">
                <li class="nav-item w-100">
                    <a href="{{ route('dashboard') }}" class="nav-link text-dark px-0" id="dashboard-link" data-page="dashboard">
                        <i class="bi bi-grid h6"></i> <span class="ms-1 d-none d-sm-inline fs-6">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item w-100">
                    <a href="{{ route('reviewer') }}" class="nav-link text-dark px-0" id="reviewer-link"
                        data-page="reviewer">
                        <i class="bi bi-journal-bookmark-fill h6"></i> <span
                            class="ms-1 d-none d-sm-inline fs-6">Reviewer</span>
                    </a>
                </li>
                <li class="nav-item w-100">
                    <a href="{{ route('test') }}" class="nav-link text-dark px-0" id="test"
                        data-page="test">
                        <i class="bi bi-pencil-fill h6"></i> <span class="ms-1 d-none d-sm-inline fs-6">Test</span>
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown pb-4 ">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('assets\logo-2.svg') }}" alt="hugenerd" width="30" height="30"
                        class="rounded-circle">
                    <span class="d-none d-sm-inline mx-1 fs-6">User</span>
                </a>
                <ul class="dropdown-menu dropdown-menu text-small shadow">
                    <li><a class="dropdown-item fs-6" href="#">Profile</a></li>
                    <li><a class="dropdown-item fs-6" href="{{ route('logout') }}">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <style>
        .nav-link.focused {
            border-radius: 0;
        }

        .nav-link.dimmed {
            opacity: 0.6;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('#menu .nav-link');
            const currentPage = '{{ Route::currentRouteName() }}';

            function updateNavLinks(clickedLink) {
                navLinks.forEach(link => {
                    if (link === clickedLink) {
                        link.classList.add('focused');
                        link.classList.remove('dimmed');
                    } else {
                        link.classList.remove('focused');
                        link.classList.add('dimmed');
                    }
                });
            }

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    updateNavLinks(this);
                });

                if (link.dataset.page === currentPage) {
                    updateNavLinks(link);
                }
            });
        });
    </script>
</body>
