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
                    <a href="<?= site_url('users/add_machine') ?>" class="btn btn-primary"><i class="fas fa-plus mr-2"></i>Add Data</a>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#upload_excel_machine">
                        <i class="fas fa-file-excel mr-2"></i>Upload Excel
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="upload_excel_machine" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Upload Excel machine</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?= form_open_multipart('users/upload_machine', array('id' => 'form_upload_excel_machine')) ?>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="upload_machine">Excel</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="upload_machine" name="upload_machine">
                                                <label class="custom-file-label" for="upload_machine">Choose
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
                <table id="tbl_machine" class="table table-bordered table-striped nowrap">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAME AREA</th>
                            <th>NAME LINE</th>
                            <th>CODE MACHINE</th>
                            <th>NAME MACHINE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($machine as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value->name_area ?></td>
                                <td><?= $value->name_line ?></td>
                                <td><?= $value->code_machine ?></td>
                                <td><?= $value->name_machine ?></td>
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

<?php foreach ($machine as $value) : ?>
    <div class="modal fade" id="update_machine_<?= $value->id_machine; ?>" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Update <?= $value->code_machine; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('users/update_machine', array('id' => 'form_update_machine_' . $value->id_machine)); ?>
                <div class="card-body">
                    <input type="hidden" class="form-control" id="id_machine<?= $value->id_machine ?>" name="id_machine" value="<?= $value->id_machine ?>" readonly>
                    <div class="form-group">
                        <label>Area</label>
                        <select class="form-control select2" id="area<?= $value->id_machine ?>" name="area" style="width: 100%;">
                            <option selected="selected" value="">- Select Area -</option>
                        </select>
                    </div>
                    <input type="hidden" class="form-control" id="code_area_now<?= $value->id_machine ?>" name="code_area_now" value="<?= $value->code_area ?>" readonly>
                    <div class="form-group">
                        <label for="">Area Now</label>
                        <input type="text" class="form-control" id="area_now<?= $value->id_machine ?>" name="area_now" value="<?= $value->name_area ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Line</label>
                        <select class="form-control select2" id="line<?= $value->id_machine ?>" name="line" style="width: 100%;">
                            <option selected="selected" value="">- Select Line -</option>
                        </select>
                    </div>
                    <input type="hidden" class="form-control" id="code_line_now<?= $value->id_machine ?>" name="code_line_now" value="<?= $value->code_line ?>" readonly required>
                    <div class="form-group">
                        <label for="">Line Now</label>
                        <input type="text" class="form-control" id="line_now<?= $value->id_machine ?>" name="line_now" value="<?= $value->name_line ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="code_machine">Code Machine</label>
                        <input type="text" class="form-control" id="code_machine<?= $value->id_machine ?>" name="code_machine" placeholder="Enter Code Machine" value="<?= $value->code_machine ?>">
                    </div>
                    <div class="form-group">
                        <label for="name_machine">Name Machine</label>
                        <input type="text" class="form-control" id="name_machine<?= $value->id_machine ?>" name="name_machine" placeholder="Enter Name Machine" value="<?= $value->name_machine ?>">
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
        $("#tbl_machine").DataTable({
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
        }).buttons().container().appendTo('#tbl_machine_wrapper .col-md-6:eq(0)');

        //-------------------------------------------------- Update --------------------------------------------------\\
        $('form[id^="form_update_machine_"]').submit(function(e) {
            e.preventDefault(); // Menghentikan pengiriman form standar

            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var formData = form.serialize();
            $.ajax({
                url: url,
                type: method,
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        <?php foreach ($machine as $value) : ?>
            $('#area<?= $value->id_machine ?>').select2({
                theme: 'bootstrap4',
            });
            $.ajax({
                url: "<?php echo base_url('select2/get_area'); ?>",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    // Bersihkan pilihan lama jika ada
                    $('#area<?= $value->id_machine ?>').empty();
                    // Tambahkan opsi default
                    $('#area<?= $value->id_machine ?>').append(
                        '<option selected="selected" value="">- Select Area -</option>');
                    // Loop melalui data area dan tambahkan ke Select2
                    $.each(response.area, function(key, value) {
                        $('#area<?= $value->id_machine ?>').append('<option value="' + value
                            .code_area + '">' + value.name_area + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

            $('#line<?= $value->id_machine ?>').select2({
                theme: 'bootstrap4',
            });
            $('#area<?= $value->id_machine ?>').change(function() {
                var selectedArea = $(this).val();
                var selectedAreaTxt = $(this).find('Option:selected').text();
                $('#code_area_now<?= $value->id_machine ?>').val(selectedArea);
                $('#area_now<?= $value->id_machine ?>').val(selectedAreaTxt);
                $('#code_line_now<?= $value->id_machine ?>').val(null);
                $('#line_now<?= $value->id_machine ?>').val(null);
                $.ajax({
                    url: "<?php echo base_url('select2/get_line_by_area'); ?>",
                    type: "GET",
                    dataType: "json",
                    data: {
                        code_area: selectedArea
                    },
                    success: function(response) {
                        // Bersihkan pilihan lama jika ada
                        $('#line<?= $value->id_machine ?>').empty();
                        // Tambahkan opsi default
                        $('#line<?= $value->id_machine ?>').append(
                            '<option selected="selected" value="">- Select Line -</option>');
                        // Loop melalui data line dan tambahkan ke select
                        $.each(response.lines, function(key, value) {
                            $('#line<?= $value->id_machine ?>').append('<option value="' +
                                value.code_line + '">' + value.name_line + '</option>');
                        });
                        $('#line<?= $value->id_machine ?>').prop('required', true);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $('#line<?= $value->id_machine ?>').change(function(e) {
                e.preventDefault();
                var selectedValLine = $(this).val();
                var selectedTxtLine = $(this).find('Option:selected').text();

                $('#code_line_now<?= $value->id_machine ?>').val(selectedValLine);
                $('#line_now<?= $value->id_machine ?>').val(selectedTxtLine);
            });
        <?php endforeach; ?>
        //-------------------------------------------------- Update --------------------------------------------------\\

        //-------------------------------------------------- Upload Excel --------------------------------------------------\\
        bsCustomFileInput.init();
        $('#form_upload_excel_machine').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: '<?= base_url('users/upload_machine') ?>',
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
                                " data is not uploaded, because the category code already exists";
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
                            window.location.reload();
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

        //-------------------------------------------------- Delete --------------------------------------------------\\
        $(document).on('click', 'button[data-id-machine]', function() {
            var id_machine = $(this).data('id-machine');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this! ",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= site_url('users/delete_machine') ?>',
                        data: {
                            id_machine: id_machine
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