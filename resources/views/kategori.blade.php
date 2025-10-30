@include('partials.session')
@include('partials.main')

    <head>

        @include('partials.title-meta', ['title' => 'Kategori Kitab/Buku'])

        <link href="assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />

        <link href="assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />

        @include('partials.head-css')

    </head>

    @include('partials.body')

    <div id="layout-wrapper">

        @include('partials.menu')

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    {{-- MENAMPILKAN VALIDATION ERRORS --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    {{-- MENAMPILKAN NOTIFIKASI SUKSES (jika pakai session 'toast_success') --}}
                    @if (session('toast_success'))
                        <div class="alert alert-success">
                            {{ session('toast_success') }}
                        </div>
                    @endif


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Kategori Kitab & Buku</h4>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                        + Tambah Kategori
                                    </button>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="table-responsive">
                                        {{-- 
                                          PERUBAHAN DI SINI:
                                          id="datatable" hanya ditambahkan jika $kategoris->isNotEmpty() 
                                          untuk mencegah error DataTables pada tabel kosong.
                                        --}}
                                        <table @if($kategoris->isNotEmpty()) id="datatable" @endif 
                                               class="table table-hover table-bordered table-striped" 
                                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Nama Kategori</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- 1. Menggunakan Data Real --}}
                                                @forelse ($kategoris as $kategori)
                                                    <tr>
                                                        <td>{{ $kategori->nama_kategori }}</td>
                                                        <td>{{ $kategori->keterangan ?? '-' }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-warning btn-sm btn-edit" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editModal"
                                                                data-id="{{ $kategori->id }}"
                                                                data-nama="{{ $kategori->nama_kategori }}"
                                                                data-keterangan="{{ $kategori->keterangan }}"
                                                                data-url="{{ route('kategori.update', $kategori->id) }}">
                                                                Edit
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm btn-hapus" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#hapusModal"
                                                                data-url="{{ route('kategori.destroy', $kategori->id) }}">
                                                                Hapus
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        {{-- Baris ini sekarang aman karena DataTables tidak diinisialisasi --}}
                                                        <td colspan="3" class="text-center">Belum ada data kategori.</td>
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

    {{-- 5. CRUD: Modal Tambah --}}
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Kategori Kitab/Buku Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama-kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama-kategori" name="nama_kategori" placeholder="Contoh: Fiqih" value="{{ old('nama_kategori') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Contoh: Kitab-kitab tentang fiqih (opsional)">{{ old('keterangan') }}</textarea>
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

    {{-- 5. CRUD: Modal Edit --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Kategori Kitab/Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- Form action-nya akan diisi oleh JavaScript --}}
                <form id="editForm" method="POST"> 
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-nama-kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="edit-nama-kategori" name="nama_kategori" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="edit-keterangan" name="keterangan" rows="3"></textarea>
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

    {{-- 5. CRUD: Modal Hapus --}}
    <div class="modal fade"id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- Form action-nya akan diisi oleh JavaScript --}}
                <form id="hapusForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data kategori ini?</p>
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

    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>

    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets_libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>

    {{-- Skrip init DataTables ini sekarang hanya akan berjalan jika id="datatable" ada --}}
    <script src="assets/js/pages/datatables-base.init.js"></script>

    <script src="assets/js/app.js"></script>

    {{-- 5. SCRIPT PENTING UNTUK MODAL DINAMIS --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- Logika untuk Modal Edit ---
        const editModal = document.getElementById('editModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function(event) {
                // Tombol yang memicu modal
                const button = event.relatedTarget;

                // Ekstrak data dari atribut data-*
                const nama = button.getAttribute('data-nama');
                const keterangan = button.getAttribute('data-keterangan');
                const url = button.getAttribute('data-url');

                // Perbarui konten modal
                const modalForm = editModal.querySelector('#editForm');
                const modalNamaInput = editModal.querySelector('#edit-nama-kategori');
                const modalKeteranganInput = editModal.querySelector('#edit-keterangan');

                modalForm.setAttribute('action', url);
                modalNamaInput.value = nama;
                modalKeteranganInput.value = keterangan;
            });
        }

        // --- Logika untuk Modal Hapus ---
        const hapusModal = document.getElementById('hapusModal');
        if (hapusModal) {
            hapusModal.addEventListener('show.bs.modal', function(event) {
                // Tombol yang memicu modal
                const button = event.relatedTarget;

                // Ekstrak URL dari atribut data-*
                const url = button.getAttribute('data-url');

                // Perbarui action form
                const modalForm = hapusModal.querySelector('#hapusForm');
                modalForm.setAttribute('action', url);
            });
        }

    });
    </script>
    </body>

</html>