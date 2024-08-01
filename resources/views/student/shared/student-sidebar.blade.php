<div class="col-auto col-md-4 col-xl-2 py-4 px-0 side-bar d-flex flex-column justify-content-between h-100">
    <div class="d-flex flex-column justify-space-between pt-2">
        <h2 class="text-center py-5">
            <img src="{{ asset('assets/logo-2.svg') }}" alt="TopIT Logo" width="100" height="40">
        </h2>
        <ul class="nav nav-pills d-flex flex-column align-items-center" id="menu">
            <li class="nav-item w-100">
                <a href="{{ route('dashboard') }}" class="nav-link text-dark py-3 ps-4 d-flex align-items-center gap-1"
                    id="dashboard-link" data-page="dashboard">
                    <span class="material-symbols-outlined">home</span><span
                        class="ms-1 d-none d-sm-inline fs-6">Dashboard</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a href="{{ route('profile') }}" class="nav-link text-dark py-3 ps-4 d-flex align-items-center gap-1" id="test"
                    data-page="profile">
                    <span class="material-symbols-outlined">person</span> <span
                        class="ms-1 d-none d-sm-inline fs-6">Profile</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a href="{{ route('reviewer') }}" class="nav-link text-dark py-3 ps-4 d-flex align-items-center gap-1"
                    id="reviewer-link" data-page="reviewer">
                    <span class="material-symbols-outlined">description</span>
                    <span class="ms-1 d-none d-sm-inline fs-6">Reviewer</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a href="{{ route('test') }}" class="nav-link text-dark py-3 ps-4 d-flex align-items-center gap-1" id="test"
                    data-page="test">
                    <span class="material-symbols-outlined">quiz</span> <span
                        class="ms-1 d-none d-sm-inline fs-6">Test</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="pb-3">
        <a href="{{route('logout')}}" class="nav-link text-dark py-3 ps-4 d-flex align-items-center gap-1">
        <span class="material-symbols-outlined">logout</span>
            Logout
        </a>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
            link.addEventListener('click', function (e) {
                updateNavLinks(this);
            });

            if (link.dataset.page === currentPage) {
                updateNavLinks(link);
            }
        });
    });
</script>