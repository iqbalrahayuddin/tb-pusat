@include('partials.session')
@include('partials.main')

    <head>

        @include('partials.title-meta', ['title' => 'Input Pengeluaran'])

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
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Input Pengeluaran</h4>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                        + Tambah Pengeluaran
                                    </button>
                                </div>
                                <div class="card-body">

                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <h4 class="alert-heading">Terjadi Kesalahan!</h4>
                                            <p>Pastikan semua data terisi dengan benar:</p>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                    
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-hover table-bordered table-striped" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Keterangan</th>
                                                    <th>Nomor Nota</th>
                                                    <th>Kredit</th>
                                                    <th>Bukti</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pengeluarans as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                                    <td>{{ $item->keterangan }}</td>
                                                    <td>{{ $item->nomor_nota }}</td>
                                                    <td>Rp {{ number_format($item->kredit, 0, ',', '.') }}</td>
                                                    <td>
                                                        @if($item->bukti)
                                                            <a href="{{ route('pengeluaran.bukti', $item->id) }}" target="_blank" class="btn btn-info btn-sm">
                                                                Lihat
                                                            </a>
                                                        @else
                                                            <span class="badge bg-secondary">Tidak ada</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-sm edit-btn" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editModal"
                                                                data-id="{{ $item->id }}"
                                                                data-tanggal="{{ $item->tanggal }}"
                                                                data-keterangan="{{ $item->keterangan }}"
                                                                data-kredit="{{ $item->kredit }}">
                                                            Edit
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#hapusModal"
                                                                data-id="{{ $item->id }}">
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
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Pengeluaran Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf <div class="modal-body">
                        <div class="mb-3">
                            <label for="tanggal-pengeluaran" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal-pengeluaran" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Contoh: Beli ATK" required>{{ old('keterangan') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="kredit" class="form-label">Kredit (Jumlah Pengeluaran)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="kredit" name="kredit" placeholder="Contoh: 250000" value="{{ old('kredit') }}" required>
                            </div>
                        </div>
                         <div class="mb-3">
                            <label for="bukti" class="form-label">Bukti (Nota/Foto)</label>
                            <input type="file" class="form-control" id="bukti" name="bukti">
                            <small class="form-text text-muted">Tipe file: JPG, PNG, PDF. Maks 2MB.</small>
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

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data Pengeluaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="edit-tanggal" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="edit-keterangan" name="keterangan" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit-kredit" class="form-label">Kredit (Jumlah Pengeluaran)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="edit-kredit" name="kredit" required>
                            </div>
                        </div>
                         <div class="mb-3">
                            <label for="edit-bukti" class="form-label">Ganti Bukti (Opsional)</label>
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
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE') <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
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
    <script src="assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>

    <script src="assets/js/pages/datatables-base.init.js"></script>

    <script src="assets/js/app.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // --- Logika untuk Modal Edit ---
            const editModal = document.getElementById('editModal');
            if (editModal) {
                editModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget; // Tombol yang memicu modal
                    
                    // Ekstrak data dari atribut data-*
                    const id = button.getAttribute('data-id');
                    const tanggal = button.getAttribute('data-tanggal');
                    const keterangan = button.getAttribute('data-keterangan');
                    const kredit = button.getAttribute('data-kredit');

                    // Set URL action untuk form edit
                    const form = editModal.querySelector('#editForm');
                    form.action = '/pengeluaran/' + id; // URL: /pengeluaran/{id}

                    // Isi nilai-nilai form di dalam modal
                    editModal.querySelector('#edit-tanggal').value = tanggal;
                    editModal.querySelector('#edit-keterangan').value = keterangan;
                    editModal.querySelector('#edit-kredit').value = kredit;
                });
            }

            // --- Logika untuk Modal Hapus ---
            const hapusModal = document.getElementById('hapusModal');
            if (hapusModal) {
                hapusModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget; // Tombol yang memicu modal
                    const id = button.getAttribute('data-id');

                    // Set URL action untuk form hapus
                    const form = hapusModal.querySelector('#deleteForm');
                    form.action = '/pengeluaran/' + id; // URL: /pengeluaran/{id}
                });
            }

            // Jika ada error validasi saat submit, otomatis buka kembali modal 'tambah'
            @if ($errors->any())
                @if (old('modal_type') == 'tambah' || !old('modal_type')) // Asumsi default adalah modal tambah
                    var tambahModal = new bootstrap.Modal(document.getElementById('tambahModal'));
                    tambahModal.show();
                @endif
                // Anda bisa tambahkan logika serupa untuk modal edit jika diperlukan
            @endif

        });
    </script>
    </body>

</html>