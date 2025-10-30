@include('partials.session')
@include('partials.main')

    <head>

        @include('partials.title-meta', ['title' => 'Produk Toko'])

        <link href="assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />

        @include('partials.head-css')

        {{-- Library untuk generate Barcode --}}
        <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

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
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Manajemen Produk (Toko Buku/Kitab)</h4>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                        + Tambah Produk
                                    </button>
                                </div>
                                <div class="card-body">

                                    {{-- Menampilkan Pesan Sukses --}}
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    {{-- Menampilkan Error Validasi --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <h4 class="alert-heading">Terjadi Kesalahan!</h4>
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    {{-- Tampilkan error id_produk secara spesifik --}}
                                                    @if (str_contains($error, 'id produk'))
                                                        <li>ID Produk (SKU) tersebut sudah digunakan.</li>
                                                    @else
                                                        <li>{{ $error }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                    
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-hover table-bordered table-striped" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID Produk (SKU)</th>
                                                    <th>Nama Produk</th>
                                                    <th>Kategori</th>
                                                    <th>Barcode</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- Loop data produk --}}
                                                @forelse ($produks as $produk)
                                                <tr>
                                                    <td>{{ $produk->id_produk }}</td>
                                                    <td>{{ $produk->nama_produk }}</td>
                                                    <td>{{ $produk->kategori->nama_kategori ?? 'N/A' }}</td>
                                                    <td>
                                                        {{-- Elemen SVG ini akan diisi oleh JsBarcode --}}
                                                        <svg class="barcode-item"
                                                            jsbarcode-format="CODE128"
                                                            jsbarcode-value="{{ $produk->id_produk }}"
                                                            jsbarcode-displayValue="false"
                                                            jsbarcode-width="1.5"
                                                            jsbarcode-height="30"
                                                            jsbarcode-margin="0">
                                                        </svg>
                                                    </td>
                                                    <td>
                                                        {{-- Tombol Edit dengan data-id --}}
                                                        <button type="button" class="btn btn-warning btn-sm" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editModal"
                                                                data-id="{{ $produk->id }}"
                                                                data-url="{{ route('produk.show', $produk->id) }}">
                                                            Edit
                                                        </button>
                                                        
                                                        {{-- Tombol Hapus dengan data-id --}}
                                                        <button type="button" class="btn btn-danger btn-sm" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#hapusModal"
                                                                data-id="{{ $produk->id }}">
                                                            Hapus
                                                        </button>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    {{-- Colspan disesuaikan menjadi 5 --}}
                                                    <td colspan="5" class="text-center">Belum ada data produk.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div> </div>
                    </div>
                </div>
            @include('partials.footer')
        </div>
        </div>

    {{-- =================================== MODAL TAMBAH =================================== --}}
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- Form untuk Tambah Data --}}
                <form action="{{ route('produk.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Contoh: Kitab Jurumiyah" value="{{ old('nama_produk') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_produk_tambah" class="form-label">ID Produk (SKU)</label>
                            {{-- Memanggil fungsi JS saat mengetik --}}
                            <input type="text" class="form-control" id="id_produk_tambah" name="id_produk" placeholder="Contoh: KB-001" value="{{ old('id_produk') }}" required oninput="generateBarcodePreview('tambah')">
                        </div>

                        <div class="mb-3 text-center">
                            <label class="form-label">Preview Barcode</label><br>
                            {{-- Tempat untuk menampilkan preview barcode --}}
                            <svg id="barcode-tambah-preview"></svg>
                        </div>
                        
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori_id" name="kategori_id" required>
                                <option value="" selected disabled>Pilih Kategori...</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- =================================== MODAL EDIT =================================== --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- Form untuk Edit Data (action diatur oleh JS) --}}
                <form id="editForm" method="POST"> 
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-nama-produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="edit-nama-produk" name="nama_produk" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit-id-produk" class="form-label">ID Produk (SKU)</label>
                             {{-- Memanggil fungsi JS saat mengetik --}}
                            <input type="text" class="form-control" id="edit-id-produk" name="id_produk" required oninput="generateBarcodePreview('edit')">
                        </div>

                        <div class="mb-3 text-center">
                            <label class="form-label">Preview Barcode</label><br>
                             {{-- Tempat untuk menampilkan preview barcode --}}
                            <svg id="barcode-edit-preview"></svg>
                        </div>

                        <div class="mb-3">
                            <label for="edit-kategori-produk" class="form-label">Kategori</label>
                            <select class="form-select" id="edit-kategori-produk" name="kategori_id" required>
                                <option value="" disabled>Pilih Kategori...</option>
                                 {{-- Dropdown ini sama dengan modal tambah --}}
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- =================================== MODAL HAPUS =================================== --}}
    <div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- Form untuk Hapus Data (action diatur oleh JS) --}}
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data produk ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @include('partials.right-sidebar')

    @include('partials.vendor-scripts')

    {{-- Script DataTables --}}
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>

    {{-- File datatables-base.init.js dihapus agar kita bisa inisialisasi manual di bawah --}}
    {{-- <script src="assets/js/pages/datatables-base.init.js"></script> --}}

    <script src="assets/js/app.js"></script>

    <script>
        // Fungsi untuk generate barcode di modal
        // Kita letakkan di 'window' agar bisa diakses oleh 'oninput'
        window.generateBarcodePreview = function(type, value = null) {
            let inputId, previewId;
            if (type === 'tambah') {
                inputId = 'id_produk_tambah';
                previewId = 'barcode-tambah-preview';
            } else { // edit
                inputId = 'edit-id-produk';
                previewId = 'barcode-edit-preview';
            }

            let inputValue = value !== null ? value : document.getElementById(inputId).value;
            let previewElement = document.getElementById(previewId);

            // Hapus barcode lama
            while (previewElement.firstChild) {
                previewElement.removeChild(previewElement.firstChild);
            }

            // Buat barcode baru jika ada input
            if (inputValue) {
                try {
                    JsBarcode(previewElement, inputValue, {
                        format: "CODE128",
                        displayValue: true,
                        fontSize: 14,
                        width: 1.5,
                        height: 40
                    });
                } catch (e) {
                    // Tangani error jika format tidak valid
                    console.error(e);
                }
            }
        }


        // Gunakan jQuery $(document).ready() karena DataTables adalah plugin jQuery
        $(document).ready(function() {
            
            // Inisialisasi DataTables secara manual
            $('#datatable').DataTable({
                "responsive": true,
                "drawCallback": function( settings ) {
                    // Fungsi ini akan dipanggil SETIAP KALI tabel digambar ulang
                    // (termasuk saat sorting, searching, atau pindah halaman)
                    // Ini memastikan barcode di tabel selalu ter-render.
                    JsBarcode(".barcode-item").init();
                }
            });


            // --- Logika untuk Modal Edit ---
            var editModal = document.getElementById('editModal');
            var editForm = document.getElementById('editForm');
            
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; 
                var productId = button.getAttribute('data-id'); 
                var showUrl = button.getAttribute('data-url');

                // 1. Atur action form
                var updateUrl = '{{ url("produk") }}/' + productId;
                editForm.setAttribute('action', updateUrl);

                // 2. Ambil data produk via AJAX (fetch)
                fetch(showUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // 3. Isi form modal dengan data
                        document.getElementById('edit-nama-produk').value = data.nama_produk;
                        document.getElementById('edit-id-produk').value = data.id_produk; // Diubah
                        document.getElementById('edit-kategori-produk').value = data.kategori_id;
                        
                        // 4. Generate barcode preview saat modal dibuka
                        generateBarcodePreview('edit', data.id_produk); 
                    })
                    .catch(error => {
                        console.error('Error fetching product data:', error);
                        alert('Gagal mengambil data produk.');
                        var modal = bootstrap.Modal.getInstance(editModal);
                        modal.hide();
                    });
            });


            // --- Logika untuk Modal Hapus ---
            var hapusModal = document.getElementById('hapusModal');
            var deleteForm = document.getElementById('deleteForm');

            hapusModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var productId = button.getAttribute('data-id'); 

                // 1. Atur action form
                var deleteUrl = '{{ url("produk") }}/' + productId;
                deleteForm.setAttribute('action', deleteUrl);
            });

        });
    </script>
    </body>

</html>