<div class="col-auto col-md-4 col-xl-2 py-4 px-0 side-bar d-flex flex-column justify-content-between h-100"
    style="background: linear-gradient(to top, #114A91, #1C81F8);position:fixed;">
    <div class="d-flex flex-column justify-space-between pt-2">
        <h2 class="text-center py-5">
            <img src="{{ asset('assets/logo.svg') }}" alt="TopIT Logo" width="100" height="40">
        </h2>
        <ul class="nav nav-pills d-flex flex-column align-items-center" id="menu">
            <li class="nav-item w-100">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link text-white py-3 ps-4 d-flex align-items-center gap-1" id="dashboard-link"
                    data-page="admin.dashboard">
                    <span class="material-symbols-outlined">home</span><span
                        class="ms-1 d-none d-sm-inline fs-6">Dashboard</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a href="#coursesSubmenu" data-bs-toggle="collapse"
                    class="nav-link text-white py-3 ps-4 d-flex align-items-center gap-1 dropdown-toggle">
                    <span class="material-symbols-outlined">description</span>
                    <span class="ms-1 d-none d-sm-inline fs-6">Reviewers</span>
                </a>
                <ul class="collapse nav flex-column ms-0" id="coursesSubmenu" data-bs-parent="#menu">
                    <li class="w-100">
                        <a href="{{ route('admin.course.index') }}" class="nav-link text-white py-3 ps-5">Courses</a>
                    </li>
                    <li class="w-100">
                        <a href="{{ route('admin.modules.index') }}" class="nav-link text-white py-3 ps-5">Modules</a>
                    </li>
                    <li class="w-100">
                        <a href="{{ route('admin.sections.index') }}" class="nav-link text-white py-3 ps-5">Sections</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item w-100">
                <a href="#questionBankSubmenu" data-bs-toggle="collapse"
                    class="nav-link text-white py-3 ps-4 d-flex align-items-center gap-1 dropdown-toggle">
                    <span class="material-symbols-outlined">quiz</span>
                    <span class="ms-1 d-none d-sm-inline fs-6">Question Bank</span>
                </a>
                <ul class="collapse nav flex-column ms-0" id="questionBankSubmenu" data-bs-parent="#menu">
                    <li class="w-100">
                        <a href="{{ route('admin.questions.generate') }}" class="nav-link text-white py-3 ps-5">Generate
                            Questions</a>
                    </li>
                    <li class="w-100">
                        <a href="{{ route('admin.questions.index') }}" class="nav-link text-white py-3 ps-5">List of
                            Questions</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item w-100">
                <a href="{{ route('admin.users.index') }}"
                    class="nav-link text-white py-3 ps-4 d-flex align-items-center gap-1" id="users-link"
                    data-page="users">
                    <span class="material-symbols-outlined">person</span>
                    <span class="ms-1 d-none d-sm-inline fs-6">Manage Users</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a href="{{ route('admin.reports') }}"
                    class="nav-link text-white py-3 ps-4 d-flex align-items-center gap-1" id="reports"
                    data-page="admin-reports">
                    <span class="material-symbols-outlined">quiz</span>
                    <span class="ms-1 d-none d-sm-inline fs-6">Reports</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="dropdown pb-4 px-4">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1"
            data-bs-toggle="dropdown" aria-expanded="false">
            @php
                if (Auth::user()->userable->profile_image == null) {
                    $profileImageUrl = asset('assets/profile-circle.png');
                } else {
                    $profileImageUrl = Storage::disk('profile_images')->url(Auth::user()->userable->profile_image);
                }
            @endphp
            <img src="{{ asset('assets/profile-circle.png') }}" alt="Profile Image" class="rounded-circle" width="30"
                height="30">
            <span class="d-none d-sm-inline mx-1 fs-6">{{ Auth::user()->username }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu text-small shadow">
            <li><a class="dropdown-item fs-6" href="{{ route('admin.profile') }}">Profile</a></li>
            <li><a class="dropdown-item fs-6" href="{{ route('logout') }}">Sign out</a></li>
        </ul>
    </div>
</div>

<style>
    .nav-link {
        opacity: 0.7;
        transition: opacity 0.3s ease, background-color 0.3s ease;
    }

    .nav-link:hover,
    .nav-link.active {
        background-color: rgba(255, 255, 255, 0.1) !important;
        color: white !important;
        opacity: 1 !important;
    }

    #questionBankSubmenu .nav-link,
    #coursesSubmenu .nav-link {
        padding-left: 3rem;
        font-size: 0.98rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navLinks = document.querySelectorAll('#menu .nav-link');
        const collapseElements = document.querySelectorAll('.collapse');

        function saveMenuState() {
            const openCollapses = Array.from(collapseElements)
                .filter(el => el.classList.contains('show'))
                .map(el => el.id);
            localStorage.setItem('openSubmenus', JSON.stringify(openCollapses));
        }

        function saveActiveLink(href) {
            localStorage.setItem('activeLink', href);
        }

        function restoreMenuState() {
            const openCollapses = JSON.parse(localStorage.getItem('openSubmenus')) || [];
            openCollapses.forEach(id => {
                const collapseEl = document.getElementById(id);
                if (collapseEl) {
                    collapseEl.classList.add('show');
                    const toggle = document.querySelector(`[data-bs-toggle="collapse"][href="#${id}"]`);
                    if (toggle) toggle.setAttribute('aria-expanded', 'true');
                }
            });

            const activeLink = localStorage.getItem('activeLink');
            if (activeLink) {
                updateNavLinks(activeLink);
            }
        }

        function updateNavLinks(currentRoute) {
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === currentRoute) {
                    link.classList.add('active');
                    const parentCollapse = link.closest('.collapse');
                    if (parentCollapse) {
                        parentCollapse.classList.add('show');
                        const parentToggle = document.querySelector(
                            `[data-bs-toggle="collapse"][href="#${parentCollapse.id}"]`);
                        if (parentToggle) {
                            parentToggle.classList.add('active');
                            parentToggle.setAttribute('aria-expanded', 'true');
                        }
                    }
                }
            });
            saveMenuState();
            saveActiveLink(currentRoute);
        }

        restoreMenuState();

        collapseElements.forEach(collapse => {
            collapse.addEventListener('shown.bs.collapse', saveMenuState);
            collapse.addEventListener('hidden.bs.collapse', saveMenuState);
        });

        navLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                if (!this.hasAttribute('data-bs-toggle')) {
                    updateNavLinks(this.getAttribute('href'));
                }
            });
        });
    });
</script>