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
                <h2 class="card-title">List Users</h2>

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
                <table id="tbl_manage_user" class="table table-bordered table-striped nowrap">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>ROLE</th>
                            <th>STATUS</th>
                            <th>CREATED</th>
                            <th>LAST LOGIN</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($manage_users as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value->name ?></td>
                                <td><?= $value->email ?></td>
                                <td><?= $value->name_role ?></td>
                                <td>
                                    <?php if ($value->is_active == 1) {
                                        echo "Active";
                                    } else {
                                        echo "Not Active";
                                    } ?>
                                </td>
                                <td><?= $value->date_created ?></td>
                                <td><?= $value->last_login ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editUserModal<?= $value->id_users ?>">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-delete-user" data-userid="<?= $value->id_users ?>">
                                        <i class="fa fa-trash"></i>
                                    </button>

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

<?php foreach ($manage_users as $value) : ?>
    <div class="modal fade" id="editUserModal<?= $value->id_users ?>" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Manage User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('admin/update_manage_user', array('id' => 'form-update-manage-users')); ?>
                <div class="modal-body">
                    <div class="form-gorup mb-3">
                        <label for="id_user">ID Users</label>
                        <input class="form-control" type="text" name="id_users" id="id_users" value="<?= $value->id_users ?>" readonly>
                    </div>
                    <div class="form-gorup mb-3">
                        <label for="name">Name</label>
                        <input class="form-control" type="text" name="name" id="name" value="<?= $value->name ?>">
                    </div>
                    <div class="form-gorup mb-3">
                        <label for="email">Email</label>
                        <input class="form-control" type="text" name="email" id="email" value="<?= $value->email ?>">
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <div class="form-check">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="id_role_2<?= $value->id_users ?>" value="2" name="id_role" <?php echo set_value('id_role', $value->id_role) == 2 ? "checked" : ""; ?>>
                                <label for="id_role_2<?= $value->id_users ?>" class="custom-control-label">Maintenance
                                    PIC</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="id_role_3<?= $value->id_users ?>" value="3" name="id_role" <?php echo set_value('id_role', $value->id_role) == 3 ? "checked" : ""; ?>>
                                <label for="id_role_3<?= $value->id_users ?>" class="custom-control-label">Maintenance
                                    Mechanic</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-danger" type="radio" id="id_role_0<?= $value->id_users ?>" value="0" name="id_role" <?php echo set_value('id_role', $value->id_role) == 0 ? "checked" : ""; ?>>
                                <label for="id_role_0<?= $value->id_users ?>" class="custom-control-label">Non
                                    Role</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <div class="form-check">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="is_active1_<?= $value->id_users ?>" value="1" name="is_active" <?php echo set_value('is_active', $value->is_active) == 1 ? "checked" : ""; ?>>
                                <label for="is_active1_<?= $value->id_users ?>" class="custom-control-label">Aktif</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-danger" type="radio" id="is_active2_<?= $value->id_users ?>" value="0" name="is_active" <?php echo set_value('is_active', $value->is_active) == 0 ? "checked" : ""; ?>>
                                <label for="is_active2_<?= $value->id_users ?>" class="custom-control-label">Tidak
                                    Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-gorup mb-3">
                        <label for="date_created">Date Created</label>
                        <input class="form-control" type="date" name="date_created" id="date_created<?= $value->id_users ?>" value="<?= $value->date_created ?>">
                    </div>
                    <div class="form-gorup mb-3">
                        <label for="last_login">Last Login</label>
                        <input class="form-control" type="text" name="last_login" id="last_login<?= $value->id_users ?>" value="<?= $value->last_login ?>" readonly>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save
                        changes</button>
                </div>
                <?= form_close(); ?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php endforeach; ?>


<script>
    $(document).ready(function() {


        $("#tbl_manage_user").DataTable({
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
        }).buttons().container().appendTo('#tbl_manage_user_wrapper .col-md-6:eq(0)');

        $('#form-update-manage-users').submit(function(e) {
            e.preventDefault();

            var form = $(this);
            $.ajax({
                type: $(form).attr('method'),
                url: $(form).attr('action'),
                data: $(form).serialize(),
                dataType: "JSON",
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
                error: function(jqXHR, textStatus, errorThrown) {
                    // Tanggapan dari server jika terjadi kesalahan
                    console.log('AJAX Error:', textStatus);
                }
            });
        });

    });
</script>