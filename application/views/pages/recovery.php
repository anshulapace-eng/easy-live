<?php extend('layouts/account_layout'); ?>

<?php section('content'); ?>

<style>
    /* Full Page Background & Centering */
    body {
        background: #f8fafc; 
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        margin: 0;
    }

    /* Split Card Container (Matched with Login) */
    .login-split-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 20px 40px -15px rgba(0, 82, 204, 0.07), 0 10px 20px -10px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        width: 100%;
        max-width: 960px;
        min-height: 580px;
        display: flex;
        flex-direction: row; 
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    /* Left Illustration/Brand Side - Premium Gradient Blue Theme */
    .login-illustration-side {
        flex: 1;
        background: linear-gradient(135deg, #065cdb 0%, #06ff8a80 100%);
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 50px;
        color: #ffffff;
    }

    /* Decorative Medical Cross Patterns */
    .login-illustration-side::before,
    .login-illustration-side::after {
        content: '+';
        position: absolute;
        color: rgba(255, 255, 255, 0.06);
        font-weight: 800;
        font-size: 160px;
        line-height: 1;
        z-index: 1;
        user-select: none;
    }

    .login-illustration-side::before {
        top: -10px;
        left: 20px;
        transform: rotate(12deg);
    }

    .login-illustration-side::after {
        bottom: -30px;
        right: 30px;
        transform: rotate(-15deg);
        font-size: 220px;
    }

    .illustration-content {
        text-align: center;
        z-index: 2;
        max-width: 320px;
    }

    .illustration-content i {
        background: rgba(255, 255, 255, 0.1);
        width: 80px;
        height: 80px;
        line-height: 80px;
        border-radius: 50%;
        margin-bottom: 24px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        display: inline-block;
    }

    .illustration-content h3 {
        font-weight: 700;
        font-size: 32px;
        margin-bottom: 16px;
        letter-spacing: -0.5px;
    }

    .illustration-content p {
        font-size: 15px;
        opacity: 0.88;
        line-height: 1.6;
        font-weight: 400;
        margin: 0;
    }

    /* Right Form Side */
    .login-form-side {
        flex: 1.15;
        padding: 40px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background-color: #ffffff;
    }

    /* Logo Color Filter - Adjusted to match the specific Deep Blue provided */
    .theme-colored-logo {
        filter: hue-rotate(90deg) saturate(1.8) brightness(0.85);
        object-fit: contain;
    }

    /* Input Field with Icons */
    .input-group-custom {
        position: relative;
        margin-bottom: 18px;
        display: block;
    }

    .input-group-custom i,
    .input-group-custom svg {
        position: absolute !important;
        left: 18px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        color: #94a3b8;
        font-size: 15px;
        width: 15px !important;
        height: 15px !important;
        z-index: 10;
        pointer-events: none;
        transition: color 0.25s ease;
    }

    .form-control {
        width: 100%;
        padding: 13px 18px 13px 46px;
        font-size: 14.5px;
        border: 1.5px solid #e2e8f0;
        background-color: #f8fafc;
        border-radius: 10px;
        transition: all 0.25s ease;
        color: #1e293b;
        box-sizing: border-box;
    }

    .form-control::placeholder {
        color: #94a3b8;
        font-weight: 400;
    }

    .form-control:focus {
        border-color: #0052cc;
        background-color: #ffffff;
        outline: none;
        box-shadow: 0 0 0 4px rgba(0, 82, 204, 0.1);
    }

    .input-group-custom:focus-within i,
    .input-group-custom:focus-within svg {
        color: #0052cc !important;
    }

    .form-label {
        font-size: 13.5px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
        display: block;
    }

    /* Back to Login Link */
    .auth-footer-link {
        color: #0052cc;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .auth-footer-link:hover {
        color: #003d99;
        text-decoration: underline;
    }

    /* Styled Button */
    .btn-primary {
        background: #0052cc;
        border: none;
        padding: 13.5px;
        font-weight: 700;
        font-size: 15px;
        border-radius: 10px;
        box-shadow: 0 4px 14px rgba(0, 82, 204, 0.28);
        transition: all 0.25s ease;
        color: #ffffff;
        letter-spacing: 0.3px;
        width: 100%;
        cursor: pointer;
    }

    .btn-primary:hover {
        background: #0043a8;
        box-shadow: 0 6px 20px rgba(0, 82, 204, 0.38);
        transform: translateY(-1px);
    }

    .btn-primary:active {
        transform: translateY(0) scale(0.99);
    }

    .captcha-image {
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        margin-bottom: 8px;
        height: 48px;
        object-fit: contain;
        width: 100%;
    }

    /* Responsive adjustment for small screens */
    @media (max-width: 768px) {
        .login-split-card {
            flex-direction: column;
            max-width: 440px;
            margin: 20px;
        }
        .login-illustration-side {
            display: none;
        }
        .login-form-side {
            padding: 40px 30px;
        }
    }
</style>

<div class="login-split-card mx-auto">
    
    <!-- Left Side: Medical Theme Illustration Panel -->
    <div class="login-illustration-side">
        <div class="illustration-content">
            <i class="fas fa-shield-alt fa-2x"></i>
            <h3>Secure<br>Recovery</h3>
            <p>Easily recover your account access and get back to managing your schedule safely.</p>
        </div>
    </div>

    <!-- Right Side: Recovery Form with Image Header -->
    <div class="login-form-side">
        
        <div class="text-center mb-4">
            <!-- Logo with CSS Filter to match the requested Deep Blue Theme -->
            <img src="<?= asset_url('assets/img/logo.png') ?>" 
                 alt="Easy!Appointments" class="shadow-sm mb-3 rounded theme-colored-logo" width="64" height="64">
            
            <h4 class="fw-bold text-dark mb-1" style="font-size: 24px; letter-spacing: -0.5px;">
                <?= lang('forgot_your_password') ?>
            </h4>
            
            <p class="text-muted small mb-0" style="font-size: 13.5px;">
                <?= lang('type_username_and_email_for_reset_link') ?>
            </p>
        </div>

        <div class="alert d-none"></div>

        <form>
            <!-- Username Field -->
            <div class="mb-3">
                <label for="username" class="form-label">
                    <?= lang('username') ?>
                </label>
                <div class="input-group-custom">
                    <input type="text" id="username" name="username"
                           placeholder="<?= lang('enter_username_here') ?>" class="form-control" required />
                    <i class="fas fa-user"></i>
                </div>
            </div>
            
            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">
                    <?= lang('email') ?>
                </label>
                <div class="input-group-custom">
                    <input type="email" id="email" name="email"
                           placeholder="<?= lang('enter_email_here') ?>" class="form-control" required />
                    <i class="fas fa-envelope"></i>
                </div>
            </div>

            <!-- Captcha Section -->
            <?php if (vars('require_captcha')): ?>
                <?php if (vars('altcha_enabled') === '1'): ?>
                    <div class="mb-3">
                        <div id="altcha-widget" class="altcha-widget"></div>
                        <input type="hidden" id="altcha-payload" name="altcha_payload" value="">
                        <span id="altcha-hint" class="help-block text-danger small" style="opacity:0">&nbsp;</span>
                    </div>
                <?php else: ?>
                    <div class="mb-3">
                        <label class="captcha-title form-label d-flex justify-content-between align-items-center mb-2" for="captcha-text">
                            <span>CAPTCHA</span>
                            <button type="button" class="btn btn-link text-secondary text-decoration-none py-0 px-0 p-0" style="color: #0052cc !important;">
                                <i class="fas fa-sync-alt" style="font-size: 14px;"></i>
                            </button>
                        </label>
                        <img class="captcha-image d-block" src="<?= site_url('captcha') ?>" alt="CAPTCHA">
                        
                        <div class="input-group-custom mb-0 mt-2">
                            <input id="captcha-text" name="captcha_text" class="form-control" type="text" placeholder="<?= lang('enter_captcha_here') ?>"/>
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <span id="captcha-hint" class="help-block text-danger small" style="opacity:0">&nbsp;</span>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <!-- Submit Button -->
            <div class="mt-4 mb-3">
                <button type="submit" id="get-new-password" class="btn-primary">
                    <i class="fas fa-paper-plane me-2"></i>
                    <?= lang('send_reset_link') ?>
                </button>
            </div>
            
            <!-- Back to Login Link -->
            <div class="text-center">
                <a href="<?= site_url('login') ?>" class="auth-footer-link">
                    <i class="fas fa-arrow-left"></i>
                    <?= lang('go_to_login') ?>
                </a>
            </div>
        </form>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>
<script src="<?= asset_url('assets/js/http/recovery_http_client.js') ?>"></script>
<script src="<?= asset_url('assets/js/pages/recovery.js') ?>"></script>
<?php end_section('scripts'); ?>