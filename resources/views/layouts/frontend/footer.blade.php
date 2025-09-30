<footer class="text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3 mb-md-0">
                <h5>Tentang Kami</h5>
                <p class="text-white-50">Kami adalah tim profesional yang berdedikasi untuk menciptakan video
                    berkualitas tinggi yang memenuhi visi Anda.</p>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <h5>Tautan Cepat</h5>
                <ul class="list-unstyled">
                    <li><a class="@yield('homeActive')" href="{{ route('home.main') }}">{{ __('Beranda') }}</a></li>
                    <li><a class="@yield('informationActive')"
                            href="{{ route('home.information.index') }}">{{ __('Information') }}</a></li>
                    <li><a class="@yield('articlesActive')"
                            href="{{ route('home.articles.index') }}">{{ __('Portofolio') }}</a></li>
                    <li><a class="@yield('teamActive')" href="{{ route('home.team.index') }}">{{ __('Tim') }}</a></li>
                    <li><a class="@yield('contactActive')" href="{{ route('home.contact.index') }}">{{ __('Kontak') }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Ikuti Kami</h5>
                <div class="social-icons">
                    <a href="https://www.instagram.com/r.mujaddid.a/" aria-label="Instagram"><i
                            class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@TheHuman_05" aria-label="YouTube"><i
                            class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4 border-light" />
        <p class="mb-0">&copy; 2025 MyEditingVideo. All Rights Reserved.</p>
    </div>
</footer>
