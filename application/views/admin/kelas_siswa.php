<link rel="stylesheet" href="<?= base_url('assets/plugins/table/datatable/datatables.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/table/datatable/dt-global_style.css') ?>">
<div class="layout-px-spacing">
    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <a href="javascript:;" id="btn-add-siswa" class="btn btn-primary">Tambah Siswa</a>
                <a href="javascript:location.reload();" class="btn btn-dark">Refresh Data</a>
                <div class="table-responsive mb-4 mt-4">
                    <table id="zero-config" class="table table-hover">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>NISN</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;foreach($data as $row):
                            $siswa = _user(['id'=>$row->siswa]) ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $siswa->username ?></td>
                                <td><?= $siswa->fullname ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addSiswaModal" tabindex="-1" role="dialog" aria-labelledby="addSiswaModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <i class="flaticon-cancel-12 close" data-dismiss="modal"></i>
                <div class="add-Siswa-box">
                    <div class="add-Siswa-content">
                        <div class="table-responsive">
                            <table id="daftar-siswa" class="table table-stripped">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>NISN</td>
                                        <td>Nama Siswa</td>
                                        <td>Kelas Saat Ini</td>
                                        <td>Opsi</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>var kelas_id = <?= $this->uri->segment(4) ?>;</script>
<script src="<?= base_url('assets/plugins/table/datatable/datatables.js') ?>"></script>
<script src="<?= base_url('assets/js/admin/siswa-kelas.js') ?>"></script>