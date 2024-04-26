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
                        <li class="breadcrumb-item"><a href="<?= site_url('users/line') ?>">Line</a>
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
            <?= form_open('users/save_line', array('id' => 'form_add_line')) ?>
            <div class="card-body">
                <div class="form-group">
                    <label>Area</label>
                    <select class="form-control select2" id="area" name="area" style="width: 100%;">
                        <option selected="selected" value=''>- Select Area -</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="code_line">Code Line</label>
                    <input type="text" class="form-control" id="code_line" name="code_line" placeholder="Enter Code Line">
                </div>
                <div class="form-group">
                    <label for="name_line">Name Line</label>
                    <input type="text" class="form-control" id="name_line" name="name_line" placeholder="Enter Name Line">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-danger" id="reset_btn">Reset</button>
            </div>
            <?= form_close() ?>
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
        $('#code_line').focus();

        $('#reset_btn').click(function() {
            $('#code_line').focus();
            $('#area').append(
                '<option selected="selected" value="">- Select Area -</option>');
        });

        // Panggil endpoint untuk mendapatkan daftar area
        $.ajax({
            url: "<?php echo base_url('select2/get_area'); ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                // Bersihkan pilihan lama jika ada
                $('#area').empty();
                // Tambahkan opsi default
                $('#area').append(
                    '<option selected="selected" value="">- Select Area -</option>');
                // Loop melalui data area dan tambahkan ke Select2
                $.each(response.area, function(key, value) {
                    $('#area').append('<option value="' + value.code_area + '">' +
                        value.name_area + '</option>');
                });
                // Inisialisasi kembali Select2 setelah memperbarui opsi
                $('.select2').select2({
                    theme: 'bootstrap4',
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        $('#area').change(function(e) {
            e.preventDefault();
            var selectedText = $(this).children("option:selected").text();
            $('#area_now').val(selectedText);
            $(this).valid();
        });

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
                            }, 1500); // Penundaan selama 2000 milidetik (2 detik)
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
        $('#form_add_line').validate({
            rules: {
                area: {
                    required: true,
                },
                code_line: {
                    required: true,
                    remote: {
                        url: "<?= site_url('users/check_code_line') ?>",
                        type: "POST",
                        data: {
                            'code_line': function() {
                                return $("#code_line").val();
                            }
                        }
                    }
                },
                name_line: {
                    required: true,
                },
            },
            messages: {
                area: {
                    required: "Please select area",
                },
                code_line: {
                    required: "Please enter a code line",
                    remote: "Code category already exist"
                },
                name_line: {
                    required: "Please enter a name line",
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