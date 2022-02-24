<link rel="stylesheet" href="<?= base_url('assets/plugins/table/datatable/datatables.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/table/datatable/dt-global_style.css') ?>">
<div class="layout-px-spacing">
    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <a href="javascript:;" id="btn-add-user" class="btn btn-primary">Tambah Baru</a>
                <div class="table-responsive mb-4 mt-4">
                    <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Sekolah</th>
                                <th>Status</th>
                                <th>Last Login</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="addUserModalTitle" method="post" action="<?= base_url('ngadimin/users/do_insert') ?>">
                <div class="modal-body">
                    <i class="flaticon-cancel-12 close" data-dismiss="modal"></i>
                    <div class="add-User-box">
                        <div class="add-User-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Nama Lengkap">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="username" name="username" class="form-control" placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                                        <small id="pasUpdateAja"></small>
                                    </div>
                                    <div class="form-group">
                                        <select name="status" id="status" class="form-control" style="display:none" disabled>
                                            <option id="activeUser" value="0">Active</option>
                                            <option id="bannedUser" value="1">Banned</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark" data-dismiss="modal"> <i class="flaticon-delete-1"></i> Batal</button>
                    <button type="button" id="btn-add" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/plugins/table/datatable/datatables.js') ?>"></script>
<script src="<?= base_url('assets/js/ngadimin/users.js') ?>"></script>