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
                    <a href="<?= site_url('admin/add_material_list') ?>" class="btn btn-primary"><i
                            class="fas fa-plus mr-2"></i>Add Data</a>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#upload_excel_material">
                        <i class="fas fa-file-excel mr-2"></i>Upload Excel
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="upload_excel_material" data-backdrop="static" data-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Upload Excel</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?= form_open_multipart('admin/upload_material', array('id' => 'form_upload_excel_material')) ?>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="upload_material">Excel</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="upload_material"
                                                    name="upload_material">
                                                <label class="custom-file-label" for="upload_material">Choose
                                                    file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="progress" class="progress" style="display: none;">
                                        <div id="progress_bar" class="progress-bar" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
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
                <table id="tbl_material_list" class="table table-bordered table-striped nowrap">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>MATERIAL CODE</th>
                            <th>BARCODE</th>
                            <th>CATEGORY</th>
                            <th>SPESIFICATION</th>
                            <th>QTY STOCK</th>
                            <th>UOM</th>
                            <th>LOCATION</th>
                            <th class="text-center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($material as $value) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value->code_material ?></td>
                            <td><?php $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                                    echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($value->code_material, $generator::TYPE_CODE_128)) . '">'; ?>
                            </td>
                            <td><?= $value->name_category ?></td>
                            <td><?= $value->specification_material ?></td>
                            <td><?= $value->qty_stock ?></td>
                            <td><?= $value->uom ?></td>
                            <td><?= $value->location ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-info" data-toggle="modal"
                                    data-target="#update_material_<?= $value->code_material; ?>">
                                    <i class="fas fa-edit mr-2"></i>Update
                                </button>
                                <button type="button" class="btn btn-danger" id="delete_material"
                                    data-id-material="<?= $value->id_material; ?>"
                                    data-code-material="<?= $value->code_material; ?>"><i
                                        class="fas fa-trash mr-2"></i>Delete</button>
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


