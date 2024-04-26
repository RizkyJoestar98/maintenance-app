<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title_page; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('users/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><?= $bread_crumb; ?></li>

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    History Transaction
                </h2>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="tbl_history" class="table table-bordered table-striped nowrap">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>CODE TRANSACTION</th>
                            <th>TRANSACTION TYPE</th>
                            <th>DATE</th>
                            <th>MATERIAL CODE</th>
                            <th>GR QUANTITY</th>
                            <th>IDENTITY PIC</th>
                            <th>DESCRIPTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($transaction_detail as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value->id_transaction ?></td>
                                <td><?= $value->transaction_type ?></td>
                                <td><?= $value->date ?></td>
                                <td><?= $value->code_material ?></td>
                                <td><?= $value->quantity ?></td>
                                <td><?= $value->identity_pic ?></td>
                                <td><?= $value->description ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>CODE TRANSACTION</th>
                            <th>TRANSACTION TYPE</th>
                            <th>DATE</th>
                            <th>MATERIAL CODE</th>
                            <th>GR QUANTITY</th>
                            <th>IDENTITY PIC</th>
                            <th>DESCRIPTION</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <?= form_open('users/search_filter', ['id' => 'search_form']) ?>
                    <label for="start_filter">Start</label>
                    <input class="form-control" type="date" name="start_filter" id="start_filter">
                    <br>
                    <label for="end_filter">End</label>
                    <input class="form-control" type="date" name="end_filter" id="end_filter">
                    <br>
                    <input class="btn btn-primary" type="submit" value="Search">
                    <?= form_close(); ?>
                </h2>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="tbl_filter" class="table table-bordered table-striped nowrap" style="display:none">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>CODE TRANSACTION</th>
                            <th>TRANSACTION TYPE</th>
                            <th>DATE</th>
                            <th>MATERIAL CODE</th>
                            <th>GR QUANTITY</th>
                            <th>IDENTITY PIC</th>
                            <th>DESCRIPTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated here by DataTables -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>CODE TRANSACTION</th>
                            <th>TRANSACTION TYPE</th>
                            <th>DATE</th>
                            <th>MATERIAL CODE</th>
                            <th>GR QUANTITY</th>
                            <th>IDENTITY PIC</th>
                            <th>DESCRIPTION</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    $(document).ready(function() {
        $("#tbl_history").DataTable({
            "scrollX": true,
            "responsive": false,
            "lengthChange": true,
            "autoWidth": false,
            select: {
                selected: true,
                style: 'multi'
            },
            "buttons": [{
                    extend: "excel",
                    text: "Excel"
                },
                {
                    extend: "print",
                    text: "Print",
                    title: '',
                    autoPrint: false,
                },
                {
                    extend: "pdf",
                    text: "Pdf"
                },
                {
                    extend: "selectAll",
                    text: "Select All"
                },
                {
                    extend: "selectNone",
                    text: "Cancel"
                }
            ]
        }).buttons().container().appendTo('#tbl_history_wrapper .col-md-6:eq(0)');

        // Inisialisasi DataTables di tabel yang diperbarui

        $('#search_form').submit(function(e) {
            e.preventDefault(); // Menghentikan perilaku bawaan dari form
            var form = $(this);
            // Kirim form data menggunakan Ajax
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                dataType: "JSON",
                success: function(response) {
                    if (response.success == true) {
                        if (response.data !== null) {
                            $('#tbl_filter').DataTable().destroy();
                            toastr.success(response.message);
                            $('#tbl_filter').show();
                            $('#tbl_filter').DataTable({
                                // Konfigurasi DataTables (seperti yang Anda terapkan sebelumnya)
                                // Konfigurasi DataTables
                                "paging": true,
                                "ordering": true,
                                "searching": true,
                                "scrollX": true,
                                "responsive": false,
                                "lengthChange": true,
                                "autoWidth": false,
                                "select": {
                                    "selected": true,
                                    "style": 'multi'
                                },
                                "buttons": [{
                                        "extend": "excel",
                                        "text": "Excel"
                                    },
                                    {
                                        "extend": "print",
                                        "text": "Print",
                                        "title": '',
                                        "autoPrint": false,
                                    },
                                    {
                                        "extend": "pdf",
                                        "text": "Pdf"
                                    },
                                    {
                                        "extend": "selectAll",
                                        "text": "Select All"
                                    },
                                    {
                                        "extend": "selectNone",
                                        "text": "Cancel"
                                    }
                                ],
                                data: response.data,
                                columns: [{
                                        data: 'no'
                                    }, // Kolom nomor urutan
                                    {
                                        data: 'id_transaction'
                                    },
                                    {
                                        data: 'transaction_type'
                                    },
                                    {
                                        data: 'date'
                                    },
                                    {
                                        data: 'code_material'
                                    },
                                    {
                                        data: 'quantity'
                                    },
                                    {
                                        data: 'identity_pic'
                                    },
                                    {
                                        data: 'description'
                                    }
                                ],
                                // Tempatkan tombol-tombol di dalam container yang sesuai
                                "dom": "<'row'<'col-md-6'B><'col-md-6'f>>" +
                                    "<'row'<'col-md-12'tr>>" +
                                    "<'row'<'col-md-6'l><'col-md-6'p>>",
                                "columnDefs": [{
                                    "width": "100%",
                                    "targets": 0
                                }]
                            });
                        } else {
                            // Hancurkan DataTable sebelumnya jika ada
                            $('#tbl_filter').DataTable().destroy();
                            // Jika tidak ada data yang ditemukan, tetap tampilkan DataTables dengan pesan kosong
                            $('#tbl_filter').show();
                            toastr.info(response.message);
                            $('#tbl_filter').DataTable({
                                data: [], // Gunakan array kosong untuk menampilkan datatable kosong
                                columns: [ // Tetap definisikan kolom-kolomnya, meskipun tidak ada data
                                    {
                                        data: 'no'
                                    },
                                    {
                                        data: 'id_transaction'
                                    },
                                    {
                                        data: 'transaction_type'
                                    },
                                    {
                                        data: 'date'
                                    },
                                    {
                                        data: 'code_material'
                                    },
                                    {
                                        data: 'quantity'
                                    },
                                    {
                                        data: 'identity_pic'
                                    },
                                    {
                                        data: 'description'
                                    }
                                ],
                                // Konfigurasi lainnya
                            });
                        }
                    } else {
                        // Handle jika success tidak bernilai true
                        toastr.error('Failed to retrieve data.');
                    }
                },
                error: function(xhr, status, error) {
                    // Tampilkan pesan error dengan Toastr
                    toastr.error('Error occurred while processing the request.');
                }
            });
        });
    });
</script>