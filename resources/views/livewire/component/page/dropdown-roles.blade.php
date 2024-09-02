<div class="dropdown  d-none d-lg-block ms-2">
    <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="false"
        aria-expanded="false">
        <span key="t-megamenu">Roles</span>
        <i class="mdi mdi-chevron-down"></i>
    </button>
    <div class="dropdown-menu">
        @foreach ($roles as $role)
            <span class="dropdown-item" key="t-{{ $role->name }}">{{ $role->name }}</span>
            <div class="dropdown-divider"></div>
        @endforeach
    </div>
</div>