<?php foreach ($material as $value) : ?>
<div class="modal fade" id="update_material_<?= $value->code_material; ?>" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Update <?= $value->code_material; ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/update_material', array('id' => 'form_update_material_' . $value->code_material)); ?>
            <div class="card-body">
                <div class="form-group">
                    <label for="code_material">Material Code</label>
                    <input type="text" class="form-control" value="<?= $value->code_material ?>" id="code_material"
                        name="code_material" placeholder="Material Code" readonly>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <input type="text" class="form-control" value="<?= $value->name_category ?>"
                        id="name_category<?= $value->code_material ?>" name="name_category" placeholder="Material Code"
                        readonly>
                    <input type="hidden" class="form-control" value="<?= $value->code_category ?>"
                        id="code_category<?= $value->code_material ?>" name="code_category" placeholder="Material Code"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="part_name">Part Name</label>
                    <input type="text" class="form-control" value="<?= $value->part_name ?>" id="part_name"
                        name="part_name" placeholder="Enter Part Name">
                </div>
                <div class="form-group">
                    <label for="part_type">Model / Part Type</label>
                    <input type="text" class="form-control" value="<?= $value->part_type ?>" id="part_type"
                        name="part_type" placeholder="Enter Part Name">
                </div>
                <div class="form-group">
                    <label for="part_number_maker">Part Number Maker</label>
                    <input type="text" class="form-control" value="<?= $value->part_number_maker ?>"
                        id="part_number_maker" name="part_number_maker" placeholder="Enter Part Name">
                </div>
                <div class="form-group">
                    <label for="part_code_machine">Part Code Machine</label>
                    <input type="text" class="form-control" value="<?= $value->part_code_machine ?>"
                        id="part_code_machine" name="part_code_machine" placeholder="Enter Part Name">
                </div>
                <div class="form-group">
                    <label for="part_drawing">Part Drawing</label>
                    <input type="text" class="form-control" value="<?= $value->part_drawing ?>" id="part_drawing"
                        name="part_drawing" placeholder="Enter Part Name">
                </div>
                <div class="form-group">
                    <label for="maker">Maker</label>
                    <input type="text" class="form-control" value="<?= $value->maker ?>" id="maker" name="maker"
                        placeholder="Enter Part Name">
                </div>
                <div class="form-group">
                    <label for="additional_description">Additional Description</label>
                    <input type="text" class="form-control" value="<?= $value->additional_description ?>"
                        id="additional_description" name="additional_description" placeholder="Enter Part Name">
                </div>
                <div class="form-group">
                    <label>Area</label>
                    <select class="form-control select2" id="area<?= $value->code_material ?>" name="area"
                        style="width: 100%;">
                        <option selected="selected" value="">- Select Area -</option>
                    </select>
                    <input type="text" class="form-control" value="<?= $value->name_area ?>"
                        id="name_area<?= $value->code_material ?>" name="name_area" placeholder="Name Area" readonly>
                    <input type="hidden" class="form-control" value="<?= $value->code_area ?>"
                        id="code_area<?= $value->code_material ?>" name="code_area" placeholder="Material Code"
                        readonly>
                </div>
                <div class="form-group">
                    <label>Line</label>
                    <select class="form-control select2" id="line<?= $value->code_material ?>" name="line"
                        style="width: 100%;">
                        <option selected="selected" value="">- Select Line -</option>
                    </select>
                    <input type="text" class="form-control" value="<?= $value->name_line ?>"
                        id="name_line<?= $value->code_material ?>" name="name_line" placeholder="Name Line" readonly>
                    <input type="hidden" class="form-control" value="<?= $value->code_line ?>"
                        id="code_line<?= $value->code_material ?>" name="code_line" placeholder="Code Line" readonly>
                </div>
                <div class="form-group">
                    <label>Machine</label>
                    <select class="select2" id="machine<?= $value->code_material ?>" name="machine[]"
                        multiple="multiple" data-placeholder="Select Machine" style="width: 100%;">
                    </select>
                    <input type="text" class="form-control" value="<?= $value->machine ?>"
                        id="name_machine<?= $value->code_material ?>" name="name_machine" placeholder="Name Machine"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="life_time_part">Life Time Part</label>
                    <input type="text" class="form-control" id="life_time_part<?= $value->code_material ?>"
                        name="life_time_part" placeholder="Life Time Part" value="<?= $value->life_time_part ?>">
                </div>
                <div class="form-group">
                    <label for="quantity_on_machine">Quantity On Machine</label>
                    <input type="number" class="form-control" id="quantity_on_machine<?= $value->code_material ?>"
                        name="quantity_on_machine" placeholder="Enter Quantity On Machine"
                        value="<?= $value->qty_on_machine ?>">
                </div>
                <div class="form-group">
                    <label for="quantity_stock">Quantity Stock</label>
                    <input type="number" class="form-control" id="quantity_stock<?= $value->code_material ?>"
                        name="quantity_stock" placeholder="Enter Quantity Stock" value="<?= $value->qty_stock ?>">
                </div>
                <div class="form-group">
                    <label>Uom</label>
                    <select class="form-control select2" id="uom<?= $value->code_material ?>" name="uom"
                        style="width: 100%;">
                        <option selected="selected" value="">- Select Uom -</option>
                    </select>
                    <input type="text" class="form-control" id="code_uom<?= $value->code_material ?>" name="code_uom"
                        placeholder="Name Uom" value="<?= $value->uom ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <select class="form-control select2" id="location<?= $value->code_material ?>" name="location"
                        style="width: 100%;">
                        <option selected="selected" value="">- Select Location -</option>
                        <!-- <?php foreach ($location as $loc) : ?>
                        <option value="<?= $loc->name_location ?>"><?= $loc->name_location ?></option>
                        <?php endforeach; ?> -->
                    </select>
                    <input type="text" class="form-control" id="code_location<?= $value->code_material ?>"
                        name="code_location" placeholder="Name Location" value="<?= $value->location ?>" readonly>
                </div>

            </div>
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

