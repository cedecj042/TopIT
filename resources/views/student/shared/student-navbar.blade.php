<div class="col-12">
    <nav class="navbar navbar-custom d-flex justify-content-end">
        <div class="d-flex flex-row pe-5 py-2 gap-3 ">
            <span class="ms-2">Hi, {{ Auth::user()->username }}</span>
            @php
                if (Auth::user()->userable->profile_image == null) {
                    $profileImageUrl = asset('assets/profile-circle.png');
                } else {
                    $profileImageUrl = Storage::disk('profile_images')->url(Auth::user()->userable->profile_image);
                    //$profileImageUrl = Storage::url('profile_images/'.Auth::user()->userable->profile_image);
                }
            @endphp
            <img src="{{ $profileImageUrl }}" alt="Profile Image" class="rounded-circle" width="30" height="30">
        </div>
    </nav>
</div>