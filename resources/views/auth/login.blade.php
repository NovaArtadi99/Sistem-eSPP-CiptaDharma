<!DOCTYPE html>
<html lang="en">
<head>
    <base href="../../../">
    <title>Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="dist/assets/image/logosdciptadharma.jpg" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="admin/demo1/dist/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="admin/demo1/dist/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
</head>
<body id="kt_body" class="bg-body">
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/sketchy-1/14.png">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <a href="/" class="mb-5">
                    <img alt="Logo" src="{{ asset('dist/assets/image/logosdciptadharma.jpg') }}" class width="180" height="auto" />
                </a>

                <div class="w-lg-500px bg-white rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-info mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form w-100" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="text-center mb-10">
                            <h1 class="text-dark mb-3 fs-1">Sign In To E-SPP Cipta Dharma</h1>
                        </div>

                        <!-- Email -->
                        <div class="fv-row mb-10">
                            <label for="email" class="form-label fs-4 fw-bolder text-dark">Email</label>
                            <input id="email" class="form-control fs-5 form-control-lg form-control-solid @error('email') is-invalid @enderror"
                                   type="text"
                                   name="login"
                                   {{-- value="{{ old('email') }}" --}}
                                   required
                                   autocomplete="off" />
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            {{-- <input id="email" class="form-control fs-5 form-control-lg form-control-solid @error('email') is-invalid @enderror"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="off" />
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror --}}
                        </div>

                        <!-- Password -->
                        <div class="fv-row mb-10">
                            <div class="d-flex flex-stack mb-2">
                                <label for="password" class="form-label fw-bolder text-dark fs-4 mb-0">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="link-primary fs-5 fw-bolder">
                                        Forgot Password?
                                    </a>
                                @endif
                            </div>
                            <div class="position-relative">
                                <input id="password"
                                       class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror"
                                       type="password"
                                       name="password"
                                       required
                                       autocomplete="current-password" />
                                <button type="button" onclick="togglePassword()" class="btn btn-sm btn-icon position-absolute top-50 end-0 translate-middle-y me-2" style="background: none; border: none;">
                                    <i class="bi bi-eye" id="toggleIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="fv-row mb-10">
                            <label class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember_me" />
                                <span class="form-check-label fw-bold text-gray-700 fs-6">
                                    Remember me
                                </span>
                            </label>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-lg btn-primary w-100 mb-5">
                                <span class="indicator-label">Log in</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="d-flex flex-center flex-column-auto p-10">
                <div class="text-muted">Copyright &copy; {{ date('Y') }} Your Website</div>
            </div>
        </div>
    </div>

    <script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.className = 'bi bi-eye-slash';
        } else {
            passwordInput.type = 'password';
            toggleIcon.className = 'bi bi-eye';
        }
    }
    </script>

    <script src="admin/demo1/assets/plugins/global/plugins.bundle.js"></script>
    <script src="admin/demo1/assets/js/scripts.bundle.js"></script>
</body>
</html>
