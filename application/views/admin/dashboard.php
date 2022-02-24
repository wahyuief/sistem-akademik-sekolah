<div class="layout-px-spacing">                
    <div class="row layout-spacing layout-top-spacing" id="cancel-row">
        <div class="col-lg-12">
            <div class="widget-content searchable-container list">
                <div class="row">
                    <div class="col-md-12 layout-spacing">
                        <div class="widget-content widget-content-area br-6">
                            <a href="javascript:;" id="btn-add-sekolah" class="btn btn-primary">Daftarkan Sekolah</a>
                            Anda belum mendaftarkan sekolah, silakan klik pada tombol untuk mendaftarkan sekolah Anda.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addSekolahModal" tabindex="-1" role="dialog" aria-labelledby="addSekolahModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="addSekolahModalTitle" method="post" action="<?= base_url('admin/sekolah/do_insert') ?>">
                <div class="modal-body">
                    <i class="flaticon-cancel-12 close" data-dismiss="modal"></i>
                    <div class="add-Sekolah-box">
                        <div class="add-Sekolah-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="number" id="npSN" name="npsn" class="form-control" placeholder="NPSN (Nomor Pokok Sekolah Nasional)" min="0">
                                        <small><a href="https://referensi.data.kemdikbud.go.id/index11.php" target="_blank">Klik disini untuk mendapatkan kode NPSN</a></small>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Sekolah">
                                    </div>
                                    <div class="input-group">
                                        <input type="text" id="slug" name="slug" class="form-control" placeholder="Subdomain">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon5">.kolaan.com</span>
                                        </div>
                                    </div><br>
                                    <div class="form-group">
                                        <input type="button" id="pilihlogo" class="form-control" value="Pilih Logo">
                                        <input type="file" id="logo" name="logo" class="form-control" accept=".jpg,.png,.jpeg">
                                        <small id="pasUpdateAja"></small>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat Sekolah">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" id="akreditasi" name="akreditasi" class="form-control" placeholder="Akreditasi">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" id="status" name="status" class="form-control" placeholder="Status Sekolah">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" id="jenjang" name="jenjang" class="form-control" placeholder="Jenjang Pendidikan">
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
<script src="<?= base_url('assets/js/admin/sekolah.js') ?>"></script>