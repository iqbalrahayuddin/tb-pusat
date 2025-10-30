@include('partials.session')
@include('partials.main')

    <head>

        @include('partials.title-meta', ['title' => 'Manajemen Stok'])

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
                                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                                    <h4 class="card-title mb-0">Manajemen Stok</h4>

                                    <div class="d-flex flex-wrap gap-2" id="stock-filter-buttons" role="group" aria-label="Filter Status Stok">
                                        <button type="button" class="btn btn-secondary btn-filter active" data-filter="" id="filter-all">
                                            Semua <span class="badge bg-dark text-light ms-1">0</span>
                                        </button>
                                        <button type="button" class="btn btn-success btn-filter" data-filter="bg-success" id="filter-aman">
                                            Stok Aman <span class="badge bg-dark text-light ms-1">0</span>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-filter" data-filter="bg-warning" id="filter-warning">
                                            Stok Peringatan <span class="badge bg-dark text-light ms-1">0</span>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-filter" data-filter="bg-danger" id="filter-danger">
                                            Stok Bahaya <span class="badge bg-dark text-light ms-1">0</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-hover table-bordered table-striped" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Produk</th>
                                                    <th>Stok</th>
                                                    <th>Kategori</th>
                                                    <th>Supplier</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Contoh Produk A</td>
                                                    <td>
                                                        <span class="badge bg-success" style="width: 55px; font-size: .80rem;">100</span>
                                                    </td>
                                                    <td>Contoh Kategori</td>
                                                    <td>Contoh Supplier</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" 
                                                                data-bs-target="#batasiModal"
                                                                data-bs-product-name="Contoh Produk A"
                                                                data-bs-batas-kuning="50"
                                                                data-bs-batas-merah="20">
                                                            Batasi Stok
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Contoh Produk B</td>
                                                    <td>
                                                        <span class="badge bg-warning text-dark" style="width: 55px; font-size: .80rem;">40</span>
                                                    </td>
                                                    <td>Contoh Kategori</td>
                                                    <td>Contoh Supplier</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" 
                                                                data-bs-target="#batasiModal"
                                                                data-bs-product-name="Contoh Produk B"
                                                                data-bs-batas-kuning="50"
                                                                data-bs-batas-merah="20">
                                                            Batasi Stok
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Contoh Produk C</td>
                                                    <td>
                                                        <span class="badge bg-danger" style="width: 55px; font-size: .80rem;">15</span>
                                                    </td>
                                                    <td>Contoh Kategori</td>
                                                    <td>Contoh Supplier</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" 
                                                                data-bs-target="#batasiModal"
                                                                data-bs-product-name="Contoh Produk C"
                                                                data-bs-batas-kuning="50"
                                                                data-bs-batas-merah="20">
                                                            Batasi Stok
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Contoh Produk D</td>
                                                    <td>
                                                        <span class="badge bg-success" style="width: 55px; font-size: .80rem;">120</span>
                                                    </td>
                                                    <td>Kategori Lain</td>
                                                    <td>Supplier Lain</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" 
                                                                data-bs-target="#batasiModal"
                                                                data-bs-product-name="Contoh Produk D"
                                                                data-bs-batas-kuning="30"
                                                                data-bs-batas-merah="10">
                                                            Batasi Stok
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Contoh Produk E</td>
                                                    <td>
                                                        <span class="badge bg-danger" style="width: 55px; font-size: .80rem;">0</span>
                                                    </td>
                                                    <td>Kategori Habis</td>
                                                    <td>Supplier X</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" 
                                                                data-bs-target="#batasiModal"
                                                                data-bs-product-name="Contoh Produk E"
                                                                data-bs-batas-kuning="10"
                                                                data-bs-batas-merah="5">
                                                            Batasi Stok
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

    <div class="modal fade" id="batasiModal" tabindex="-1" aria-labelledby="batasiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="batasiModalLabel">Atur Batas Stok untuk: <span class="fw-bold" id="namaProdukModal"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formBatasiStok">
                        <div class="mb-3">
                            <label for="batas-kuning" class="form-label">Batas Peringatan (Kuning)</label>
                            <input type="number" class="form-control" id="batas-kuning" name="batas_kuning" placeholder="Contoh: 50">
                            <div class="form-text">Stok akan berwarna kuning jika di bawah angka ini.</div>
                        </div>
                        <div class="mb-3">
                            <label for="batas-merah" class="form-label">Batas Bahaya (Merah)</label>
                            <input type="number" class="form-control" id="batas-merah" name="batas_merah" placeholder="Contoh: 20">
                            <div class="form-text">Stok akan berwarna merah jika di bawah angka ini.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="simpanBatasStok">Simpan Pengaturan</button>
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

    <script src="assets/js/app.js"></script>

    <script>
    $(document).ready(function() {
        
        var table = $('#datatable').DataTable();
        var activeFilter = ""; // "" berarti "Semua"

        // --- 3. Daftarkan FUNGSI FILTER KUSTOM ---
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                
                var trNode = table.row(dataIndex).node();
                if (!trNode) {
                    return false;
                }

                // --- LOGIKA STOK 0 ---
                var stockText = $(trNode).find('td:eq(1) span.badge').text();
                var stockValue = parseInt(stockText, 10);

                // ATURAN 1: Jika stok adalah 0, selalu sembunyikan
                if (stockValue === 0) {
                    return false; // Sembunyikan baris
                }

                // ATURAN 2: Jika filter "Semua" aktif, tampilkan
                if (activeFilter === "") {
                    return true;
                }

                // ATURAN 3: Cek filter warna
                if ($(trNode).find('td:eq(1) span').hasClass(activeFilter)) {
                    return true; // Tampilkan baris ini
                }

                return false;
            }
        );

        // 4. Event listener untuk TOMBOL FILTER
        $('#stock-filter-buttons').on('click', '.btn-filter', function() {
            activeFilter = $(this).data('filter');
            table.draw(); // Panggil .draw() untuk menerapkan filter kustom
            $('#stock-filter-buttons .btn-filter').removeClass('active');
            $(this).addClass('active');
        });


        // 5. Fungsi untuk MENGHITUNG JUMLAH di badge
        function updateFilterCounts() {
            var allRows = table.rows().nodes(); 
            
            var amanCount = 0;
            var warningCount = 0;
            var dangerCount = 0;

            // Iterasi semua baris
            $(allRows).each(function() {
                var stockText = $(this).find('td:eq(1) span.badge').text();
                var stockValue = parseInt(stockText, 10);

                // HANYA hitung jika stok > 0
                if (stockValue > 0) {
                    if ($(this).find('td:eq(1) span').hasClass('bg-success')) {
                        amanCount++;
                    }
                    if ($(this).find('td:eq(1) span').hasClass('bg-warning')) {
                        warningCount++;
                    }
                    if ($(this).find('td:eq(1) span').hasClass('bg-danger')) {
                        dangerCount++;
                    }
                }
            });

            var allCount = amanCount + warningCount + dangerCount;

            // Update badge di tombol filter
            $('#filter-all .badge').text(allCount);
            $('#filter-aman .badge').text(amanCount);
            $('#filter-warning .badge').text(warningCount);
            $('#filter-danger .badge').text(dangerCount);
        }

        updateFilterCounts();
        table.draw();


        // --- Logika untuk Modal Batasi Stok ---
        var batasiModal = document.getElementById('batasiModal');
        
        if (batasiModal) {
            batasiModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var productName = button.getAttribute('data-bs-product-name');
                var batasKuning = button.getAttribute('data-bs-batas-kuning');
                var batasMerah = button.getAttribute('data-bs-batas-merah');
                
                var modalTitle = batasiModal.querySelector('#namaProdukModal');
                var inputKuning = batasiModal.querySelector('#batas-kuning');
                var inputMerah = batasiModal.querySelector('#batas-merah');

                modalTitle.textContent = productName;
                inputKuning.value = batasKuning;
                inputMerah.value = batasMerah;
            });
        }

        var simpanBtn = document.getElementById('simpanBatasStok');
        if (simpanBtn) {
            simpanBtn.addEventListener('click', function() {
                var batasKuningVal = document.getElementById('batas-kuning').value;
                var batasMerahVal = document.getElementById('batas-merah').value;
                var productName = document.getElementById('namaProdukModal').textContent;
                
                console.log('Menyimpan pengaturan untuk: ' + productName);
                console.log('Batas Kuning: ' + batasKuningVal);
                console.log('Batas Merah: ' + batasMerahVal);

                alert('Pengaturan untuk ' + productName + ' telah disimpan! (Simulasi, cek console log)');

                var modalInstance = bootstrap.Modal.getInstance(batasiModal);
                modalInstance.hide();
                
                // location.reload(); 
            });
        }
    });
    </script>
    </body>

</html>