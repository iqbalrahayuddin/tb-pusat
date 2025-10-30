@include('partials.session')
@include('partials.main')

<head>
    @include('partials.title-meta', ['title' => 'Input Pemasukan'])
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
                <div class="row">
                    <div class="col-12">
                        
                        {{-- Menampilkan Notifikasi Sukses/Error --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <p><strong>Data gagal disimpan. Periksa kesalahan berikut:</strong></p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        {{-- Akhir Notifikasi --}}

                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Input Pemasukan</h4>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                    + Tambah Pemasukan
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-hover table-bordered table-striped" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                                <th>Nomor Nota</th>
                                                <th>Debit</th>
                                                <th>Bukti</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Loop Data Dinamis dari Controller --}}
                                            @foreach ($pemasukans as $pemasukan)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $pemasukan->tanggal->format('d/m/Y') }}</td>
                                                    <td>{{ $pemasukan->keterangan }}</td>
                                                    <td>{{ $pemasukan->nomor_nota }}</td>
                                                    <td>{{ 'Rp ' . number_format($pemasukan->debit, 0, ',', '.') }}</td>
                                                    <td>
                                                        @if ($pemasukan->bukti)
                                                            {{-- === INI BAGIAN YANG DIPERBAIKI === --}}
                                                            <a href="{{ route('pemasukan.show', $pemasukan->id) }}" target="_blank" class="btn btn-info btn-sm">
                                                                Lihat
                                                            </a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{-- Tombol Edit dengan data- attributes --}}
                                                        <button type="button" class="btn btn-warning btn-sm" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editModal"
                                                                data-id="{{ $pemasukan->id }}"
                                                                data-tanggal="{{ $pemasukan->tanggal->format('Y-m-d') }}"
                                                                data-keterangan="{{ $pemasukan->keterangan }}"
                                                                data-debit="{{ $pemasukan->debit }}"
                                                                data-action="{{ route('pemasukan.update', $pemasukan->id) }}">
                                                            Edit
                                                        </button>
                                                        {{-- Tombol Hapus dengan data- attributes --}}
                                                        <button type="button" class="btn btn-danger btn-sm" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#hapusModal"
                                                                data-action="{{ route('pemasukan.destroy', $pemasukan->id) }}">
                                                            Hapus
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
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

<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Input Pemasukan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- Form untuk CREATE --}}
            <form action="{{ route('pemasukan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Contoh: Pembayaran SPP" value="{{ old('keterangan') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="debit" class="form-label">Debit</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="debit" name="debit" placeholder="500000" value="{{ old('debit') }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="bukti" class="form-label">Bukti (Opsional)</label>
                        <input type="file" class="form-control" id="bukti" name="bukti">
                    </div>
                    <small>Catatan: Nomor Nota akan dibuat otomatis (Contoh: TB-251030-001).</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Input Pemasukan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- Form untuk UPDATE --}}
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="edit-tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="edit-keterangan" name="keterangan" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-debit" class="form-label">Debit</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="edit-debit" name="debit" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit-bukti" class="form-label">Bukti</Ganti></label>
                        <input type="file" class="form-control" id="edit-bukti" name="bukti">
                        <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah bukti.</small>
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

<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                {{-- Form untuk DELETE --}}
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('partials.right-sidebar')
@include('partials.vendor-scripts')

<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="assets/js/pages/datatables-base.init.js"></script>
<script src="assets/js/app.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- Logika untuk Modal Edit ---
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function(event) {
            // Tombol yang memicu modal
            var button = event.relatedTarget;
            
            // Ambil data dari data-* attributes
            var action = button.getAttribute('data-action');
            var tanggal = button.getAttribute('data-tanggal');
            var keterangan = button.getAttribute('data-keterangan');
            var debit = button.getAttribute('data-debit');

            // Update action form modal
            var form = editModal.querySelector('#editForm');
            form.action = action;

            // Isi field-field di modal
            editModal.querySelector('#edit-tanggal').value = tanggal;
            editModal.querySelector('#edit-keterangan').value = keterangan;
            editModal.querySelector('#edit-debit').value = debit;
        });

        // --- Logika untuk Modal Hapus ---
        var hapusModal = document.getElementById('hapusModal');
        hapusModal.addEventListener('show.bs.modal', function(event) {
            // Tombol yang memicu modal
            var button = event.relatedTarget;
            
            // Ambil action URL dari data-action
            var action = button.getAttribute('data-action');

            // Update action form modal
            var form = hapusModal.querySelector('#deleteForm');
            form.action = action;
        });

        // --- Logika untuk menampilkan error validasi di modal ---
        @if ($errors->any())
            // Jika ada error validasi, cek errornya untuk modal mana
            // Ini asumsi sederhana, mungkin perlu disesuaikan jika field unik
            @if (old('keterangan') && !$errors->has('id'))
                // Kemungkinan error dari modal 'tambah'
                var tambahModal = new bootstrap.Modal(document.getElementById('tambahModal'));
                tambahModal.show();
            @else
                // Jika error terjadi saat update, modal edit tidak bisa otomatis terbuka
                // karena kita tidak tahu ID mana yang gagal di-edit.
                // Notifikasi alert di atas halaman sudah cukup.
            @endif
        @endif
    });
</script>
</body>

</html>