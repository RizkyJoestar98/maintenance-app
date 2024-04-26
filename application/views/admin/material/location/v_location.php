<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url('assets/template/') ?>plugins/toastr/toastr.min.css">
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
                    <a href="<?= site_url('admin/add_location') ?>" class="btn btn-primary"><i class="fas fa-plus mr-2"></i>Add Data</a>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#upload_excel_location">
                        <i class="fas fa-file-excel mr-2"></i>Upload Excel
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="upload_excel_location" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Upload Excel</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?= form_open_multipart('admin/upload_location', array('id' => 'form_upload_excel_location')) ?>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="upload_location">Excel</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="upload_location" name="upload_location">
                                                <label class="custom-file-label" for="upload_location">Choose
                                                    file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="progress" class="progress" style="display: none;">
                                        <div id="progress_bar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                            0%
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
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
                <table id="tbl_location" class="table table-bordered table-striped nowrap">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAME LOCATION</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($location as $value) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $value->name_location ?></td>
                                <td class="text-center">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#updatelocation<?= $value->id_location; ?>">
                                        <i class="fas fa-edit mr-2"></i>Update
                                    </button>
                                    <button type="button" class="btn btn-danger" id="delete_location" data-id-location="<?= $value->id_location; ?>" data-code-location="<?= $value->code_location; ?>"><i class="fas fa-trash mr-2"></i>Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NO</th>
                            <th>NAME LOCATION</th>
                            <th>ACTION</th>
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

<?php foreach ($location as $value) : ?>
    <div class="modal fade" id="updatelocation<?= $value->id_location; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Update <?= $value->code_location; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('admin/update_location', array('id' => 'form_update_location_' . $value->id_location)); ?>
                <div class="card-body">
                    <div class="form-group">
                        <input type="hidden" name="id_location" class="form-control" id="id_location<?= $value->id_location; ?>" value="<?= $value->id_location; ?>" readonly>
                    </div>
                    <label for="code_location">Code location</label>
                    <div class="form-group">
                        <input type="text" name="code_location" class="form-control" id="code_location<?= $value->id_location; ?>" value="<?= $value->code_location; ?>" readonly>
                    </div>
                    <label for="name_location">Name location</label>
                    <div class="form-group">
                        <input type="text" name="name_location" class="form-control" id="name_location<?= $value->id_location; ?>" value="<?= $value->name_location; ?>">
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

<!-- jquery-validation -->
<script src="<?= base_url('assets/template/') ?>plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?= base_url('assets/template/') ?>plugins/jquery-validation/additional-methods.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?= base_url('assets/template/') ?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
    $(document).ready(function() {
        $("#tbl_location").DataTable({
            "scrollX": true,
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            select: {
                selected: false,
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
        }).buttons().container().appendTo('#tbl_location_wrapper .col-md-6:eq(0)');

        //-------------------------------------------------- Update --------------------------------------------------\\
        <?php foreach ($location as $value) { ?>
            $('#form_update_location_<?= $value->id_location ?>').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    type: form.attr('method'), // Get method from form attribute
                    url: form.attr('action'), // Get URL from form attribute
                    data: form.serialize(), // Serialize form data
                    dataType: "json", // Expect JSON response
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success(response.message);
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000); // Delay for 2 seconds
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown); // Log AJAX error
                        toastr.error(
                            'An error occurred while processing the request.'
                        ); // Show generic error message
                    }
                });
            });
        <?php } ?>
        //-------------------------------------------------- Update --------------------------------------------------\\


        //-------------------------------------------------- Delete --------------------------------------------------\\
        $(document).on('click', 'button[data-id-location]', function() {
            var id_location = $(this).data('id-location');

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
                        url: '<?= site_url('admin/delete_location') ?>',
                        data: {
                            id_location: id_location
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


        //-------------------------------------------------- Upload Excel --------------------------------------------------\\
        bsCustomFileInput.init();
        $('#form_upload_excel_location').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: '<?= base_url('admin/upload_location') ?>',
                data: formData,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total * 100;
                            $('#progress').show();
                            $('#progress_bar').width(percentComplete + '%');
                            $('#progress_bar').html(percentComplete.toFixed(2) + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    var successMessage = '';
                    var errorMessage = '';

                    if (response.success == true) {
                        successMessage = response.message.success + " out of " +
                            response.message.total + " data were successfully uploaded";
                        if (response.message.duplicate_count > 0) {
                            errorMessage = response.message.duplicate_count +
                                " data is not uploaded, because the location code already exists";
                        }
                    } else {
                        errorMessage = response.message;
                    }

                    Swal.fire({
                        title: successMessage,
                        text: errorMessage,
                        icon: response.success ? "success" : "error"
                    }).then(() => {
                        if (response.success) {
                            window.location.href = "<?= site_url('admin/location') ?>";
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle error response
                    console.error(textStatus, errorThrown);
                },
                complete: function() {
                    // Hide progress bar when upload complete
                    $('#progress').fadeOut(5000);
                }
            });
        });
        //-------------------------------------------------- Upload Excel --------------------------------------------------\\

    });
</script>