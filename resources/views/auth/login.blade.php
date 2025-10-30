<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login - TB Pusat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/app.min.css" rel="stylesheet">
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/icons.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid authentication-bg overflow-hidden">
        <div class="bg-overlay"></div>
        <div class="row align-items-center justify-content-center min-vh-100">
            <div class="col-10 col-md-6 col-lg-4 col-xxl-3">
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="text-center">
                            <a href="index.php" class="logo-dark">
                                <img src="assets/images/tbpusat-light.png" alt="" height="20" class="auth-logo logo-dark mx-auto">
                            </a>
                            <a href="index.php" class="logo-dark">
                                <img src="assets/images/tbpusat-dark.png" alt="" height="20" class="auth-logo logo-light mx-auto">
                            </a>
                            
                            <h4 class="mt-4">Welcome Back !</h4>
                            <p class="text-muted">Sign in to continue to TB Pusat.</p>
                        </div>

                        <div class="p-2 mt-5">
                            
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="input-group auth-form-group-custom mb-3">
                                    <span class="input-group-text bg-primary bg-opacity-10 fs-16"><i class="mdi mdi-email-outline auti-custom-input-icon"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           placeholder="Enter email" name="email" id="email"
                                           value="{{ old('email') }}" required autofocus>
                                </div>
                                @error('email')
                                    <span class="text-danger d-block mb-2">{{ $message }}</span>
                                @enderror

                                <div class="input-group auth-form-group-custom mb-3">
                                    <span class="input-group-text bg-primary bg-opacity-10 fs-16"><i class="mdi mdi-lock-outline auti-custom-input-icon"></i></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" placeholder="Enter password" required>
                                </div>
                                @error('password')
                                    <span class="text-danger d-block mb-2">{{ $message }}</span>
                                @enderror

                                <div class="mb-sm-5">
                                    <div class="form-check float-sm-start">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                        <label class="form-check-label" for="remember">Remember me</label>
                                    </div>
                                    <div class="float-sm-end">
                                        <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                    </div>
                                </div>

                                <div class="pt-3 text-center">
                                    <button class="btn btn-primary w-xl waves-effect waves-light" type="submit">Log In</button>
                                </div>

                                <div class="mt-3 text-center">
                                    <p class="mb-0">Don't have an account ? 
                                        <a href="{{ route('register') }}" class="fw-medium text-primary"> Register </a> 
                                    </p>
                                </div>

                            </form>
                        </div>

                        <div class="mt-5 text-center">
                            <p>©
                                <script>document.write(new Date().getFullYear())</script> TB Pusat - PP. Darussalam Blokagung
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php // include 'partials/vendor-scripts.php'; // Anda bisa ganti ini dengan tag <script> jika perlu ?>
    <script src="assets/js/app.js"></script>
</body>
</html>