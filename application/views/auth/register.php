<h1 class="">Pendaftaran</h1>
<p class="">Daftar akun untuk dapat masuk ke dalam sistem</p>
<form class="text-left" method="post" action="<?= base_url('auth/do_register') ?>">
    <div class="form">

        <div id="username-field" class="field-wrapper input">
            <label for="username">USERNAME</label>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            <input id="username" name="username" type="text" class="form-control" placeholder="Username">
        </div>

        <div id="email-field" class="field-wrapper input">
            <label for="email">EMAIL</label>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign register"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
            <input id="email" name="email" type="text" value="" class="form-control" placeholder="Email">
        </div>

        <div id="password-field" class="field-wrapper input mb-2">
            <div class="d-flex justify-content-between">
                <label for="password">PASSWORD</label>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <input id="password" name="password" type="password" class="form-control" placeholder="Password">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="open-password" class="feather feather-toggle feather-toggle-left"><rect x="1" y="5" width="22" height="14" rx="7" ry="7"></rect><circle cx="8" cy="12" r="3"></circle></svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="close-password" class="feather feather-toggle feather-toggle-right" style="display: none;"><rect x="1" y="5" width="22" height="14" rx="7" ry="7"></rect><circle cx="16" cy="12" r="3"></circle></svg>
        </div>

        <div class="field-wrapper terms_condition">
            <div class="n-chk">
                <label class="new-control new-checkbox checkbox-primary">
                    <input type="checkbox" class="new-control-input">
                    <span class="new-control-indicator"></span><span>Saya setuju dengan <a href="javascript:void(0);"> syarat dan ketentuan </a></span>
                </label>
            </div>

        </div>

        <div class="d-sm-flex justify-content-between">
            <div class="field-wrapper">
                <button type="button" id="submit-form" class="btn btn-primary" value="">Daftar</button>
            </div>
        </div>

        <p class="signup-link">Sudah terdaftar? <a href="<?= base_url('auth/login') ?>" title="Masuk ke Sistem" class="linkajax">Masuk</a></p>

    </div>
</form>
<script src="<?= base_url('assets/js/authentication/auth.js') ?>"></script>