<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark overflow-hidden" style="width: 280px; height: 100vh; position: fixed">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class="bi bi-bootstrap me-3 fs-1"></i>
      <span class="fs-4">Biodata APP</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li>
            <a href="#" class="nav-link text-white {{ request()->is('/') ? 'active' : '' }}">
                <i class="bi bi-house me-2"></i>
            Dashboard
            </a>
        </li>
        @role('Admin')
        <li>
            <a href="{{ route('user') }}" class="nav-link text-white {{ request()->is('/profile') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i>
                User
            </a>
        </li>
        @endrole
        @hasrole('User')
        <li>
            <a href="{{ route('profile') }}" class="nav-link text-white {{ request()->is('/profile') ? 'active' : '' }}">
                <i class="bi bi-person me-2"></i>
            Entry Biodata
            </a>
        </li>
        @endhasrole
        <li>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                @method('POST')
                <button type="submit" class="nav-link text-white">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Logout
                </button>
            </form>
        </li>
    </ul>
</div>
