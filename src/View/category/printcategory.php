<head>
    <title>E-Budgeting</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= asset('stisla-1-2.2.0/dist/assets/modules/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('stisla-1-2.2.0/dist/assets/modules/fontawesome/css/all.min.css') ?>">
    <link rel="shortcut icon" href="<?= asset('ebudgeting.jpg') ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?= asset('ebudgeting.jpg') ?>" type="image/png">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= asset('stisla-1-2.2.0/dist/assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('stisla-1-2.2.0/dist/assets/css/components.css') ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<style>
@media print {
    body * {
        visibility: hidden; /* Sembunyikan semua elemen */
    }
    #print-area, #print-area * {
        visibility: visible; /* Tampilkan hanya elemen di dalam area cetak */
    }
    #print-area {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate,
    .dataTables_wrapper .dataTables_length {
        display: none; /* Sembunyikan elemen kontrol DataTables */
    }
}

</style>

<body>
<div id="print-area">
        <center><h4>Data Category Expenses</h4></center>
        <section class="section">
            <div class="card-body">
                <table id="datatable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Code Category</th>
                            <th>Category</th>
                            <th>Group</th>
                            <th>Sub</th>
                            <th>Validity</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Code Category</th>
                            <th>Category</th>
                            <th>Group</th>
                            <th>Sub</th>
                            <th>Validity</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
    </div>
</body>
    <script src="<?= asset('stisla-1-2.2.0/dist/assets/js/stisla.js') ?>"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

    <!-- Template JS File -->
    <script src="<?= asset('stisla-1-2.2.0/dist/assets/js/scripts.js') ?>"></script>
    <script src="<?= asset('stisla-1-2.2.0/dist/assets/js/custom.js') ?>"></script>
<script>
    // Fungsi inisialisasi DataTables khusus untuk halaman ini
    function initDataTable() {
        if ($.fn.dataTable.isDataTable('#datatable')) {
            $('#datatable').DataTable().clear().destroy(); // Hancurkan DataTable yang sudah ada
        }
        $('#datatable').DataTable({
            ajax: '<?= base_url() ?>/getcategory',
            processing: true,
            serverSide: true,
            select: true,
            responsive: true,
            columns: [{
                    data: 'uuid',
                    name: 'uuid',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'code_category',
                    name: 'code_category'
                },
                {
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'group_category',
                    name: 'group_category'
                },
                {
                    data: 'sub',
                    name: 'sub'
                },
                {
                    data: 'validity',
                    name: 'validity',
                    render: function(data, type, row) {
                        return row.validity == 1 ? '<span class="badge badge-success">active</span>' :
                            '<span class="badge badge-danger">inactive</span>';
                    }
                },
            ],
            lengthMenu: [1000],
            // initComplete: function() {
            //     // Cetak setelah tabel selesai di-render
            //     // window.print();

            //     // setTimeout(function() {
            //     //     window.print();
            //     // }, 500); // Tambahkan delay 500ms
            // }
        });
    }

    // Panggil initDataTable saat halaman Products dimuat
    $(document).ready(function() {
        initDataTable();
        $('#datatable').on('init.dt', function() {
            console.log(document.getElementById('print-area').innerHTML);
            $('.dataTables_filter, .dataTables_info, .dataTables_paginate, .dataTables_length').hide();
                setTimeout(function() {
                    window.print(); // Cetak halaman
                }, 500); // Tambahkan sedikit delay
            });
    });
</script>
