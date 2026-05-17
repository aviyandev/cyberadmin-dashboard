<!doctype html>
<html lang="{{ app()->getLocale() }}" data-theme="{{ session('theme', 'dark') }}">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title') | CyberAdmin</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    @vite(['resources/css/style.css', 'resources/js/main.js'])
    @livewireStyles
  </head>
  <body>
    <div class="app-container">
      <!-- Sidebar -->
      <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
          <h2 class="glitch-hover">{{ __('tactical::tactical.brand') }}</h2>
          <i class="ph ph-hexagon logo-icon"></i>
        </div>
        <nav class="sidebar-nav">
          <a href="{{ route('cyberadmin.dashboard') }}" class="nav-item {{ request()->routeIs('cyberadmin.dashboard') ? 'active' : '' }}">
            <i class="ph ph-squares-four"></i>
            <span>{{ __('tactical::tactical.dashboard') }}</span>
          </a>
          <a href="{{ route('cyberadmin.users') }}" class="nav-item {{ request()->routeIs('cyberadmin.users') ? 'active' : '' }}">
            <i class="ph ph-users"></i>
            <span>{{ __('tactical::tactical.users') }}</span>
          </a>
          <a href="{{ route('cyberadmin.reports') }}" class="nav-item {{ request()->routeIs('cyberadmin.reports') ? 'active' : '' }}">
            <i class="ph ph-files"></i>
            <span>{{ __('tactical::tactical.reports') }}</span>
          </a>
          <a href="{{ route('cyberadmin.profile') }}" class="nav-item {{ request()->routeIs('cyberadmin.profile') ? 'active' : '' }}">
            <i class="ph ph-user-circle"></i>
            <span>{{ __('tactical::tactical.profile') }}</span>
          </a>
          <a href="{{ route('cyberadmin.settings') }}" class="nav-item {{ request()->routeIs('cyberadmin.settings') ? 'active' : '' }}">
            <i class="ph ph-gear"></i>
            <span>{{ __('tactical::tactical.settings') }}</span>
          </a>
          <div style="flex: 1"></div>
          <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-item">
            <i class="ph ph-sign-out"></i>
            <span>{{ __('tactical::tactical.logout') }}</span>
          </a>
        </nav>
      </aside>

      <!-- Main Content -->
      <main class="main-content">
        <!-- Topbar -->
        <header class="topbar">
          <button class="toggle-sidebar" id="toggle-sidebar">
            <i class="ph ph-list"></i>
          </button>
          <div class="topbar-right">
            <livewire:theme-switcher />
            <button
              class="cyber-btn sm"
              onclick="showToast('{{ __('tactical::tactical.intel_feeds_synced') }}', 'success')"
            >
              <i class="ph ph-arrows-clockwise"></i> {{ __('tactical::tactical.sync') }}
            </button>
            <div class="user-profile">
              <span
                style="font-family: var(--font-heading); color: var(--primary)"
                >{{ auth()->user()->name ?? 'SYS_ADMIN' }}</span
              >
              <img
                src="https://i.pravatar.cc/150?img=11"
                alt="Avatar"
                class="user-avatar"
              />
            </div>
          </div>
        </header>

        <!-- Page Content -->
        <div class="page-content">
          @yield('content')
        </div>
      </main>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>

    @livewireScripts
    <script src="{{ asset('vendor/cyberadmin/js/main.js') }}"></script>
  </body>
</html>
