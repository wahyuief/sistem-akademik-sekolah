<h1 class="">Masuk ke Sistem</h1>
<p class="">Masuk menggunakan akun kamu untuk melanjutkan.</p>

<form class="text-left" method="post" action="<?= base_url('auth/do_login') ?>">
    <div class="form">

        <div id="username-field" class="field-wrapper input">
            <label for="username">USERNAME</label>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            <input id="username" name="username" type="text" class="form-control" placeholder="Username" value="superadmin">
        </div>

        <div id="password-field" class="field-wrapper input mb-2">
            <div class="d-flex justify-content-between">
                <label for="password">PASSWORD</label>
                <a href="<?= base_url('auth/forgot') ?>" title="Reset Password" class="linkajax forgot-pass-link">Lupa Password?</a>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <input id="password" name="password" type="password" class="form-control" placeholder="Password" value="admin">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="open-password" class="feather feather-toggle feather-toggle-left"><rect x="1" y="5" width="22" height="14" rx="7" ry="7"></rect><circle cx="8" cy="12" r="3"></circle></svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="close-password" class="feather feather-toggle feather-toggle-right" style="display: none;"><rect x="1" y="5" width="22" height="14" rx="7" ry="7"></rect><circle cx="16" cy="12" r="3"></circle></svg>
        </div>
        
        <div class="d-sm-flex justify-content-between">
            <div class="field-wrapper">
                <button type="button" id="submit-form" class="btn btn-primary">Masuk</button>
            </div>
        </div>

        <p class="signup-link">Belum terdaftar? <a href="<?= base_url('auth/register') ?>" title="Pendaftaran" class="linkajax">Buat akun</a></p>

    </div>
</form>
<script src="<?= base_url('assets/js/authentication/auth.js') ?>"></script>