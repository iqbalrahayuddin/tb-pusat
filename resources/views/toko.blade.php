@include('partials.session')
@include('partials.main')

    <head>

        @include('partials.title-meta', ['title' => 'Data Toko'])

        <link href="assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />

        <link href="assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />

        @include('partials.head-css')

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
                                    <h4 class="card-title mb-0">Data Toko</h4>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                        + Tambah Toko
                                    </button>
                                </div>
                                <div class="card-body">

                                    @if(session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    @if($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Gagal!</strong> Terjadi kesalahan:
                                            <ul>
                                                @foreach($errors->all() as $error)
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
                                                    <th>Toko</th>
                                                    <th>Lokasi</th>
                                                    <th>Penanggung Jawab</th>
                                                    <th>Nomor Telfon Toko</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($tokos as $toko)
                                                <tr>
                                                    <td>{{ $toko->nama_toko }}</td>
                                                    <td>{{ $toko->lokasi }}</td>
                                                    <td>{{ $toko->penanggung_jawab }}</td>
                                                    <td>
                                                        {{ $toko->nomor_telfon }}
                                                        
                                                        @if($toko->nomor_telfon)
                                                            @php
                                                                // Mengubah format 08... menjadi 628...
                                                                $nomor_wa = preg_replace('/^0/', '62', $toko->nomor_telfon);
                                                            @endphp
                                                            <a href="https://wa.me/{{ $nomor_wa }}" target="_blank" class="btn btn-success btn-sm ms-2" title="Chat via WhatsApp">
                                                                <i class="fab fa-whatsapp"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-sm" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editModal"
                                                                data-id="{{ $toko->id }}"
                                                                data-nama_toko="{{ $toko->nama_toko }}"
                                                                data-lokasi="{{ $toko->lokasi }}"
                                                                data-penanggung_jawab="{{ $toko->penanggung_jawab }}"
                                                                data-nomor_telfon="{{ $toko->nomor_telfon }}">
                                                            Edit
                                                        </button>
                                                        
                                                        <button type="button" class="btn btn-danger btn-sm" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#hapusModal"
                                                                data-id="{{ $toko->id }}">
                                                            Hapus
                                                        </button>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Belum ada data toko.</td>
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
    
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Data Toko Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('toko.store') }}" method="POST">
                    @csrf <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama-toko" class="form-label">Nama Toko</label>
                            <input type="text" class="form-control" id="nama-toko" name="nama_toko" placeholder="Contoh: Toko Cabang A" required value="{{ old('nama_toko') }}">
                        </div>
                        <div class="mb-3">
                            <label for="lokasi-toko" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi-toko" name="lokasi" placeholder="Contoh: Jl. Merdeka No. 10" required value="{{ old('lokasi') }}">
                        </div>
                        <div class="mb-3">
                            <label for="penanggung-jawab" class="form-label">Penanggung Jawab</label>
                            <input type="text" class="form-control" id="penanggung-jawab" name="penanggung_jawab" placeholder="Contoh: Budi Santoso" required value="{{ old('penanggung_jawab') }}">
                        </div>
                        <div class="mb-3">
                            <label for="nomor-telfon" class="form-label">Nomor Telfon Toko</label>
                            <input type="text" class="form-control" id="nomor-telfon" name="nomor_telfon" placeholder="Contoh: 081234567890" value="{{ old('nomor_telfon') }}">
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
                    <h5 class="modal-title" id="editModalLabel">Edit Data Toko</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST"> 
                    @csrf @method('PUT') <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-nama-toko" class="form-label">Nama Toko</label>
                            <input type="text" class="form-control" id="edit-nama-toko" name="nama_toko" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-lokasi-toko" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="edit-lokasi-toko" name="lokasi" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-penanggung-jawab" class="form-label">Penanggung Jawab</label>
                            <input type="text" class="form-control" id="edit-penanggung-jawab" name="penanggung_jawab" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-nomor-telfon" class="form-label">Nomor Telfon Toko</label>
                            <input type="text" class="form-control" id="edit-nomor-telfon" name="nomor_telfon">
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
                <form id="hapusForm" method="POST">
                    @csrf @method('DELETE') <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data toko ini?</p>
                        <p><strong><span id="toko-yang-dihapus"></span></strong></p>
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
            var editModal = document.getElementById('editModal');
            if (editModal) {
                editModal.addEventListener('show.bs.modal', function(event) {
                    // Tombol yang memicu modal
                    var button = event.relatedTarget;
                    
                    // Ekstrak data dari atribut data-*
                    var id = button.getAttribute('data-id');
                    var namaToko = button.getAttribute('data-nama_toko');
                    var lokasi = button.getAttribute('data-lokasi');
                    var penanggungJawab = button.getAttribute('data-penanggung_jawab');
                    var nomorTelfon = button.getAttribute('data-nomor_telfon');
                    
                    // Dapatkan form di dalam modal
                    var form = document.getElementById('editForm');
                    
                    // Set action form ke route update yang benar
                    // Contoh: /toko/5
                    form.action = '{{ url("toko") }}/' + id;
                    
                    // Isi nilai input di dalam modal
                    form.querySelector('#edit-nama-toko').value = namaToko;
                    form.querySelector('#edit-lokasi-toko').value = lokasi;
                    form.querySelector('#edit-penanggung-jawab').value = penanggungJawab;
                    form.querySelector('#edit-nomor-telfon').value = nomorTelfon;
                });
            }

            // --- Logika untuk Modal Hapus ---
            var hapusModal = document.getElementById('hapusModal');
            if (hapusModal) {
                hapusModal.addEventListener('show.bs.modal', function(event) {
                    // Tombol yang memicu modal
                    var button = event.relatedTarget;
                    
                    // Ekstrak data dari atribut data-*
                    var id = button.getAttribute('data-id');
                    
                    // Dapatkan form di dalam modal
                    var form = document.getElementById('hapusForm');
                    
                    // Set action form ke route destroy yang benar
                    // Contoh: /toko/5
                    form.action = '{{ url("toko") }}/' + id;
                });
            }

        });
    </script>
    </body>

</html>