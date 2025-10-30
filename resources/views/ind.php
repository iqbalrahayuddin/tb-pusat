{{-- partials/session.php DIHAPUS. Laravel menangani session secara otomatis --}}
{{-- partials/main.php diganti dengan asumsi file Anda ada di resources/views/partials/main.blade.php --}}
@include('partials.main') 

<head>

    {{-- 
      Mengubah PHP native menjadi Blade include.
      Blade mengasumsikan file ada di:
      resources/views/partials/title-meta.blade.php 
    --}}
    @include('partials.title-meta', ['title' => 'Dashboard'])

    {{-- 
      Blade mengasumsikan file ada di:
      resources/views/partials/head-css.blade.php 
    --}}
    @include('partials.head-css')

</head>

{{-- 
  Blade mengasumsikan file ada di:
  resources/views/partials/body.blade.php 
--}}
@include('partials.body')

<div id="layout-wrapper">

    {{-- 
      Blade mengasumsikan file ada di:
      resources/views/partials/menu.blade.php 
    --}}
    @include('partials.menu')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <div>
                                {{-- Mengambil data user yang sedang login --}}
                                <h4 class="fs-16 fw-semibold mb-1 mb-md-2">Good Morning, 
                                    <span class="text-primary">{{ Auth::user()->nama_pic }}!</span>
                                </h4>
                                {{-- Teks "Here's what's happening..." telah dihapus sesuai permintaan --}}
                            </div>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Clivax</a></li>
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                            </div>
                    D   </div>
                </div>
                </div>

                {{-- Card "Data User (Session)" telah dihapus sesuai permintaan --}}

                </div>
            </div>
        {{-- 
          Blade mengasumsikan file ada di:
          resources/views/partials/footer.blade.php 
        --}}
        @include('partials.footer')

    </div>
    </div>
{{-- 
  Blade mengasumsikan file ada di:
  resources/views/partials/right-sidebar.blade.php 
--}}
@include('partials.right-sidebar')

{{-- 
  Blade mengasumsikan file ada di:
  resources/views/partials/vendor-scripts.blade.php 
--}}
@include('partials.vendor-scripts')


<script src="assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="assets/js/pages/dashboard.init.js"></script>

<script src="assets/js/app.js"></script>
</body>

</html>