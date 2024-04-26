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
                            <li class="breadcrumb-item"><a href="<?= site_url('users/goods_receive') ?>">Goods Issue</a>
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
                <?= form_open('users/save_good_receive', ['id' => 'form-add-goods-receive']) ?>
                <div class="card-body">
                    <div class="form-group">
                        <label for="id_transaction">GR Code</label>
                        <input type="text" class="form-control" value="<?= $id_transaction; ?>" id="id_transaction"
                            name="id_transaction" placeholder="Goods Receive Code" readonly>
                    </div>
                    <!-- <div class="form-group">
                        <label for="scan_barcode">Scan Barcode</label>
                        <input type="text" class="form-control" id="scan_barcode" name="scan_barcode">
                    </div> -->
                    <div class="form-group">
                        <label for="code_material">Material Code</label>
                        <select class="form-control select2" id="code_material" name="code_material"
                            style="width: 100%;">
                            <option selected="selected" value="">- Select Material -</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_time">Date And Time</label>
                        <input type="date" class="form-control" id="date" name="date">
                        <input type="hidden" id="datetime" name="datetime">
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity GR</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="0" min="0">
                    </div>
                    <div class="form-group">
                        <label for="identity_pic">Identity PIC</label>
                        <input type="text" class="form-control" id="identity_pic" name="identity_pic"
                            placeholder="Enter Identity PIC">
                    </div>
                    <div class="form-group">
                        <label for="description">Alasan Pengambilan</label>
                        <input type="text" class="form-control" id="description" name="description"
                            placeholder="Enter Lasan Pengambilan">
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
    $('#scan_barcode').focus();
    $('#code_material').select2({
        theme: 'bootstrap4',
    });

    $('#code_material').on('change', function() {
        // Fokus langsung ke input Quantity GR setelah memilih material code
        var selectedValue = $(this).val();
        var selectedText = $(this).find('Option:selected').text();
        $(this).valid();
        $('#identity_pic').focus();
    });

    // Fungsi untuk mendapatkan waktu saat ini dalam format yang sesuai
    function getCurrentTime() {
        var now = new Date();
        var hours = ('0' + now.getHours()).slice(-2);
        var minutes = ('0' + now.getMinutes()).slice(-2);
        var seconds = ('0' + now.getSeconds()).slice(-2);
        var time = hours + ':' + minutes + ':' + seconds;
        return time;
    }

    // Tambahkan event listener untuk input tanggal
    document.getElementById('date').addEventListener('change', function() {
        // Ambil tanggal yang dipilih oleh pengguna
        var selectedDate = this.value;

        // Jika tanggal dipilih, tambahkan waktu saat ini
        if (selectedDate) {
            var currentTime = getCurrentTime();
            var datetime = selectedDate + ' ' + currentTime;
            // Setel nilai input datetime
            document.getElementById('datetime').value = datetime;
        }
    });

    $.ajax({
        url: "<?php echo base_url('select2/get_material'); ?>",
        type: "GET",
        dataType: "json",
        success: function(response) {
            // Bersihkan pilihan lama jika ada
            $('#code_material').empty();
            // Tambahkan opsi default
            $('#code_material').append(
                '<option selected="selected" value="">- Select Material -</option>');
            // Loop melalui data material dan tambahkan ke Select2
            $.each(response.material, function(key, value) {
                $('#code_material').append('<option value="' + value.code_material + '">' +
                    value.code_material + '&nbsp;&nbsp;' + '-' + '&nbsp;&nbsp;' + value
                    .specification_material +
                    '</option>');
            });

        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    var timeout = null; // Variabel untuk menahan timer

    // $('#scan_barcode').on('input', function() {
    //     clearTimeout(timeout); // Hapus timer sebelumnya (jika ada)

    //     // Mulai timer baru untuk menunggu 500 milidetik (0.5 detik)
    //     timeout = setTimeout(function() {
    //         var barcode = $('#scan_barcode').val();
    //         if (barcode.trim() !== '') { // Cek apakah input tidak kosong
    //             $.ajax({
    //                 type: "POST",
    //                 url: "<?= site_url('cek_scan_barcode'); ?>",
    //                 data: {
    //                     barcode: barcode
    //                 },
    //                 dataType: "JSON",
    //                 success: function(response) {
    //                     if (response.success) {
    //                         Swal.fire({
    //                             title: "Check Barcode",
    //                             html: '<b>' + response.message + '</b>',
    //                             icon: "success",
    //                             timer: 1000
    //                         });
    //                     } else {
    //                         Swal.fire({
    //                             title: "Check Barcode",
    //                             html: '<b>' + response.message + '</b>',
    //                             icon: "error",
    //                             timer: 1000
    //                         });
    //                     }
    //                 }


    //             });
    //         }
    //     }, 500); // Timer diatur ke 500 milidetik (0.5 detik)
    // });





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
    $('#form-add-goods-receive').validate({
        rules: {
            date: {
                required: true,
            },
            code_material: {
                required: true,
            },
            quantity: {
                required: true,
                min: 1
            },
            identity_pic: {
                required: true,
            },
            description: {
                required: true,
            },
        },
        messages: {
            date: {
                required: "Please select date",
            },
            code_material: {
                required: "Please select a material",
            },
            quantity: {
                required: "Please enter a quantity",
                min: 'Please enter a quantity'
            },
            identity_pic: {
                required: "Please enter a identity PIC",
            },
            description: {
                required: "Please enter a description",
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