<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>

        <li class="sidebar-item @if(request()->routeIs('dashboard.home')) active @endif">
            <a href="{{ route('dashboard.home') }}" class="sidebar-link">
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
            </a>
        </li>

        <li class="sidebar-title">Probes</li>

        <li class="sidebar-item @if(request()->routeIs('dashboard.readings*')) active @endif">
            <a href="{{ route('dashboard.readings.index') }}" class="sidebar-link">
              <i class="bi bi-database"></i>
              <span>Readings</span>
            </a>
        </li>

        <li class="sidebar-title">Settings</li>

        <li class="sidebar-item @if(request()->routeIs('dashboard.users*')) active @endif">
            <a href="{{ route('dashboard.users.index') }}" class="sidebar-link">
              <i class="bi bi-person-fill-gear"></i>
              <span>Users</span>
            </a>
        </li>

        <li class="sidebar-item @if(request()->routeIs('dashboard.sections*')) active @endif">
            <a href="{{ route('dashboard.sections.index') }}" class="sidebar-link">
              <i class="bi bi-building-gear"></i>
              <span>Sections</span>
            </a>
        </li>

        <li class="sidebar-item @if(request()->routeIs('dashboard.conditions*')) active @endif">
            <a href="{{ route('dashboard.conditions.index') }}" class="sidebar-link">
              <i class="bi bi-thermometer-snow"></i>
              <span>Conditions</span>
            </a>
        </li>

        <li class="sidebar-item @if(request()->routeIs('dashboard.processinglines*')) active @endif">
            <a href="{{ route('dashboard.processinglines.index') }}" class="sidebar-link">
              <i class="bi bi-card-checklist"></i>
              <span>Processing Lines</span>
            </a>
        </li>

        {{-- <li class="sidebar-item has-sub">
            <a href="#" class="sidebar-link">
                <i class="bi bi-stack"></i>
                <span>Components</span>
            </a>

            <ul class="submenu">
                <li class="submenu-item">
                    <a href="#" class="submenu-link">Accordion</a>
                </li>

                <li class="submenu-item">
                    <a href="#" class="submenu-link">Alert</a>
                </li>
            </ul>
        </li> --}}
    </ul>
</div>