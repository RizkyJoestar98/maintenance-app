<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><b><?= $title_page; ?></b></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('users/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('users/uom') ?>">Uom</a>
                        </li>
                        <li class="breadcrumb-item active"><?= $bread_crumb; ?></li>

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $title_card; ?></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <?= form_open('users/save_uom', array('id' => 'form-add-uom')) ?>
            <div class="card-body">
                <div class="form-group">
                    <label for="code_uom">Code Uom</label>
                    <input type="text" class="form-control" id="code_uom" name="code_uom" placeholder="Enter Code Uom">
                </div>
                <div class="form-group">
                    <label for="name_uom">Name Uom</label>
                    <input type="text" class="form-control" id="name_uom" name="name_uom" placeholder="Enter Name Uom">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- jquery-validation -->
<script src="<?= base_url('assets/template/') ?>plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?= base_url('assets/template/') ?>plugins/jquery-validation/additional-methods.min.js"></script>
<script>
    $(document).ready(function() {
        $('#code_uom').focus();

        $.validator.setDefaults({
            submitHandler: function(form) {
                $.ajax({
                    url: $(form).attr('action'),
                    type: $(form).attr('method'),
                    data: $(form).serialize(),
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success(response.message);
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000); // Penundaan selama 2000 milidetik (2 detik)
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Tanggapan dari server jika terjadi kesalahan
                        console.log('AJAX Error:', textStatus);
                    },
                });

            }
        });
        $('#form-add-uom').validate({
            rules: {
                code_uom: {
                    required: true,
                    remote: {
                        url: "<?= site_url('users/check_code_uom') ?>",
                        type: "POST",
                        data: {
                            'code_uom': function() {
                                return $("#code_uom").val();
                            }
                        }
                    }
                },
                name_uom: {
                    required: true,
                },
            },
            messages: {
                code_uom: {
                    required: "Please enter a code uom",
                    remote: "Code Uom already exist"
                },
                name_uom: {
                    required: "Please enter a name Uom",
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>