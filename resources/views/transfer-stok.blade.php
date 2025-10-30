@include('partials.session')
@include('partials.main')

    <head>

        @include('partials.title-meta', ['title' => 'Rencana Transfer Stok'])

        <link href="assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        
        @include('partials.head-css')

        <style>
            /* Menyesuaikan kotak Select2 agar terlihat seperti .form-control Bootstrap */
            .select2-container .select2-selection--single {
                height: 38px; /* Menyamakan tinggi */
                border: 1px solid var(--bs-border-color);
                border-radius: var(--bs-border-radius);
                background-color: var(--bs-body-bg);
            }

            /* Menyesuaikan teks yang dipilih (agar putih di dark mode) */
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: var(--bs-body-color); /* Variabel ini kuncinya */
                line-height: 36px; /* Vertikal centering */
                padding-left: 0.75rem; /* Menyamakan padding */
            }

            /* Menyesuaikan panah dropdown */
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 36px;
                right: 0.75rem;
            }

            /* Styling untuk panel dropdown yang terbuka */
            .select2-dropdown {
                border: 1px solid var(--bs-border-color);
                border-radius: var(--bs-border-radius);
                background-color: var(--bs-body-bg);
                color: var(--bs-body-color);
            }

            /* Styling untuk kotak pencarian di dalam dropdown */
            .select2-container--default .select2-search--dropdown .select2-search__field {
                border: 1px solid var(--bs-border-color);
                background-color: var(--bs-body-bg);
                color: var(--bs-body-color); /* Teks di kotak search */
            }

            /* Styling untuk hasil pencarian (saat di-hover) */
            .select2-container--default .select2-results__option--highlighted[aria-selected] {
                background-color: var(--bs-primary); /* Warna primary tema */
                color: white;
            }
        </style>

    </head>

    @include('partials.body')

    <div id="layout-wrapper">

        @include('partials.menu')

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Formulir Tambah Rencana</h4>
                                </div>
                                <div class="card-body">
                                    
                                    <div id="form-tambah-rencana">
                                        <div class="row gy-3">
                                            <div class="col-md-12">
                                                <label for="produk-select" class="form-label">Pilih Produk (Bisa Dicari)</label>
                                                <select class="form-select" id="produk-select" name="produk_id">
                                                    <option value="">Pilih Produk...</option>
                                                    <option value="1">Sepatu Lari (Uk. 42)</option>
                                                    <option value="2">Kaos Polos (L, Hitam)</option>
                                                    <option value="3">Kemeja Batik (XL)</option>
                                                    <option value="4">Celana Jeans (32)</option>
                                                    <option value="5">Topi Baseball</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="dari-lokasi-select" class="form-label">Dari</label>
                                                <select class="form-select" id="dari-lokasi-select" name="dari_lokasi_id">
                                                    <option value="">Pilih Lokasi Asal...</option>
                                                    <option value="gudang_pusat">Gudang Pusat</option>
                                                    <option value="toko_jakarta">Toko Jakarta</option>
                                                    <option value="toko_bandung">Toko Bandung</option>
                                                    <option value="toko_surabaya">Toko Surabaya</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="ke-lokasi-select" class="form-label">Ke</label>
                                                <select class="form-select" id="ke-lokasi-select" name="ke_lokasi_id">
                                                    <option value="">Pilih Lokasi Tujuan...</option>
                                                    <option value="gudang_pusat">Gudang Pusat</option>
                                                    <option value="toko_jakarta">Toko Jakarta</option>
                                                    <option value="toko_bandung">Toko Bandung</option>
                                                    <option value="toko_surabaya">Toko Surabaya</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="jumlah-transfer-input" class="form-label">Jumlah Transfer Stok</label>
                                                <input type="number" class="form-control" id="jumlah-transfer-input" name="jumlah" placeholder="Masukkan jumlah" min="1">
                                            </div>

                                            <div class="col-12 text-end">
                                                <button type="button" class="btn btn-info" id="btn-tambah-rencana">Tambahkan ke Rencana</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Daftar Rencana Transfer Stok</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{-- route('stok.transfer.proses_semua') --}}" method="POST">
                                        @csrf
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Produk</th>
                                                        <th>Dari</th>
                                                        <th>Ke</th>
                                                        <th>Jumlah</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tabel-rencana-body">
                                                    </tbody>
                                            </table>
                                        </div>
                                        <div class="text-end mt-3">
                                            <button type="submit" class="btn btn-primary">Proses Semua Transfer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Riwayat Transfer Stok</h4>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-hover table-bordered table-striped" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Produk</th>
                                                    <th>Jumlah Transfer Stok</th>
                                                    <th>Dari</th>
                                                    <th>Ke</th>
                                                    <th>Petugas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Sepatu Lari (Uk. 42)</td>
                                                    <td>10</td>
                                                    <td>Gudang Pusat</td>
                                                    <td>Toko Jakarta</td>
                                                    <td>Admin Gudang</td>
                                                </tr>
                                                <tr>
                                                    <td>Kaos Polos (L, Hitam)</td>
                                                    <td>50</td>
                                                    <td>Gudang Pusat</td>
                                                    <td>Toko Bandung</td>
                                                    <td>Iqbal</td>
                                                </tr>
                                                <tr>
                                                    <td>Kemeja Batik (XL)</td>
                                                    <td>5</td>
                                                    <td>Toko Bandung</td>
                                                    <td>Toko Surabaya</td>
                                                    <td>Admin Bandung</td>
                                                </tr>
                                                </tbody>
                                        </table>
                                    </div>

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

    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="assets/js/pages/datatables-base.init.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="assets/js/app.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 pada dropdown produk
            $('#produk-select').select2({
                placeholder: 'Pilih Produk...',
                width: '100%' // Pastikan lebar sesuai
            });

            // Handle klik tombol "Tambahkan ke Rencana"
            $('#btn-tambah-rencana').on('click', function() {
                var produkSelect = $('#produk-select');
                var dariSelect = $('#dari-lokasi-select');
                var keSelect = $('#ke-lokasi-select');
                var jumlahInput = $('#jumlah-transfer-input');

                var produkId = produkSelect.val();
                var produkNama = produkSelect.find('option:selected').text();
                var dariId = dariSelect.val();
                var dariNama = dariSelect.find('option:selected').text();
                var keId = keSelect.val();
                var keNama = keSelect.find('option:selected').text();
                var jumlah = jumlahInput.val();

                if (!produkId || !dariId || !keId || !jumlah || parseInt(jumlah) <= 0) {
                    alert('Harap lengkapi semua field dengan benar.');
                    return;
                }

                if (dariId === keId) {
                    alert('Lokasi "Dari" dan "Ke" tidak boleh sama.');
                    return;
                }

                // Gunakan timestamp atau counter unik untuk array index
                var uniqueId = Date.now();
                var newRow = `
                    <tr>
                        <td>
                            ${produkNama}
                            <input type="hidden" name="transfer[${uniqueId}][produk_id]" value="${produkId}">
                        </td>
                        <td>
                            ${dariNama}
                            <input type="hidden" name="transfer[${uniqueId}][dari_lokasi_id]" value="${dariId}">
                        </td>
                        <td>
                            ${keNama}
                            <input type="hidden" name="transfer[${uniqueId}][ke_lokasi_id]" value="${keId}">
                        </td>
                        <td>
                            ${jumlah}
                            <input type="hidden" name="transfer[${uniqueId}][jumlah]" value="${jumlah}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm hapus-rencana-btn">Hapus</button>
                        </td>
                    </tr>
                `;

                $('#tabel-rencana-body').append(newRow);

                // Reset form input
                produkSelect.val(null).trigger('change'); // Reset Select2
                dariSelect.val('');
                keSelect.val('');
                jumlahInput.val('');
            });

            // Handle klik tombol "Hapus" di tabel rencana
            $('#tabel-rencana-body').on('click', '.hapus-rencana-btn', function() {
                $(this).closest('tr').remove();
            });

        });
    </script>

    </body>

</html>