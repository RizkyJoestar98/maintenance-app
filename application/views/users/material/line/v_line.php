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
                    <a href="<?= site_url('users/add_line') ?>" class="btn btn-primary"><i class="fas fa-plus mr-2"></i>Add Data</a>
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
                <table id="tbl_line" class="table table-bordered table-striped nowrap">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAME AREA</th>
                            <th>CODE LINE</th>
                            <th>NAME LINE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($line as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value->name_area; ?></td>
                                <td><?= $value->code_line; ?></td>
                                <td><?= $value->name_line; ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>NAME AREA</th>
                            <th>CODE LINE</th>
                            <th>NAME LINE</th>
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
<?php foreach ($line as $value) : ?>
    <div class="modal fade" id="update_line_<?= $value->id_line; ?>" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Update <?= $value->code_line; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('admin/update_line', array('id' => 'form_update_line_' . $value->id_line)); ?>
                <div class="card-body">
                    <input type="hidden" class="form-control" id="id_line<?= $value->id_line; ?>" name="id_line" placeholder="Enter Code Line" value="<?= $value->id_line; ?>">
                    <input type="hidden" class="form-control code_area" id="code_area<?= $value->id_line; ?>" name="code_area" placeholder="Enter Code Line" value="<?= $value->code_area; ?>" readonly>
                    <div class="form-group">
                        <label>Area</label>
                        <select class="form-control select2" id="area_<?= $value->id_line; ?>" name="area" style="width: 100%;">
                            <option selected="selected" value=''>- Select Area -</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="area_now<?= $value->id_line; ?>">Area Now</label>
                        <input type="text" class="form-control area_now" id="area_now<?= $value->id_line; ?>" name="area_now" placeholder="Enter Code Line" value="<?= $value->name_area; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="code_line<?= $value->id_line; ?>">Code Line</label>
                        <input type="text" class="form-control" id="code_line<?= $value->id_line; ?>" name="code_line" placeholder="Enter Code Line" value="<?= $value->code_line; ?>">
                    </div>
                    <div class="form-group">
                        <label for="name_line<?= $value->id_line; ?>">Name Line</label>
                        <input type="text" class="form-control" id="name_line<?= $value->id_line; ?>" value="<?= $value->name_line ?>" name="name_line" placeholder="Enter Name Line">
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

        $("#tbl_line").DataTable({
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
        }).buttons().container().appendTo('#tbl_line_wrapper .col-md-6:eq(0)');

        //-------------------------------------------------- Update --------------------------------------------------\\

        $('.select2').select2({
            theme: 'bootstrap4'
        });

        <?php foreach ($line as $value) { ?>
            $.ajax({
                url: "<?php echo base_url('select2/get_area'); ?>",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    // Bersihkan pilihan lama jika ada
                    $('#area_<?= $value->id_line; ?>').empty();
                    // Tambahkan opsi default
                    $('#area_<?= $value->id_line; ?>').append(
                        '<option selected="selected" value="">- Select Area -</option>');
                    // Loop melalui data area dan tambahkan ke Select2
                    $.each(response.area, function(key, value) {
                        $('#area_<?= $value->id_line; ?>').append('<option value="' + value
                            .code_area + '">' + value.name_area + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

            // Tambahkan event change untuk setiap select2
            $('#area_<?= $value->id_line; ?>').on('change', function(e) {
                e.preventDefault();
                var selectedText = $(this).children("option:selected").text();
                var selectedVal = $(this).children("option:selected").val();
                $('#area_now<?= $value->id_line ?>').val(selectedText);
                $('#code_area<?= $value->id_line ?>').val(selectedVal);
            });

            $('#form_update_line_<?= $value->id_line ?>').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success(response.message);
                            setTimeout(function() {
                                window.location.href = '<?= site_url('admin/line'); ?>';
                            }, 2000);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                        toastr.error(
                            'An error occurred while processing the request.'
                        );
                    }
                });
            });
        <?php } ?>


        //-------------------------------------------------- Update --------------------------------------------------\\


        //-------------------------------------------------- Delete --------------------------------------------------\\
        $(document).on('click', 'button[data-id-line]', function() {
            var id_line = $(this).data('id-line');

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
                        url: '<?= site_url('admin/delete_line') ?>',
                        data: {
                            id_line: id_line
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: response.message,
                                    icon: "success"
                                }).then(() => {
                                    // Redirect to desired page after successful deletion
                                    window.location.href =
                                        "<?= site_url('admin/line') ?>";
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