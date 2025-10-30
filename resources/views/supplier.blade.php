@include('partials.session')
@include('partials.main')

    <head>

        @include('partials.title-meta', ['title' => 'Supplier'])

        <link href="assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        
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
                                    <h4 class="card-title mb-0">Data Supplier</h4>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                        + Tambah Supplier
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
                                            <strong>Gagal!</strong> Terjadi kesalahan validasi:
                                            <ul class="mb-0">
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
                                                    <th>Supplier</th>
                                                    <th>Email</th>
                                                    <th>Nomor HP</th>
                                                    <th>Website</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                @foreach($suppliers as $supplier)
                                                <tr>
                                                    <td>{{ $supplier->nama }}</td>
                                                    <td>
                                                        {{ $supplier->email }}
                                                        @if($supplier->email)
                                                            <a href="mailto:{{ $supplier->email }}" class="btn btn-secondary btn-sm ms-1" title="Kirim Email">
                                                                <i class="bi bi-envelope"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $supplier->nomor_hp }}
                                                        @if($supplier->nomor_hp)
                                                            <a href="https://wa.me/{{ $supplier->nomor_hp }}" target="_blank" class="btn btn-success btn-sm ms-1" title="Chat WhatsApp">
                                                                <i class="bi bi-whatsapp"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $supplier->website }}
                                                        @if($supplier->website)
                                                            <a href="{{ $supplier->website }}" target="_blank" class="btn btn-info btn-sm ms-1" title="Kunjungi Website">
                                                                <i class="bi bi-globe"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-sm" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editModal" 
                                                                data-supplier="{{ $supplier->toJson() }}">
                                                            Edit
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#hapusModal" 
                                                                data-id="{{ $supplier->id }}">
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
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Supplier Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('supplier.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="supplier-nama" class="form-label">Nama Supplier</label>
                            <input type="text" class="form-control" id="supplier-nama" name="nama" placeholder="Contoh: PT. Sumber Makmur" value="{{ old('nama') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="supplier-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="supplier-email" name="email" placeholder="Contoh: info@supplier.com" value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label for="supplier-hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="supplier-hp" name="nomor_hp" placeholder="Contoh: 6281234567890" value="{{ old('nomor_hp') }}">
                        </div>
                        <div class="mb-3">
                            <label for="supplier-website" class="form-label">Website</label>
                            <input type="text" class="form-control" id="supplier-website" name="website" placeholder="Contoh: https://supplier.com" value="{{ old('website') }}">
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
                    <h5 class="modal-title" id="editModalLabel">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST"> 
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-supplier-nama" class="form-label">Nama Supplier</label>
                            <input type="text" class="form-control" id="edit-supplier-nama" name="nama" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit-supplier-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit-supplier-email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="edit-supplier-hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="edit-supplier-hp" name="nomor_hp">
                        </div>
                        <div class="mb-3">
                            <label for="edit-supplier-website" class="form-label">Website</label>
                            <input type="text" class="form-control" id="edit-supplier-website" name="website">
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
                    <p>Apakah Anda yakin ingin menghapus data supplier ini?</p>
                </div>
                <form id="deleteForm" method="POST"> 
                    @csrf
                    @method('DELETE')
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
    document.addEventListener('DOMContentLoaded', function () {
        
        var editModal = document.getElementById('editModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; 
                var supplier = JSON.parse(button.getAttribute('data-supplier'));
                var modal = this;
                var form = modal.querySelector('#editForm');
                
                // Isi nilai-nilai form (tanpa 'produk')
                modal.querySelector('#edit-supplier-nama').value = supplier.nama;
                // modal.querySelector('#edit-supplier-produk').value = supplier.produk || ''; // <-- DIHAPUS
                modal.querySelector('#edit-supplier-email').value = supplier.email || '';
                modal.querySelector('#edit-supplier-hp').value = supplier.nomor_hp || '';
                modal.querySelector('#edit-supplier-website').value = supplier.website || '';
                
                form.action = '{{ url("supplier") }}/' + supplier.id;
            });
        }

        var hapusModal = document.getElementById('hapusModal');
        if(hapusModal) {
            hapusModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; 
                var id = button.getAttribute('data-id');
                var form = this.querySelector('#deleteForm');
                form.action = '{{ url("supplier") }}/' + id;
            });
        }

    });
    </script>
    
    </body>

</html>