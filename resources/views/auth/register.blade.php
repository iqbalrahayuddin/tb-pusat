<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Register Akun - Clivax</title>
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
                    <div class="card-body" style="max-height: 80vh; overflow-y: auto;">

                        <div class="text-center">
                            <div>
                                <a href="index.php" class="logo-dark">
                                    <img src="/assets/images/tbpusat-light.png" alt="" height="20" class="auth-logo logo-dark mx-auto">
                                </a>
                                <a href="index.php" class="logo-light">
                                    <img src="/assets/images/tbpusat-dark.png" alt="" height="20" class="auth-logo logo-light mx-auto">
                                </a>
                            </div>

                            <h4 class="font-size-18 mt-4">Register account</h4>
                            <p class="text-muted">Get your free Clivax account now.</p>
                        </div>

                        <div class="p-2 mt-5">
                            
                            <form method="POST" action="{{ route('register') }}" id="registerForm">
                                @csrf

                                <div class="input-group auth-form-group-custom mb-3">
                                    <span class="input-group-text bg-primary bg-opacity-10 fs-16"><i class="mdi mdi-store-outline auti-custom-input-icon"></i></span>
                                    <input type="text" class="form-control @error('nama_toko') is-invalid @enderror" 
                                           id="nama_toko" placeholder="Enter Nama Toko" 
                                           name="nama_toko" value="{{ old('nama_toko') }}" required>
                                </div>
                                @error('nama_toko')
                                    <span class="text-danger d-block mb-2">{{ $message }}</span>
                                @enderror

                                <div class="input-group auth-form-group-custom mb-3">
                                    <span class="input-group-text bg-primary bg-opacity-10 fs-16"><i class="mdi mdi-map-marker-outline auti-custom-input-icon"></i></span>
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                           id="lokasi" placeholder="Enter Lokasi" 
                                           name="lokasi" value="{{ old('lokasi') }}" required>
                                </div>
                                @error('lokasi')
                                    <span class="text-danger d-block mb-2">{{ $message }}</span>
                                @enderror

                                <div class="input-group auth-form-group-custom mb-3">
                                    <span class="input-group-text bg-primary bg-opacity-10 fs-16"><i class="mdi mdi-account-outline auti-custom-input-icon"></i></span>
                                    <input type="text" class="form-control @error('nama_pic') is-invalid @enderror" 
                                           id="nama_pic" placeholder="Enter Nama Penanggung Jawab" 
                                           name="nama_pic" value="{{ old('nama_pic') }}" required>
                                </div>
                                @error('nama_pic')
                                    <span class="text-danger d-block mb-2">{{ $message }}</span>
                                @enderror

                                <div class="input-group auth-form-group-custom mb-3">
                                    <span class="input-group-text bg-primary bg-opacity-10 fs-16"><i class="mdi mdi-email-outline auti-custom-input-icon"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" placeholder="Enter email" 
                                           name="email" value="{{ old('email') }}" required>
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

                                <div class="input-group auth-form-group-custom mb-3">
                                    <span class="input-group-text bg-primary bg-opacity-10 fs-16"><i class="mdi mdi-lock-check-outline auti-custom-input-icon"></i></span>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check float-start">
                                        <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" 
                                               id="terms" name="terms" required>
                                        <label class="form-check-label" for="terms">I agree to all Terms and Condition</label>
                                    </div>
                                </div>
                                 @error('terms')
                                    <span class="text-danger d-block w-100">{{ $message }}</span>
                                @enderror


                                <div class="text-center pt-5">
                                    <button class="btn btn-primary w-xl waves-effect waves-light" type="submit">Register</button>
                                </div>

                                <div class="mt-3 text-center">
                                    <p class="mb-0">Already have an account ? <a href="login" class="fw-medium text-primary"> Login </a> </p>
                                </div>
                                
                                </form>
                        </div>

                        <div class="mt-5 text-center">
                            <p>©
                                <script>document.write(new Date().getFullYear())</script> Clivax. Crafted with <i class="mdi mdi-heart text-danger"></i> by Codebucks
                            </p>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="/assets/js/app.js"></script>
</body>
</html>