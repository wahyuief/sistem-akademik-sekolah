<link rel="stylesheet" href="<?= base_url('assets/plugins/table/datatable/datatables.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/table/datatable/dt-global_style.css') ?>">
<div class="layout-px-spacing">
    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <a href="javascript:;" id="btn-add-kelas" class="btn btn-primary">Tambah Baru</a>
                <div class="table-responsive mb-4 mt-4">
                    <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Kelas</th>
                                <th>Kurikulum</th>
                                <th>Wali Kelas</th>
                                <th>Siswa (<?= date('Y') ?>)</th>
                                <th width="100">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;foreach($data as $row): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $row->nama ?></td>
                                <td><?= $row->kurikulum ?></td>
                                <td><?= $this->aauth->get_user($row->walikelas)->fullname ?></td>
                                <td><?= count(db_get_all_data('kelas_siswa', ['kelas_id'=>$row->id])) ?> Siswa</td>
                                <td>
                                    <a href="<?= base_url('admin/kelas/siswa/'.$row->id) ?>">Siswa</a>,
                                    <a href="<?= base_url('admin/kelas/do_update/'.$row->id) ?>" class="linkEdit" kelas="<?= $row->nama ?>" kurikulum="<?= $row->kurikulum ?>" walikelas="<?= $row->walikelas ?>">Edit</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addKelasModal" tabindex="-1" role="dialog" aria-labelledby="addKelasModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="addKelasModalTitle" method="post" action="<?= base_url('admin/kelas/do_insert') ?>">
                <div class="modal-body">
                    <i class="flaticon-cancel-12 close" data-dismiss="modal"></i>
                    <div class="add-Kelas-box">
                        <div class="add-Kelas-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="kelas" id="kelas" placeholder="Nama Kelas" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <select name="kurikulum" id="kurikulum" class="form-control">
                                            <option value="" selected disabled>Pilih Tahun Kurikulum</option>
                                            <?php foreach($kurikulum as $row): ?>
                                                <option value="<?= $row->tahun ?>"><?= $row->tahun ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="walikelas" id="walikelas" class="form-control">
                                            <option value="" selected disabled>Pilih Wali Kelas</option>
                                            <?php foreach($walikelas as $row): ?>
                                                <option value="<?= $row->id ?>"><?= $row->fullname ?></option>
                                            <?php endforeach; ?>
                                        </select>
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
<script src="<?= base_url('assets/js/admin/kelas.js') ?>"></script>