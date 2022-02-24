<link rel="stylesheet" href="<?= base_url('assets/plugins/table/datatable/datatables.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/table/datatable/dt-global_style.css') ?>">
<div class="layout-px-spacing">
    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <a href="javascript:;" id="btn-add-pelajaran" class="btn btn-primary">Tambah Baru</a>
                <div class="table-responsive mb-4 mt-4">
                    <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Kode Pelajaran</th>
                                <th>Nama Pelajaran</th>
                                <th width="100">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;foreach($data as $row): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $row->kode ?></td>
                                <td><?= $row->nama ?></td>
                                <td><a href="<?= base_url('admin/pelajaran/do_update/'.$row->id) ?>" class="linkEdit" kode="<?= $row->kode ?>" nama="<?= $row->nama ?>">Edit</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addPelajaranModal" tabindex="-1" role="dialog" aria-labelledby="addPelajaranModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="addPelajaranModalTitle" method="post" action="<?= base_url('admin/pelajaran/do_insert') ?>">
                <div class="modal-body">
                    <i class="flaticon-cancel-12 close" data-dismiss="modal"></i>
                    <div class="add-Pelajaran-box">
                        <div class="add-Pelajaran-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" id="kode" name="kode" class="form-control" placeholder="Kode Pelajaran">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Pelajaran">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="flex-auto removeBtn">
                        <button type="button" id="btn-remove" class="btn btn-danger">Hapus</button>
                    </div>
                    <button class="btn btn-dark" data-dismiss="modal"> <i class="flaticon-delete-1"></i> Batal</button>
                    <button type="button" id="btn-add" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/plugins/table/datatable/datatables.js') ?>"></script>
<script src="<?= base_url('assets/js/admin/pelajaran.js') ?>"></script>