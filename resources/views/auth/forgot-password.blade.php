<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Forgot Password - TB Pusat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-fluid authentication-bg overflow-hidden">
        <div class="bg-overlay"></div>
        <div class="row align-items-center justify-content-center min-vh-100">
            <div class="col-10 col-md-6 col-lg-4 col-xxl-3">
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="text-center">
                            <a href="/" class="logo-dark">
                                <img src="{{ asset('assets/images/tbpusat-light.png') }}" alt="" height="20" class="auth-logo logo-dark mx-auto">
                            </a>
                            <a href="/" class="logo-dark">
                                <img src="{{ asset('assets/images/tbpusat-dark.png') }}" alt="" height="20" class="auth-logo logo-light mx-auto">
                            </a>
                            
                            <h4 class="mt-4">Reset Password</h4>
                            <p class="text-muted">Masukkan email Anda dan kami akan mengirimkan kode OTP.</p>
                        </div>

                        <div class="p-2 mt-5">

                            @if (session('status'))
                                <div class="alert alert-success text-center mb-4" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
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

                                <div class="pt-3 text-center">
                                    <button class="btn btn-primary w-xl waves-effect waves-light" type="submit">Kirim OTP</button>
                                </div>

                                <div class="mt-3 text-center">
                                    <p class="mb-0">Ingat password Anda? 
                                        <a href="{{ route('login') }}" class="fw-medium text-primary"> Login di sini </a> 
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

    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>