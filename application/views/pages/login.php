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

    /* Split Card Container */
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
        padding: 50px 55px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background-color: #ffffff;
    }

    .form-header h3 {
        font-weight: 800;
        color: #0f172a;
        font-size: 28px;
        letter-spacing: -0.8px;
        margin-bottom: 6px;
    }

    .form-header p {
        color: #64748b;
        font-size: 14.5px;
        margin-bottom: 28px;
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

    /* Link */
    .auth-footer-link {
        color: #0052cc;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-block;
        margin-top: -2px;
        margin-bottom: 12px;
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
            <i class="fas fa-calendar-check fa-2x"></i>
            <h3>Dr. Shahu<br>Clinic</h3>
            <p>Easily book, track, and manage patient schedules all in one secure place.</p>
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="login-form-side">
        
        <div class="form-header">
            <h3>Welcome Back!</h3>
            <p>Please enter your details to access your dashboard</p>
        </div>

        <div class="alert d-none"></div>

        <form id="login-form">
            
            <!-- Username Field with Icon -->
            <div class="input-group-custom">
                <input type="text" id="username" name="username" 
                       placeholder="<?= lang('enter_username_here') ?>" class="form-control" required />
                <i class="fas fa-user"></i>
            </div>

            <!-- Password Field with Icon -->
            <div class="input-group-custom">
                <input type="password" id="password" name="password" 
                       placeholder="<?= lang('enter_password_here') ?>" class="form-control" required />
                <i class="fas fa-lock"></i>
            </div>
            
            <!-- Forgot Password Link -->
            <div class="text-end">
                <a href="<?= site_url('recovery') ?>" class="auth-footer-link">
                    <?= lang('forgot_your_password') ?>?
                </a>
            </div>

            <!-- Captcha Section -->
            <?php if (vars('require_captcha')): ?>
                <?php if (vars('altcha_enabled') === '1'): ?>
                    <div class="mb-3 mt-2">
                        <div id="altcha-widget" class="altcha-widget"></div>
                        <input type="hidden" id="altcha-payload" name="altcha_payload" value="">
                        <span id="altcha-hint" class="help-block text-danger small" style="opacity:0">&nbsp;</span>
                    </div>
                <?php else: ?>
                    <div class="mb-3 mt-2">
                        <label class="captcha-title form-label d-flex justify-content-between align-items-center mb-2" for="captcha-text" style="font-size: 13px; font-weight: 600; color: #475569;">
                            <span>CAPTCHA</span>
                            <button type="button" class="btn btn-link text-secondary text-decoration-none py-0 px-0 p-0" style="color: #0052cc !important;">
                                <i class="fas fa-sync-alt" style="font-size: 14px;"></i>
                            </button>
                        </label>
                        <img class="captcha-image d-block w-100 object-fit-contain" src="<?= site_url('captcha') ?>" alt="CAPTCHA" style="height: 48px;">
                        
                        <div class="input-group-custom mt-2 mb-0">
                            <input id="captcha-text" name="captcha_text" class="form-control" type="text" placeholder="<?= lang('enter_captcha_here') ?>" />
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <span id="captcha-hint" class="help-block text-danger small" style="opacity:0">&nbsp;</span>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Submit Button -->
            <div class="mt-4 mb-2">
                <button type="submit" id="login" class="btn-primary">
                    <?= lang('login') ?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>
<script src="<?= asset_url('assets/js/http/login_http_client.js') ?>"></script>
<script src="<?= asset_url('assets/js/pages/login.js') ?>"></script>
<?php end_section('scripts'); ?>