<script src="<?= base_url('assets/template/') ?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
$(document).ready(function() {
    $("#tbl_material_list").DataTable({
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
                text: 'EXCEL',
                title: '',
                exportOptions: {
                    stripHtml: false,
                    columns: [0, 1, 2, 3, 4, 5, 6, 7], // Indeks kolom yang ingin dicetak
                },
                customizeData: function(excelData) {
                    // Menambahkan bintang di depan dan di belakang setiap nilai di kolom Barcode
                    for (var i = 0; i < excelData.body.length; i++) {
                        // Kolom Barcode berada pada indeks 2 (diasumsikan indeks kolom Barcode adalah 2)
                        // Kolom "MATERIAL CODE" berada pada indeks 1 (diasumsikan indeks kolom "MATERIAL CODE" adalah 1)
                        excelData.body[i][2] = '*' + excelData.body[i][1] +
                            '*'; // Menambahkan bintang di depan dan di belakang
                    }
                }
            },
            {
                text: '<i class="fas fa-print mr-2"></i> PRINT',
                className: 'btn-info btn-sm',
                action: function(e, dt, node, config) {
                    $('.swalDefaultWarning').click(function() {
                        Toast.fire({
                            icon: 'warning',
                            title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                        })
                    });
                    // Mengambil data terpilih dari tabel
                    var selectedRows = dt.rows({
                        selected: true
                    }).data();

                    // Mengumpulkan semua nilai material_code dari setiap baris yang dipilih
                    var selectedMaterialCodes = [];

                    selectedRows.each(function(row) {
                        selectedMaterialCodes.push(row[1]);
                    });

                    if (selectedMaterialCodes.length === 0) {
                        toastr.info(
                            'Tidak Ada Data Yang Dipilih'
                        )
                    }

                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('admin/posttopdf') ?>",
                        data: {
                            material_codes: selectedMaterialCodes
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log(
                                response); // Data respons dari server
                            if (response.success == true) {
                                var pdfUrl =
                                    '<?= site_url('admin/print_label_pdf/') ?>?' +
                                    $.param({
                                        material_code: response.data
                                    }); // Menggunakan $.param untuk mengkodekan nilai parameter
                                window.open(pdfUrl, '_blank');
                            } else {
                                console.log(response
                                    .message); // Pesan kesalahan jika ada
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr
                                .responseText
                            ); // Tangani kesalahan jika terjadi
                        }
                    });
                }
            },
            {
                text: '<i class="fas fa-file-pdf mr-2"> </i> PDF',
                className: 'btn-danger btn-sm',
                action: function(e, dt, node, config) {
                    $('.swalDefaultWarning').click(function() {
                        Toast.fire({
                            icon: 'warning',
                            title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                        })
                    });
                    // Mengambil data terpilih dari tabel
                    var selectedRows = dt.rows({
                        selected: true
                    }).data();

                    // Mengumpulkan semua nilai material_code dari setiap baris yang dipilih
                    var selectedMaterialCodes = [];

                    selectedRows.each(function(row) {
                        selectedMaterialCodes.push(row[1]);
                    });

                    if (selectedMaterialCodes.length === 0) {
                        toastr.info(
                            'Tidak Ada Data Yang Dipilih'
                        )
                    }

                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('admin/posttopdf') ?>",
                        data: {
                            material_codes: selectedMaterialCodes
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log(
                                response); // Data respons dari server
                            if (response.success == true) {
                                var pdfUrl =
                                    '<?= site_url('admin/material_list_pdf/') ?>?' +
                                    $.param({
                                        material_code: response.data
                                    }); // Menggunakan $.param untuk mengkodekan nilai parameter
                                window.open(pdfUrl, '_blank');
                            } else {
                                console.log(response
                                    .message); // Pesan kesalahan jika ada
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr
                                .responseText
                            ); // Tangani kesalahan jika terjadi
                        }
                    });
                }
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
    }).buttons().container().appendTo('#tbl_material_list_wrapper .col-md-6:eq(0)');


    bsCustomFileInput.init();

    $('#form_upload_excel_material').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '<?= base_url('admin/upload_material') ?>',
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



    <?php foreach ($material as $value) : ?>

    $.validator.setDefaults({
        submitHandler: function(form) {
            $.ajax({
                url: $(form).attr('action'),
                type: $(form).attr('method'),
                data: $(form).serialize(), // Serialize data formulir
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

    $('#name_area').change(function(e) {
        e.preventDefault();
        $(this).valid();
    });
    $('#name_line').change(function(e) {
        e.preventDefault();
        $(this).valid();
    });
    $('#name_machine').change(function(e) {
        e.preventDefault();
        $(this).valid();
    });
    $('#code_uom').change(function(e) {
        e.preventDefault();
        $(this).valid();
    });
    $('#code_location').change(function(e) {
        e.preventDefault();
        $(this).valid();
    });

    $('#form_update_material_<?= $value->code_material ?>').validate({
        rules: {
            category: {
                required: true,
            },
            part_name: {
                required: true,
            },
            part_type: {
                required: false,
            },
            part_number_maker: {
                required: false,
            },
            part_code_machine: {
                required: false,
            },
            part_drawing: {
                required: false,
            },
            maker: {
                required: false,
            },
            name_area: {
                required: false,
            },
            name_line: {
                required: false,
            },
            name_machine: {
                required: true,
            },
            life_time_part: {
                required: true,
            },
            quantity_on_machine: {
                required: true,
            },
            quantity_stock: {
                required: true,
            },
            code_uom: {
                required: true,
            },
            code_location: {
                required: true,
            },
        },
        messages: {
            category: {
                required: "Please select a category",
            },
            part_name: {
                required: "Please enter a part name",
            },
            part_type: {
                required: "Please enter a part type",
            },
            part_number_maker: {
                required: "Please enter a part number maker",
            },
            part_code_machine: {
                required: "Please enter a part code machine",
            },
            part_drawing: {
                required: "Please enter a part drawing",
            },
            maker: {
                required: "Please enter a maker",
            },
            name_area: {
                required: "Please select area",
            },
            name_line: {
                required: "Please select line",
            },
            name_machine: {
                required: "Please select machine",
            },
            life_time_part: {
                required: "Please enter a life time part",
            },
            quantity_on_machine: {
                required: "Please enter a quantity on machine",
            },
            quantity_stock: {
                required: "Please enter a quantity stock",
            },
            code_uom: {
                required: "Please select a uom",
            },
            code_location: {
                required: "Please select a location",
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

    $('#area<?= $value->code_material ?>').select2({
        theme: 'bootstrap4'
    });
    // Inisialisasi atau perbarui Select2 setelah perubahan area
    $('#line<?= $value->code_material ?>').select2({
        theme: 'bootstrap4'
    });
    $('#machine<?= $value->code_material ?>').select2({
        theme: 'bootstrap4'
    });

    $('#uom<?= $value->code_material ?>').select2({
        theme: 'bootstrap4',
    });

    $('#location<?= $value->code_material ?>').select2({
        theme: 'bootstrap4',
    });




    $.ajax({
        url: "<?php echo base_url('select2/get_area'); ?>",
        type: "GET",
        dataType: "json",
        success: function(response) {
            // Bersihkan pilihan lama jika ada
            $('#area<?= $value->code_material ?>').empty();
            // Tambahkan opsi default
            $('#area<?= $value->code_material ?>').append(
                '<option selected="selected" value="">- Select area -</option>');
            // Loop melalui data area dan tambahkan ke Select2
            $.each(response.area, function(key, value) {
                $('#area<?= $value->code_material ?>').append('<option value="' + value
                    .code_area + '">' +
                    value.name_area + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });


    // Validasi kembali formulir setelah memilih nilai dari select option
    $('#form_update_material_<?= $value->code_material ?>').valid();

    $('#area<?= $value->code_material ?>').change(function(e) {
        e.preventDefault();
        var code_area = $(this).val();
        var name_area = $(this).find('option:selected').text();

        if (name_area == null || code_area === '') {
            $('#name_area<?= $value->code_material ?>').val('').rules('add', 'required');
            $('#code_area<?= $value->code_material ?>').val('');
        } else {
            $('#name_area<?= $value->code_material ?>').val(name_area);
            $('#code_area<?= $value->code_material ?>').val(code_area);
            // Hapus aturan validasi 'required' saat memilih nilai dari select option
            $('#name_area<?= $value->code_material ?>').rules('remove', 'required');
            $('#code_area<?= $value->code_material ?>');
            // Hapus pesan 'required'
            $('#name_area<?= $value->code_material ?>').siblings('.invalid-feedback').remove();
            $('#code_area<?= $value->code_material ?>');
            // Hilangkan kelas 'is-invalid'
            $('#name_area<?= $value->code_material ?>').removeClass('is-invalid');
            $('#code_area<?= $value->code_material ?>');
        }

        // Validasi kembali formulir setelah memilih nilai dari select option
        $('#form_update_material_<?= $value->code_material ?>').valid();

        $.ajax({
            url: "<?php echo base_url('select2/get_line_by_area'); ?>",
            type: "GET",
            dataType: "json",
            data: {
                code_area: code_area
            }, // Kirim data area yang dipilih ke server
            success: function(response) {
                // Bersihkan pilihan lama jika ada
                $('#line<?= $value->code_material ?>').empty();
                // Tambahkan opsi default
                $('#line<?= $value->code_material ?>').append(
                    '<option selected="selected" value="">- Select Line -</option>');
                // Loop melalui data line dan tambahkan ke select
                $.each(response.lines, function(key, value) {
                    $('#line<?= $value->code_material ?>').append(
                        '<option value="' + value.code_line + '">' + value
                        .name_line + '</option>');
                });

                // Tutup dropdown Select2 setelah pemilihan
                $('#line<?= $value->code_material ?>').select2('close');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    $('#line<?= $value->code_material ?>').change(function(e) {
        e.preventDefault();
        var code_line = $(this).val();
        var name_line = $(this).find('option:selected').text();

        if (name_line == null || code_line === '') {
            $('#name_line<?= $value->code_material ?>').val('').rules('add', 'required');
            $('#code_line<?= $value->code_material ?>').val('');
        } else {
            $('#name_line<?= $value->code_material ?>').val(name_line);
            $('#code_line<?= $value->code_material ?>').val(code_line);
            // Hapus aturan validasi 'required' saat memilih nilai dari select option
            $('#name_line<?= $value->code_material ?>').rules('remove', 'required');
            $('#code_line<?= $value->code_material ?>');
            // Hapus pesan 'required'
            $('#name_line<?= $value->code_material ?>').siblings('.invalid-feedback').remove();
            $('#code_line<?= $value->code_material ?>');
            // Hilangkan kelas 'is-invalid'
            $('#name_line<?= $value->code_material ?>').removeClass('is-invalid');
            $('#code_line<?= $value->code_material ?>');
        }

        // Validasi kembali formulir setelah memilih nilai dari select option
        $('#form_update_material_<?= $value->code_material ?>').valid();

        // Lakukan pengambilan data mesin berdasarkan garis yang dipilih
        $.ajax({
            url: "<?php echo base_url('select2/get_machine_by_line'); ?>",
            type: "GET",
            dataType: "json",
            data: {
                code_line: code_line // Menggunakan code_line untuk mengirim data garis yang dipilih ke server
            },
            success: function(response) {
                // Bersihkan pilihan lama jika ada
                $('#machine<?= $value->code_material ?>').empty().trigger(
                    'change'
                ); // Trigger 'change' setelah mengosongkan untuk menampilkan placeholder
                // Tambahkan opsi default
                // Loop melalui data mesin dan tambahkan ke select
                $.each(response.machines, function(key, value) {
                    $('#machine<?= $value->code_material ?>').append(
                        '<option value="' + value.code_machine +
                        '">' +
                        value.name_machine + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    $('#machine<?= $value->code_material ?>').change(function(e) {
        e.preventDefault();

        var selectedOptions = $(this).find('option:selected');
        var machineNames = [];

        selectedOptions.each(function() {
            machineNames.push($(this).text());
        });

        $('#name_machine<?= $value->code_material ?>').val(machineNames.join(', '));

        // Menerapkan aturan validasi dinamis
        if (selectedOptions.length === 0) {
            $('#name_machine<?= $value->code_material ?>').rules('add', 'required');
        } else {
            $('#name_machine<?= $value->code_material ?>').rules('remove', 'required');
        }

        // Menghapus kelas 'is-invalid' untuk menghilangkan garis merah
        $('#name_machine<?= $value->code_material ?>').removeClass('is-invalid');

        // Validasi kembali formulir setelah memilih mesin
        $('#form_update_material_<?= $value->code_material ?>').valid();
    });

    $.ajax({
        url: "<?php echo site_url('select2/get_uom'); ?>",
        type: "GET",
        dataType: "json",
        success: function(response) {
            // Bersihkan pilihan lama jika ada
            $('#uom<?= $value->code_material ?>').empty();
            // Tambahkan opsi default
            $('#uom<?= $value->code_material ?>').append(
                '<option selected="selected" value="">- Select Uom -</option>');
            // Loop melalui data uom dan tambahkan ke Select2
            $.each(response.uom, function(key, value) {
                $('#uom<?= $value->code_material ?>').append('<option value="' + value
                    .code_uom + '">' + value
                    .name_uom + '</option>');
            });
            // Inisialisasi kembali Select2 setelah memperbarui opsi

        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    $('#uom<?= $value->code_material ?>').change(function(e) {
        e.preventDefault();
        var uom = $(this).val(); // Mengambil nilai dari opsi yang dipilih

        if (uom == '') {
            $('#code_uom<?= $value->code_material ?>').val('').rules('add', 'required');
        } else {
            $('#code_uom<?= $value->code_material ?>').val(uom);
            // Hapus aturan validasi 'required' saat memilih nilai dari select option
            $('#code_uom<?= $value->code_material ?>').rules('remove', 'required');
            // Hapus pesan 'required'
            $('#code_uom<?= $value->code_material ?>').siblings('.invalid-feedback').remove();
            // Hilangkan kelas 'is-invalid'
            $('#code_uom<?= $value->code_material ?>').removeClass('is-invalid');
        }

        // Validasi kembali formulir setelah memilih nilai dari select option
        $('#form_update_material_<?= $value->code_material ?>').valid();
    });

    $.ajax({
        url: "<?php echo site_url('select2/get_location'); ?>",
        type: "GET",
        dataType: "json",
        success: function(response) {
            // Bersihkan pilihan lama jika ada
            $('#location<?= $value->code_material ?>').empty();
            // Tambahkan opsi default
            $('#location<?= $value->code_material ?>').append(
                '<option selected="selected" value="">- Select Uom -</option>');
            // Loop melalui data uom dan tambahkan ke Select2
            $.each(response.location, function(key, value) {
                $('#location<?= $value->code_material ?>').append('<option value="' + value
                    .code_location + '">' + value
                    .name_location + '</option>');
            });
            // Inisialisasi kembali Select2 setelah memperbarui opsi

        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    $('#location<?= $value->code_material ?>').change(function(e) {
        e.preventDefault();
        var location = $(this).val(); // Mengambil nilai dari opsi yang dipilih

        if (location == '') {
            $('#code_location<?= $value->code_material ?>').val('').rules('add', 'required');
        } else {
            $('#code_location<?= $value->code_material ?>').val(location);
        }

        // Validasi kembali formulir setelah memilih nilai dari select option
        $('#form_update_material_<?= $value->code_material ?>').valid();
    });


    <?php endforeach; ?>

    //------------------------------- Delete -------------------------------\\

    $(document).on('click', 'button[data-id-material]', function() {
        var id_material = $(this).data('id-material');
        var code_material = $(this).data('code-material');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this! " + code_material,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('admin/delete_material') ?>',
                    data: {
                        code_material: code_material
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
});
</script>