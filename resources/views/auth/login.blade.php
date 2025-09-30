<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>MyEditingVideo - Login</title>
    <meta name="description" content="MyBlog - Login Page" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
            /* Apply Inter font family */
            font-family: var(--tblr-font-sans-serif);
            /* Ensure body takes full height and uses flexbox for vertical centering */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Adjust main content to take available space and center its content */
        main {
            flex-grow: 1;
            /* Allows main to expand and push footer down */
            display: flex;
            /* Use flexbox to center content vertically */
            align-items: center;
            /* Center content vertically */
            justify-content: center;
            /* Center content horizontally */
        }
    </style>
</head>

<body>
    <main class="flex-grow-1 py-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-4">
                    <div class="card shadow px-4 py-4">
                        <div class="card-body">
                            <h2 class="card-title text-center mb-4 d-flex justify-content-center align-items-center">
                                <i class="fa-solid fa-video pe-3"></i>
                                <span>MyEditingVideo</span>
                            </h2>
                            <hr>
                            <p class="text-center text-muted mb-4">Login ke Akun Anda</p>

                            <form action="{{ route('login') }}" method="POST" autocomplete="off" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" placeholder="your@email.com"
                                        value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" placeholder="Your password"
                                        value="{{ old('password') }}"
                                        class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-footer">
                                    <button type="submit" class="btn btn-primary w-100">Sign in</button>
                                </div>
                            </form>
                            <div class="text-center text-secondary mt-3" st>
                                Buat Akun Baru <a href="{{ route('register') }}" class="text-decoration-none"
                                    tabindex="-1">Register</a>
                            </div>
                            <div class="text-center text-secondary mt-3" st><a href="/forgot-password"
                                    class="text-decoration-none" tabindex="-1">Lupa Password?</a>
                            </div>
                            <hr>
                            <div class="text-center text-secondary mt-3">
                                Kembali ke halaman <a href="/" tabindex="-1">Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVpZVxpLtGfZuH5njoBuuWVqXQ+oR9byP2xHAuzK5Vzddy" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlco4jN+CAngLhVIsEMTTJXwZTRhNEhftGRpBG5hGzJIyK8" crossorigin="anonymous">
    </script>

</body>

</html>
