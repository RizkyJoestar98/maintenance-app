<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MTN | Login</title>

    <link rel="icon" type="image/png" href="https://isuzu-astra.com/wp-content/themes/Isuzu/images/favicon.png">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/template/') ?>plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/template/') ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/template/') ?>dist/css/adminlte.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url('assets/template/') ?>plugins/toastr/toastr.min.css">

    <style type="text/css">
    body {
        position: relative;
        background-image: url('http://localhost/maintenance-app/assets/image/background/Background-Isuzu.jpg');
        background-size: cover;
    }

    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.5);
        /* Opacitas putih (RGBA: merah, hijau, biru, alpha) */
    }
    </style>

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img class="m-3" src="<?= base_url('') ?>assets/image/logo/Isuzu.svg.png" alt="isuzu.png" width="200">
            </div>
            <div class="card-body">
                <p class="login-box-msg" style="font-size: 20px;">
                    <b>APPLICATION</b>
                    <br>
                    <b>MAINTENANCE DEPARTMENT</b>
                </p>

                <?= form_open('auth/verify_login', array('id' => 'form-login')); ?>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email"
                        value="<?= set_value('email') ?>">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" id="password"
                        placeholder="Enter Password">
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                    <!-- /.col -->
                </div>
                <?= form_close(); ?>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url('assets/template/') ?>plugins/jquery/jquery.min.js"></script>
    <!-- jquery-validation -->
    <script src="<?= base_url('assets/template/') ?>plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?= base_url('assets/template/') ?>plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/template/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/template/') ?>dist/js/adminlte.min.js"></script>
    <!-- Toastr -->
    <script src="<?= base_url('assets/template/') ?>plugins/toastr/toastr.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#email').focus();

        $.validator.setDefaults({
            submitHandler: function(form) {
                $.ajax({
                    url: $(form).attr('action'),
                    type: $(form).attr('method'),
                    data: $(form).serialize(),
                    dataType: 'JSON',
                    beforeSend: function() {
                        // Menampilkan loading sebelum pengiriman AJAX dimulai
                        $('.loader').show();
                    },
                    success: function(response) {
                        if (response.success) {
                            if (response.id_role == 1) {
                                toastr.success(response.message);
                                setTimeout(function() {
                                    window.location.href =
                                        '<?= site_url('admin/dashboard'); ?>';
                                }, 2000); // Penundaan selama 3000 milidetik (3 detik)
                            } else if (response.id_role == 2) {
                                toastr.success(response.message);
                                setTimeout(function() {
                                    window.location.href =
                                        '<?= site_url('users/dashboard'); ?>';
                                }, 2000); // Penundaan selama 3000 milidetik (3 detik)
                            }
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Tanggapan dari server jika terjadi kesalahan
                        console.log('AJAX Error:', textStatus);
                        console.log('Error Thrown:', errorThrown);
                        console.log('Server Response:', jqXHR
                            .responseText
                        ); // Menampilkan respons kesalahan untuk debugging
                        toastr.error('AJAX Error: ' +
                            textStatus); // Menampilkan pesan kesalahan kepada pengguna
                    },
                    complete: function() {
                        // Menyembunyikan loading setelah AJAX request selesai
                        $('.loader').hide();
                    }
                });


            }
        });
        $('#form-login').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    minlength: 8
                },
            },
            messages: {
                email: {
                    required: "Please enter a email address",
                    email: "Please enter a valid email address",
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 8 characters long"
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
</body>

</html>