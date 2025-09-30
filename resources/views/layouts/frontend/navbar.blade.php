<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <div class="navbar-brand">
            <div>
                <i class="fa-solid fa-video"></i>
                MyEditingVideo
            </div>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item me-2">
                    <a class="nav-link @yield('homeActive')" href="{{ route('home.main') }}">{{ __('Beranda') }}</a>
                </li>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link @yield('informationActive')"
                        href="{{ route('home.information.index') }}">{{ __('Information') }}</a>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link @yield('articlesActive')"
                        href="{{ route('home.articles.index') }}">{{ __('Portofolio') }}</a>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link @yield('productsActive')"
                        href="{{ route('home.products.index') }}">{{ __('Produk') }}</a>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link @yield('teamActive')" href="{{ route('home.team.index') }}">{{ __('Tim') }}</a>
                </li>
                <a class="nav-link @yield('contactActive')" href="{{ route('home.contact.index') }}">{{ __('Kontak') }}</a>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cart.show') }}">
                        <i class="fa-solid fa-cart-shopping"></i>
                        @if (isset($cartItemCount) && $cartItemCount > 0)
                            <span class="badge bg-danger rounded-pill">{{ $cartItemCount }}</span>
                        @endif
                    </a>
                </li>
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold text-primary" href="#"
                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                {{ __('Dashboard (Hanya Untuk Admin)') }}
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                 this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
