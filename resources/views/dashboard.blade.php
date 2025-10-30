@include('partials.session')
@include('partials.main')

<head>

    @include('partials.title-meta', ['title' => 'Dashboard'])

    @include('partials.head-css')

</head>

@include('partials.body')

<div id="layout-wrapper">

    @include('partials.menu')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <div>
                                {{-- Sapaan dipastikan menggunakan timezone WIB (Asia/Jakarta) --}}
                                @php
                                    date_default_timezone_set('Asia/Jakarta'); // Set timezone ke WIB
                                    $hour = date('H'); // Mengambil jam saat ini (format 24 jam)
                                    $greeting = '';
                                    if ($hour >= 5 && $hour < 11) { // 05:00 - 10:59
                                        $greeting = 'Pagi';
                                    } elseif ($hour >= 11 && $hour < 15) { // 11:00 - 14:59
                                        $greeting = 'Siang';
                                    } elseif ($hour >= 15 && $hour < 18) { // 15:00 - 17:59
                                        $greeting = 'Sore';
                                    } else { // 18:00 - 04:59
                                        $greeting = 'Malam';
                                    }
                                @endphp

                                <h4 class="fs-16 fw-semibold mb-1 mb-md-2">Selamat {{ $greeting }}, <span class="text-primary">{{ auth()->user()->nama_pic ?? 'Pengguna' }}!</span></h4>
                                <p class="text-muted mb-0">Ini yang terjadi dengan toko Anda hari ini.</p>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        @include('partials.footer')

    </div>
</div>
@include('partials.right-sidebar')

@include('partials.vendor-scripts')

<script src="assets/js/app.js"></script>

</body>

</html>