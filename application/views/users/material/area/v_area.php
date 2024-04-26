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
                    <a href="<?= site_url('users/add_area') ?>" class="btn btn-primary"><i
                            class="fas fa-plus mr-2"></i>Add Data</a>
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
                <table id="tbl_area" class="table table-bordered table-striped nowrap">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>CODE AREA</th>
                            <th>NAME AREA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($area as $value) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value->code_area; ?></td>
                            <td><?= $value->name_area; ?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>CODE AREA</th>
                            <th>NAME AREA</th>
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
$(function() {
    $("#tbl_area").DataTable({
        "scrollX": true,
        "responsive": true,
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
    }).buttons().container().appendTo('#tbl_area_wrapper .col-md-6:eq(0)');
});
</script>