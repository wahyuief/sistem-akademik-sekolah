<div class="layout-px-spacing">                
    <div class="row layout-spacing layout-top-spacing" id="cancel-row">
        <div class="col-lg-12">
            <div class="widget-content searchable-container list">

                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-5 col-sm-7 filtered-list-search layout-spacing align-self-center">
                        <form class="form-inline my-2 my-lg-0">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <input type="text" class="form-control product-search" id="input-search" placeholder="Search Sekolah...">
                            </div>
                        </form>
                    </div>

                    <div class="col-xl-8 col-lg-7 col-md-7 col-sm-5 text-sm-right text-center layout-spacing align-self-center">
                        <div class="d-flex justify-content-sm-end justify-content-center">
                            <svg id="btn-add-contact" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form id="addContactModalTitle" method="post" action="<?= base_url('ngadimin/dashboard/do_insert') ?>">
                                        <div class="modal-body">
                                            <i class="flaticon-cancel-12 close" data-dismiss="modal"></i>
                                            <div class="add-contact-box">
                                                <div class="add-contact-content">
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
                                            <button class="btn" data-dismiss="modal"> <i class="flaticon-delete-1"></i> Discard</button>
                                            <button type="button" id="btn-add" class="btn">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="searchable-items list">
                    <div class="items items-header-section">
                        <div class="item-content">
                            <div><h4 style="margin-left: 18px;">Nama Sekolah</h4></div>
                            <div><h4 style="margin-left: 190px;">Pengguna</h4></div>
                            <div><h4 style="margin-left: 70px;">Alamat</h4></div>
                            <div><h4 style="margin-left: 0;">Option</h4></div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/apps/adminwebsite.js') ?>"></script>