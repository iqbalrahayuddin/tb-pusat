@include('partials.session')
@include('partials.main')

    <head>

        @include('partials.title-meta', ['title' => 'Riwayat Stok Produk Masuk'])

        <link href="assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />

        <link href="assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet"
            type="text/css" />

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
                                    <h4 class="card-title mb-0">Riwayat Stok Produk Masuk</h4>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#tambahModal">
                                        + Tambah Stok Masuk
                                    </button>
                                </div>
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-hover table-bordered table-striped"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Produk</th>
                                                    <th>Jumlah Stok Masuk</th>
                                                    <th>Petugas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Nama Produk A</td>
                                                    <td>100 Pcs</td>
                                                    <td>Iqbal Rahayuddin</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Produk B</td>
                                                    <td>50 Box</td>
                                                    <td>Admin</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div> </div> </div> </div>
            @include('partials.footer')

        </div>
        </div>
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Stok Produk Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="produk-nama" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="produk-nama" placeholder="Contoh: Nama Produk A">
                            </div>
                        <div class="mb-3">
                            <label for="produk-jumlah" class="form-label">Jumlah Stok Masuk</label>
                            <input type="number" class="form-control" id="produk-jumlah" placeholder="Contoh: 100">
                        </div>
                         <div class="mb-3">
                            <label for="produk-petugas" class="form-label">Petugas</label>
                            <input type="text" class="form-control" id="produk-petugas" value="Iqbal Rahayuddin" readonly>
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
    @include('partials.right-sidebar')

    @include('partials.vendor-scripts')

    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>

    <script src="assets/js/pages/datatables-base.init.js"></script>

    <script src="assets/js/app.js"></script>

    </body>

</html>