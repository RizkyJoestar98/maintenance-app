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
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $title_card; ?></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <?= form_open('users/save_change_password', ['id' => 'form-change-password']); ?>
            <div class="card-body">
                <div class="form-group">
                    <label for="old_password">Old Password</label>
                    <input type="password" class="form-control" id="old_password" name="old_password"
                        placeholder="Enter Old Password">
                </div>
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password"
                        placeholder="Enter New Password">
                </div>
                <div class="form-group">
                    <label for="retype_new_password">Retype New Password</label>
                    <input type="password" class="form-control" id="retype_new_password" name="retype_new_password"
                        placeholder="Retype New Password">
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
    $('#old_password').focus();

    $.validator.setDefaults({
        submitHandler: function(form) {
            $.ajax({
                url: $(form).attr('action'),
                type: $(form).attr('method'),
                data: $(form).serialize(),
                dataType: 'JSON',
                success: function(response) {
                    if (response.success == true) {
                        toastr.success(response.message)
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500); // Penundaan selama 3000 milidetik (3 detik)
                    } else {
                        toastr.error(response.message)
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Tanggapan dari server jika terjadi kesalahan
                    console.log('AJAX Error:', textStatus);
                }
            });
        }
    });
    $('#form-change-password').validate({
        rules: {
            old_password: {
                required: true,
            },
            new_password: {
                required: true,
                minlength: 8
            },
            retype_new_password: {
                required: true,
                minlength: 8,
                equalTo: "#new_password"
            },
        },
        messages: {
            old_password: {
                required: "Please enter a old password",
            },
            new_password: {
                required: "Please provide a new password",
                minlength: "Your password must be at least 8 characters long"
            },
            retype_new_password: {
                required: "Please retype a password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Password doesn't match"
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