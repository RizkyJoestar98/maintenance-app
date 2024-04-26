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
                        <li class="breadcrumb-item"><a href="<?= site_url('admin/dashboard') ?>">Dashboard</a></li>
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
                    <a href="<?= site_url('admin/add_uom') ?>" class="btn btn-primary"><i class="fas fa-plus mr-2"></i>Add Data</a>
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
                <table id="tbl_uom" class="table table-bordered table-striped nowrap">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>CODE UOM</th>
                            <th>NAME UOM</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($uom as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value->code_uom ?></td>
                                <td><?= $value->name_uom ?></td>
                                <td class="text-center">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#update_uom_<?= $value->id_uom; ?>">
                                        <i class="fas fa-edit mr-2"></i>Update
                                    </button>
                                    <button type="button" class="btn btn-danger" id="delete_uom" data-id-uom="<?= $value->id_uom; ?>" data-code-uom="<?= $value->code_uom; ?>"><i class="fas fa-trash mr-2"></i>Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php foreach ($uom as $value) : ?>
    <div class="modal fade" id="update_uom_<?= $value->id_uom; ?>" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Update <?= $value->code_uom; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('admin/update_uom', array('id' => 'form_update_uom_' . $value->id_uom)); ?>
                <div class="card-body">
                    <input type="hidden" class="form-control" id="id_uom<?= $value->id_uom; ?>" name="id_uom" placeholder="Enter Code Uom" value="<?= $value->id_uom; ?>">
                    <div class="form-group">
                        <label for="code_uom">Code Uom</label>
                        <input type="text" class="form-control" id="code_uom<?= $value->id_uom; ?>" name="code_uom" placeholder="Enter Code Uom" value="<?= $value->code_uom; ?>">
                    </div>
                    <div class="form-group">
                        <label for="name_uom">Name Uom</label>
                        <input type="text" class="form-control" id="name_uom<?= $value->id_uom; ?>" name="name_uom" placeholder="Enter Name Uom" value="<?= $value->name_uom; ?>">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save Change</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    $(document).ready(function() {
        $("#tbl_uom").DataTable({
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
        }).buttons().container().appendTo('#tbl_uom_wrapper .col-md-6:eq(0)');

        <?php foreach ($uom as $value) : ?>
            $('#form_update_uom_<?= $value->id_uom ?>').submit(function(e) {
                e.preventDefault();

                var form = $(this);

                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success(response.message);
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                        toastr.error('An error occurred while processing the request.');
                    }
                });
            });
        <?php endforeach; ?>


        //-------------------------------------------------- Delete --------------------------------------------------\\
        $(document).on('click', 'button[data-id-uom]', function() {
            var id_uom = $(this).data('id-uom');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= site_url('admin/delete_uom') ?>',
                        data: {
                            id_uom: id_uom
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: response.message,
                                    icon: "success"
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Failed!",
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                title: "Error!",
                                text: "An error occurred while processing your request.",
                                icon: "error"
                            });
                            console.error('AJAX Error:', textStatus, errorThrown);
                        }
                    });
                }
            });
        });
        //-------------------------------------------------- Delete --------------------------------------------------\\
    });
</script>