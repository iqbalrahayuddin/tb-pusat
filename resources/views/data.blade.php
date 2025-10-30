@include('partials.session')
@include('partials.main')

    <head>

        @include('partials.title-meta', ['title' => 'Unit Pendidikan'])

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
                                    <h4 class="card-title mb-0">Unit Pendidikan</h4>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                        + Tambah Unit
                                    </button>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-hover table-bordered table-striped" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Unit Pendidikan</th>
                                                    <th>Kategori</th>
                                                    <th>Kelas</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Madrasah Aliyah Program Keagamaan dan Sains Terpadu</td>
                                                    <td>Formal</td>
                                                    <td>X, XI, XII</td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal">
                                                            Edit
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal">
                                                            Hapus
                                                        </button>
                                                    </td>
                                                </tr>
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
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Unit Pendidikan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="unit-pendidikan" class="form-label">Nama Unit Pendidikan</label>
                            <input type="text" class="form-control" id="unit-pendidikan" placeholder="Contoh: Madrasah Tsanawiyah">
                        </div>
                        <div class="mb-3">
                            <label for="kategori-pendidikan" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori-pendidikan">
                                <option selected>Pilih Kategori...</option>
                                <option value="Formal">Formal</option>
                                <option value="Non-Formal">Non-Formal</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <div id="tambah-kelas-container">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="kelas[]" placeholder="Contoh: X">
                                    <button class="btn btn-danger btn-sm hapus-kelas-btn" type="button">-</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success btn-sm mt-2" id="tambah-kelas-btn">+ Tambah Kelas</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Unit Pendidikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="edit-unit-pendidikan" class="form-label">Nama Unit Pendidikan</label>
                            <input type="text" class="form-control" id="edit-unit-pendidikan" value="Madrasah Aliyah Program Keagamaan dan Sains Terpadu">
                        </div>
                        <div class="mb-3">
                            <label for="edit-kategori-pendidikan" class="form-label">Kategori</label>
                            <select class="form-select" id="edit-kategori-pendidikan">
                                <option value="Formal" selected>Formal</option>
                                <option value="Non-Formal">Non-Formal</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <div id="edit-kelas-container">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="kelas[]" value="X">
                                    <button class="btn btn-danger btn-sm edit-hapus-kelas-btn" type="button">-</button>
                                </div>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="kelas[]" value="XI">
                                    <button class="btn btn-danger btn-sm edit-hapus-kelas-btn" type="button">-</button>
                                </div>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="kelas[]" value="XII">
                                    <button class="btn btn-danger btn-sm edit-hapus-kelas-btn" type="button">-</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success btn-sm mt-2" id="edit-tambah-kelas-btn">+ Tambah Kelas</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Simpan Perubahan</button>
                </div>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>


    @include('partials.right-sidebar')

    @include('partials.vendor-scripts')

    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>

    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets_libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>

    <script src="assets/js/pages/datatables-base.init.js"></script>

    <script src="assets/js/app.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- Logika untuk Modal Tambah ---
        const tambahContainer = document.getElementById('tambah-kelas-container');
        const tambahBtn = document.getElementById('tambah-kelas-btn');

        if (tambahBtn) {
            tambahBtn.addEventListener('click', function() {
                const newField = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="kelas[]" placeholder="Contoh: XI">
                    <button class="btn btn-danger btn-sm hapus-kelas-btn" type="button">-</button>
                </div>`;
                tambahContainer.insertAdjacentHTML('beforeend', newField);
            });
        }

        // Event delegation untuk tombol hapus di modal tambah
        if (tambahContainer) {
            tambahContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('hapus-kelas-btn')) {
                    // Cek agar tidak menghapus input terakhir
                    if (tambahContainer.querySelectorAll('.input-group').length > 1) {
                        e.target.closest('.input-group').remove();
                    } else {
                        alert('Minimal harus ada satu input kelas.');
                    }
                }
            });
        }

        // --- Logika untuk Modal Edit ---
        const editContainer = document.getElementById('edit-kelas-container');
        const editBtn = document.getElementById('edit-tambah-kelas-btn');

        if (editBtn) {
            editBtn.addEventListener('click', function() {
                const newField = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="kelas[]" placeholder="Contoh: Kelas Baru">
                    <button class="btn btn-danger btn-sm edit-hapus-kelas-btn" type="button">-</button>
                </div>`;
                editContainer.insertAdjacentHTML('beforeend', newField);
            });
        }

        // Event delegation untuk tombol hapus di modal edit
        if (editContainer) {
            editContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('edit-hapus-kelas-btn')) {
                    // Cek agar tidak menghapus input terakhir
                    if (editContainer.querySelectorAll('.input-group').length > 1) {
                        e.target.closest('.input-group').remove();
                    } else {
                        alert('Minimal harus ada satu input kelas.');
                    }
                }
            });
        }

    });
    </script>
    </body>

</html>