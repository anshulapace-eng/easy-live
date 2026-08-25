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

    /* Split Card Container (Matched with Login/Recovery) */
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

    /* Logo Color Filter - Matching Deep Blue Theme */
    .theme-colored-logo {
        filter: hue-rotate(90deg) saturate(1.8) brightness(0.85);
        object-fit: contain;
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
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .btn-primary:hover {
        background: #0043a8;
        box-shadow: 0 6px 20px rgba(0, 82, 204, 0.38);
        transform: translateY(-1px);
        color: #ffffff;
    }

    .btn-primary:active {
        transform: translateY(0) scale(0.99);
    }

    /* Footer Links */
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
            <i class="fas fa-sign-out-alt fa-2x"></i>
            <h3>Successfully<br>Logged Out</h3>
            <p>You have been safely signed out of your account session. See you again soon!</p>
        </div>
    </div>

    <!-- Right Side: Content Area with Logo Header -->
    <div class="login-form-side">
        
        <div class="text-center mb-4">
            <!-- Logo with matching Blue Theme filter -->
            <img src="<?= asset_url('assets/img/logo.png') ?>" 
                 alt="Easy!Appointments" class="shadow-sm mb-3 rounded theme-colored-logo" width="64" height="64">
            
            <h4 class="fw-bold text-dark mb-1" style="font-size: 26px; letter-spacing: -0.5px;">
                <?= lang('log_out') ?>
            </h4>
            
            <p class="text-muted mb-0" style="font-size: 14px;">
                <?= lang('logout_success') ?>
            </p>
        </div>

        <!--<div class="d-grid gap-2 mb-4">-->
        <!--    <a href="<?= site_url() ?>" class="btn-primary">-->
        <!--        <i class="fas fa-calendar-alt me-2"></i>-->
        <!--        <?= lang('book_appointment_title') ?>-->
        <!--    </a>-->
        <!--</div>-->
        
        <div class="d-grid gap-2 mb-4">
            <a href="<?= site_url('login') ?>" class="btn-primary">
                <i class="fas fa-arrow-left"></i>
                <?= lang('backend_section') ?>
            </a>
        </div>
        
        <!--<div class="text-center">-->
        <!--    <a href="<?= site_url('login') ?>" class="auth-footer-link">-->
        <!--        <i class="fas fa-arrow-left"></i>-->
        <!--        <?= lang('backend_section') ?>-->
        <!--    </a>-->
        <!--</div>-->
    </div>
</div>

<?php end_section('content'); ?>