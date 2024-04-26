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
                        <li class="breadcrumb-item"><a href="<?= site_url('users/location') ?>">Location</a>
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
            <?= form_open('users/save_location', array('id' => 'form-add-location')) ?>
            <div class="card-body">
                <div class="form-group">
                    <label for="code_location">Code Location</label>
                    <input type="text" class="form-control" id="code_location" name="code_location" placeholder="Enter Code location">
                </div>
                <div class="form-group">
                    <label for="name_location">Name Location</label>
                    <input type="text" class="form-control" id="name_location" name="name_location" placeholder="Enter Name location">
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
        $('#code_location').focus();

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
                            }, 1000); // Penundaan selama 2000 milidetik (2 detik)
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
        $('#form-add-location').validate({
            rules: {
                code_location: {
                    required: true,
                    remote: {
                        url: "<?= site_url('users/check_code_location') ?>",
                        type: "POST",
                        data: {
                            'code_location': function() {
                                return $("#code_location").val();
                            }
                        }
                    }
                },
                name_location: {
                    required: true,
                },
            },
            messages: {
                code_location: {
                    required: "Please enter a code location",
                    remote: "Code location already exist"
                },
                name_location: {
                    required: "Please enter a name location",
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