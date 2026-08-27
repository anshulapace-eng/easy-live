<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="google" content="notranslate">
    <?php slot('meta'); ?>

    <title><?= vars('page_title') ?? lang('backend_section') ?> | Dr. Shahu Clinic</title>

    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Boxicons (For Icons) -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="<?= asset_url('assets/img/favicon.ico') ?>">
    <link rel="icon" sizes="192x192" href="<?= asset_url('assets/img/logo.png') ?>">

    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/vendor/trumbowyg/trumbowyg.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/vendor/select2/select2.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/vendor/flatpickr/flatpickr.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/vendor/flatpickr/material_green.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/themes/' . setting('theme', 'default') . '.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/general.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/backend.css') ?>">

    <?php component('company_color_style', ['company_color' => setting('company_color')]); ?>

    <?php slot('styles'); ?>

    <style>
        :root {
            --primary-color: #0d7774;
            --primary-light: #e8f7f5;
            --primary-border: #c7e2e0;
            --text-dark: #17252d;
            --text-muted: #586b7d;
            --text-light-gray: #8a99a5;
            --bg-body: #f4f7f9;
            --bg-sidebar: #ffffff;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 85px;
            --header-height: 70px;
            --card-border: #e1e8ec;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            overflow-x: hidden;
            margin: 0;
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* ==================== SIDEBAR ==================== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--bg-sidebar);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            border-right: 1px solid #e8eef3;
            z-index: 1040;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar-top {
            padding: 15px;
            position: relative;
            z-index: 1050;
        }

        /* ==================== CHAMBER BUTTON ==================== */
        .chamber-btn {
            display: flex; align-items: center; justify-content: space-between; padding: 10px;
            background: #f4f8f9; border: 1px solid #e1e8ec; border-radius: 14px;
            text-decoration: none; color: var(--text-dark); transition: all 0.3s ease;
            cursor: pointer; position: relative;
        }
        .chamber-btn:hover, .chamber-btn.open { background: var(--primary-light); border-color: var(--primary-border); }
        .chamber-icon { width: 40px; height: 40px; background: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.04); flex-shrink: 0; transition: all 0.3s ease; }
        .chamber-info { flex-grow: 1; margin-left: 12px; overflow: hidden; transition: opacity 0.2s ease; }
        .chamber-label { font-size: 10px; color: #8a99a5; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px; display: block; }
        .chamber-name { font-size: 14px; font-weight: 700; margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .chamber-arrow { width: 32px; height: 32px; background: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #60727f; box-shadow: 0 2px 6px rgba(0,0,0,0.04); transition: all 0.3s ease; flex-shrink: 0; }
        .chamber-btn:hover .chamber-arrow, .chamber-btn.open .chamber-arrow { color: var(--primary-color); }
        .chamber-btn.open .chamber-arrow i { transform: rotate(180deg); }
        .chamber-arrow i { font-size: 18px; transition: transform 0.3s ease; }

        /* ==================== SMOOTH DROPDOWN PANEL ==================== */
        .chamber-dropdown-panel {
            position: absolute; top: 80px; left: 15px; right: 15px; width: auto; background: #fff;
            border: 1px solid #e1e8ec; border-radius: 16px; box-shadow: 0 12px 35px rgba(0,0,0,0.08);
            z-index: 1060; padding: 15px; visibility: hidden; opacity: 0; transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s ease; display: block !important; 
        }
        .chamber-dropdown-panel.show { visibility: visible; opacity: 1; transform: translateY(0); }
        .panel-header { display: flex; align-items: center; padding-bottom: 12px; border-bottom: 1px solid #edf1f3; margin-bottom: 10px; }
        .panel-logo { width: 42px; height: 42px; background: #f8fafb; border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid #e3eaee; }
        .panel-title-box { flex-grow: 1; margin-left: 12px; min-width: 0; }
        .panel-subtitle { font-size: 10px; font-weight: 700; color: #8a99a5; text-transform: uppercase; display: block; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .panel-title { font-size: 14px; font-weight: 700; color: var(--text-dark); margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .panel-close-btn { width: 32px; height: 32px; min-width: 32px; background: #f4f7f9; border: none; border-radius: 8px; color: #586b7d; display: flex; align-items: center; justify-content: center; font-size: 20px; cursor: pointer; transition: 0.2s; }
        .panel-close-btn:hover { background: #e2e8ec; color: var(--text-dark); }
        .panel-menu-list { list-style: none; padding: 0; margin: 0; }
        .panel-menu-item { display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; border-radius: 10px; color: var(--text-dark); text-decoration: none; font-weight: 600; font-size: 14px; margin-bottom: 4px; transition: 0.2s; }
        .panel-menu-item:hover { background: #f4f7f9; color: var(--text-dark); }
        .panel-menu-item.active { background: var(--primary-light); }
        .item-check { width: 22px; height: 22px; background: #d0efea; color: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: bold; }
        .panel-divider { margin: 10px 0; border-top: 1px solid #edf1f3; }
        .panel-action-item { display: flex; align-items: center; gap: 12px; padding: 10px 14px; color: #4a5c6a; text-decoration: none; font-weight: 500; font-size: 14px; border-radius: 10px; transition: 0.2s; }
        .panel-action-item:hover { background: #f4f7f9; color: var(--text-dark); }
        .panel-action-item i { font-size: 20px; color: var(--primary-color); }

        /* ==================== SIDEBAR MENU ==================== */
        .sidebar-menu-wrapper { flex-grow: 1; overflow-y: auto; padding: 10px 15px; }
        .sidebar-menu-wrapper::-webkit-scrollbar { width: 4px; }
        .sidebar-menu-wrapper::-webkit-scrollbar-thumb { background: #dbe5e9; border-radius: 4px; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu > li { margin-bottom: 4px; position: relative; }
        .sidebar-menu > li > a { display: flex; align-items: center; padding: 10px 12px; color: var(--text-muted); text-decoration: none; font-size: 14.5px; font-weight: 500; border-radius: 8px; transition: 0.2s; position: relative; }
        .sidebar-menu > li > a i.bx { font-size: 20px; margin-right: 12px; color: #81919e; transition: 0.2s; }
        .sidebar-menu > li > a:hover { color: var(--primary-color); background: #f4f8f8; }
        .sidebar-menu > li > a:hover i.bx { color: var(--primary-color); }
        .sidebar-menu > li.active > a, .sidebar-menu > li.open > a { background: var(--primary-light); color: var(--primary-color); font-weight: 600; }
        .sidebar-menu > li.active > a i.bx, .sidebar-menu > li.open > a i.bx { color: var(--primary-color); }
        .sidebar-menu > li.active > a::before { content: ''; position: absolute; left: 0; top: 10%; height: 80%; width: 4px; background: var(--primary-color); border-radius: 0 4px 4px 0; }
        .has-submenu > a .arrow { margin-left: auto; margin-right: 0; transition: transform 0.3s; font-size: 16px; }
        .has-submenu.open > a .arrow { transform: rotate(180deg); }
        
        .submenu { list-style: none; padding-left: 36px; display: none; margin-top: 4px; margin-bottom: 4px; position: relative; }
        .submenu::before { content: ''; position: absolute; left: 21px; top: 0; bottom: 10px; width: 1px; background-color: #e2eaee; z-index: 1; }
        .submenu > li { margin-bottom: 2px; }
        .submenu > li > a { display: flex; align-items: center; padding: 9px 12px; font-size: 13.5px; font-weight: 500; color: var(--text-muted); text-decoration: none; border-radius: 8px; transition: 0.2s; position: relative; z-index: 2; }
        .submenu > li > a i.bx { font-size: 18px; margin-right: 12px; color: #8a99a5; }
        .submenu > li > a:hover { background-color: #f4f8f8; color: var(--primary-color); }
        .submenu > li > a:hover i.bx { color: var(--primary-color); }
        .submenu > li.active > a { background-color: var(--primary-light); color: var(--primary-color); font-weight: 600; }
        .submenu > li.active > a i.bx { color: var(--primary-color); }

        /* ==================== HEADER ==================== */
        .header { position: fixed; top: 0; right: 0; left: var(--sidebar-width); height: var(--header-height); background: #fff; border-bottom: 1px solid #e8eef3; z-index: 1030; display: flex; align-items: center; justify-content: space-between; padding: 0 24px; transition: all 0.3s ease; }
        .header-left { display: flex; align-items: center; }
        .toggle-btn { background: #e8f7f5; border: 1px solid var(--primary-border); color: var(--primary-color); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 22px; cursor: pointer; transition: 0.2s; }
        .header-actions { display: flex; align-items: center; gap: 10px; }
        .btn-topbar { display: flex; align-items: center; gap: 6px; padding: 8px 14px; font-size: 13px; font-weight: 600; border-radius: 8px; text-decoration: none; transition: 0.2s; }
        .btn-upgrade { background: var(--primary-light); color: var(--primary-color); border: 1px solid var(--primary-border); }
        .btn-light-action { background: #f4f7f9; color: var(--text-dark); border: 1px solid #e1e8ec; }
        .btn-light-action:hover { background: #eef3f5; color: var(--primary-color); }
        .icon-btn { width: 40px; height: 40px; border-radius: 10px; background: #f4f7f9; border: 1px solid #e1e8ec; display: flex; align-items: center; justify-content: center; color: #56697a; font-size: 18px; text-decoration: none; position: relative; }
        .icon-btn:hover { background: #eef3f5; color: var(--primary-color); }
        .noti-dot { position: absolute; top: 8px; right: 8px; width: 8px; height: 8px; background: #ef4444; border-radius: 50%; border: 1.5px solid #fff; }
        .user-profile-btn { display: flex; align-items: center; gap: 8px; padding: 5px 12px 5px 5px; background: #f4f7f9; border: 1px solid #e1e8ec; border-radius: 10px; text-decoration: none; color: var(--text-dark); font-size: 14px; font-weight: 500; }
        .user-profile-btn img { width: 30px; height: 30px; border-radius: 8px; object-fit: cover; }

        /* ==================== MAIN CONTENT & DASHBOARD DESIGN ==================== */
        .main-content {
            margin-left: var(--sidebar-width); margin-top: var(--header-height); padding: 24px; min-height: calc(100vh - var(--header-height)); transition: all 0.3s ease; display: flex; flex-direction: column;
        }

        /* Hover Animation Configuration */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        .hover-lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.07);
        }

        .dash-card { background: #fff; border: 1px solid var(--card-border); border-radius: 16px; padding: 24px; height: 100%; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between; }
        .dash-card-header { display: flex; justify-content: space-between; align-items: flex-start; }
        .dash-title { font-size: 11px; font-weight: 700; color: var(--text-light-gray); text-transform: uppercase; letter-spacing: 0.5px; }
        .dash-number { font-size: 32px; font-weight: 800; color: var(--text-dark); margin: 12px 0; font-family: 'Plus Jakarta Sans', sans-serif; line-height: 1; }
        .dash-subtitle { font-size: 12px; color: var(--text-light-gray); font-weight: 500; }
        .dash-icon-box { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
        .icon-green { background: #e8f7f5; color: #0d7774; }
        .icon-purple { background: #f0f0ff; color: #5c6bc0; }
        .icon-red { background: #fceceb; color: #e53935; }
        .status-dots { display: flex; align-items: center; gap: 8px; font-size: 11px; color: var(--text-muted); font-weight: 500; margin-top: auto; }
        .dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 2px;}
        .dot-done { background: #0d7774; }
        .dot-queue { background: #f6c23e; }
        .dot-cancel { background: #e53935; }
        
        .section-title { font-size: 18px; font-weight: 700; color: var(--text-dark); margin-bottom: 4px; font-family: 'Plus Jakarta Sans', sans-serif; }
        .section-subtitle { font-size: 13px; color: var(--text-light-gray); font-weight: 500; }
        .toggle-pills { background: #f4f7f9; border-radius: 20px; padding: 4px; display: flex; gap: 4px; }
        .toggle-pill { padding: 5px 14px; font-size: 12px; font-weight: 600; color: var(--text-muted); border-radius: 16px; cursor: pointer; text-decoration: none; transition: 0.2s; }
        .toggle-pill.active, .toggle-pill:hover { background: #fff; color: var(--text-dark); box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .table-custom { width: 100%; margin-top: 10px; }
        .table-custom th { font-size: 10px; font-weight: 700; color: var(--text-light-gray); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #edf1f3; padding: 12px 0; text-align: left; }
        .empty-state { text-align: center; color: var(--text-light-gray); font-size: 14px; font-weight: 500; padding: 60px 0; }
        
        .footer { margin-top: auto; padding: 20px 0 0 0; display: flex; justify-content: space-between; color: var(--text-dark); font-size: 13px; font-weight: 500; }
        .footer .version { color: var(--text-muted); }

        .dropdown-menu { border: 1px solid #e1e8ec; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); padding: 8px; }
        .dropdown-item { border-radius: 6px; padding: 8px 12px; font-size: 14px; font-weight: 500; }
        .dropdown-item:hover { background-color: #f4f7f9; color: var(--primary-color); }

        /* ==================== DESKTOP COLLAPSED STATE (EXACT MATCH) ==================== */
        @media (min-width: 992px) {
            body.sidebar-collapse .sidebar { width: var(--sidebar-collapsed-width); overflow: visible !important; }
            body.sidebar-collapse .sidebar-menu-wrapper { overflow: visible !important; }
            body.sidebar-collapse .header { left: var(--sidebar-collapsed-width); }
            body.sidebar-collapse .main-content { margin-left: var(--sidebar-collapsed-width); }
            
            body.sidebar-collapse .chamber-info, body.sidebar-collapse .chamber-arrow, body.sidebar-collapse .sidebar-menu > li > a > span { display: none !important; }
            
            body.sidebar-collapse .chamber-btn { justify-content: center; padding: 6px; width: 54px; height: 54px; margin: 0 auto; background: var(--primary-light); border-color: var(--primary-border); border-radius: 14px; position: relative; }
            body.sidebar-collapse .chamber-icon { margin: 0; width: 100%; height: 100%; border: none; box-shadow: 0 2px 6px rgba(0,0,0,0.04); }
            body.sidebar-collapse .chamber-arrow { position: absolute; top: 50%; right: -12px; transform: translateY(-50%); width: 26px; height: 26px; background: #fff; border-radius: 50%; border: 1px solid var(--primary-border); box-shadow: 0 2px 6px rgba(0,0,0,0.1); color: var(--primary-color); display: flex !important; }
            body.sidebar-collapse .chamber-btn.open .chamber-arrow { background: #fff; }
            body.sidebar-collapse .chamber-dropdown-panel { left: 95px; top: 15px; width: 280px; right: auto; }

            body.sidebar-collapse .sidebar-menu > li { position: relative; }
            body.sidebar-collapse .sidebar-menu > li > a { justify-content: center; padding: 14px 0; width: 50px; margin: 0 auto; }
            body.sidebar-collapse .sidebar-menu > li > a i.bx { margin-right: 0; font-size: 24px; }
            body.sidebar-collapse .sidebar-menu > li.has-submenu > a .arrow { display: flex !important; position: absolute; top: 50%; right: -4px; transform: translateY(-50%); margin: 0; font-size: 14px; background: #fff; border: 1px solid #e1e8ec; color: var(--primary-color); border-radius: 50%; width: 18px; height: 18px; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.08); }
            body.sidebar-collapse .sidebar-menu > li.has-submenu.open > a .arrow { transform: translateY(-50%) rotate(180deg); }
            body.sidebar-collapse .submenu { position: absolute; top: 0; left: 70px; width: 240px; background: #fff; border: 1px solid #e1e8ec; border-radius: 0 12px 12px 12px; box-shadow: 5px 5px 20px rgba(0,0,0,0.06); padding: 10px; margin: 0; z-index: 1050; }
            body.sidebar-collapse .submenu::before { display: none; }
            body.sidebar-collapse .submenu > li > a { padding: 10px 14px; }
        }

        /* ==================== MOBILE VIEW ==================== */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .header, .main-content { left: 0; margin-left: 0; }
            body.sidebar-open .sidebar { transform: translateX(0); }
            body.sidebar-open::after { content: ''; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.4); z-index: 1035; }
            .btn-topbar span { display: none; }
        }

        .calendar-loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.75);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    backdrop-filter: blur(1px);
}
.spinner-border-custom {
    width: 3rem;
    height: 3rem;
    border: 0.35rem solid #e2e8f0;
    border-top-color: #0d7774;
    border-radius: 50%;
    animation: spinner-rotate 0.75s linear infinite;
}
@keyframes spinner-rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <?php component('backend_sidebar',['active_menu' => vars('active_menu')]); ?>

    <!-- HEADER -->
   <?php component('backend_header1'); ?>

    <!-- MAIN CONTENT -->
    <main class="main-content" id="main-content">
        <!-- Global Page Loader Overlay -->
    <div id="global-page-loader" class="calendar-loading-overlay" style="display: none;">
        <div class="spinner-border-custom"></div>
    </div>
        <?php slot('content'); ?>
        

        <!-- <?php component('backend_footer1'); ?> -->
        

    </main>

    <!-- Javascript Assets -->
    <script src="<?= asset_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/@popperjs-core/popper.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= asset_url('assets/vendor/moment/moment.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/moment-timezone/moment-timezone-with-data.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/@fortawesome-fontawesome-free/fontawesome.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/@fortawesome-fontawesome-free/solid.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/tippy.js/tippy-bundle.umd.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/trumbowyg/trumbowyg.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/select2/select2.min.js') ?>"></script>
    <script src="<?= asset_url('assets/vendor/flatpickr/flatpickr.min.js') ?>"></script>

    <script src="<?= asset_url('assets/js/app.js') ?>"></script>
    <script src="<?= asset_url('assets/js/utils/date.js') ?>"></script>
    <script src="<?= asset_url('assets/js/utils/file.js') ?>"></script>
    <script src="<?= asset_url('assets/js/utils/http.js') ?>"></script>
    <script src="<?= asset_url('assets/js/utils/lang.js') ?>"></script>
    <script src="<?= asset_url('assets/js/utils/message.js') ?>"></script>
    <script src="<?= asset_url('assets/js/utils/string.js') ?>"></script>
    <script src="<?= asset_url('assets/js/utils/url.js') ?>"></script>
    <script src="<?= asset_url('assets/js/utils/validation.js') ?>"></script>
    <script src="<?= asset_url('assets/js/layouts/backend_layout.js') ?>"></script>
    <script src="<?= asset_url('assets/js/http/localization_http_client.js') ?>"></script>

    <!-- Custom Interaction Script -->
    <script>
        $(document).ready(function() {

        // Global AJAX Start -> Loader dikhayein
    $(document).ajaxStart(function() {
        $('#global-page-loader').fadeIn(100);
    });

    // Global AJAX Stop -> Loader chupayein
    $(document).ajaxStop(function() {
        $('#global-page-loader').fadeOut(150);
    });

            // 1. SMOOTH CHAMBER DROPDOWN LOGIC
            var $chamberBtn = $('#chamberToggleBtn');
            var $chamberPanel = $('#chamberDropdownPanel');
            var $closePanelBtn = $('#closePanelBtn');

            $chamberBtn.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                if($('body').hasClass('sidebar-collapse') && $(window).width() > 991.98) {
                    $('.submenu').slideUp(0);
                    $('.has-submenu').removeClass('open active');
                }

                $(this).toggleClass('open');
                $chamberPanel.toggleClass('show'); 
            });

            $closePanelBtn.on('click', function(e) {
                e.preventDefault();
                $chamberPanel.removeClass('show');
                $chamberBtn.removeClass('open');
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.sidebar-top').length) {
                    if ($chamberPanel.hasClass('show')) {
                        $chamberPanel.removeClass('show');
                        $chamberBtn.removeClass('open');
                    }
                }
                if ($('body').hasClass('sidebar-collapse') && $(window).width() > 991.98) {
                    if (!$(e.target).closest('.sidebar-menu').length) {
                        $('.submenu').slideUp(150);
                        $('.has-submenu').removeClass('open active');
                    }
                }
            });

            // 2. SIDEBAR SHRINK/SLIDE TOGGLE
            $('#sidebarToggle').on('click', function(e) {
                e.preventDefault();
                if ($(window).width() > 991.98) {
                    $('body').toggleClass('sidebar-collapse');
                    if ($('body').hasClass('sidebar-collapse')) {
                        $chamberPanel.removeClass('show');
                        $chamberBtn.removeClass('open');
                        $('.submenu').slideUp(0);
                        $('.has-submenu').removeClass('open active');
                    }
                } else {
                    $('body').toggleClass('sidebar-open');
                }
            });

            $(document).on('click', function(e) {
                if ($('body').hasClass('sidebar-open')) {
                    if (!$(e.target).closest('#sidebar, #sidebarToggle').length) {
                        $('body').removeClass('sidebar-open');
                    }
                }
            });

            // 3. SUBMENU ACCORDION & FLYOUT LOGIC
            $('.has-submenu > a').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var $parentLi = $(this).parent();

                // If Sidebar is Collapsed on Desktop (Flyout Mode)
                if ($('body').hasClass('sidebar-collapse') && $(window).width() > 991.98) {
                    if ($chamberPanel.hasClass('show')) {
                        $chamberPanel.removeClass('show');
                        $chamberBtn.removeClass('open');
                    }

                    if ($parentLi.hasClass('open')) {
                        $parentLi.removeClass('open active');
                        $(this).next('.submenu').slideUp(150);
                    } else {
                        $('.has-submenu').removeClass('open active');
                        $('.submenu').slideUp(150);
                        
                        $parentLi.addClass('open active');
                        $(this).next('.submenu').slideDown(150);
                    }
                    return; 
                }

                // Normal Accordion Mode
                if ($parentLi.hasClass('open')) {
                    $parentLi.removeClass('open active');
                    $(this).next('.submenu').slideUp(200);
                } else {
                    $('.has-submenu').removeClass('open active');
                    $('.submenu').slideUp(200);
                    
                    $parentLi.addClass('open active');
                    $(this).next('.submenu').slideDown(200);
                }
            });

            $('.submenu > li > a').on('click', function(e) {
                e.stopPropagation(); 
            });

            // 4. FULLSCREEN LOGIC
            $('#fullscreenToggle').on('click', function(e) {
                e.preventDefault();
                var doc = window.document;
                var docEl = doc.documentElement;
                var requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
                var cancelFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;

                if (!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
                    requestFullScreen.call(docEl);
                    $(this).find('i').removeClass('bx-fullscreen').addClass('bx-exit-fullscreen');
                } else {
                    cancelFullScreen.call(doc);
                    $(this).find('i').removeClass('bx-exit-fullscreen').addClass('bx-fullscreen');
                }
            });

            // 5. AUTO ACTIVE MENU LINK BASED ON CURRENT URL
            var currentUrl = window.location.href.split('?')[0];

            $('.sidebar-menu a, .submenu a').each(function() {
                var linkUrl = this.href.split('?')[0];
                
                if (linkUrl === currentUrl) {
                    if ($(this).closest('.submenu').length) {
                        $(this).closest('li').addClass('active');
                        var $parentLi = $(this).closest('.has-submenu');
                        $parentLi.addClass('active open');
                        $parentLi.find('.submenu').show();
                    } else {
                        $(this).parent('li').addClass('active');
                    }
                }
            });
        });
    </script>

    <?php component('js_vars_script'); ?>
    <?php component('js_lang_script'); ?>

    <?php slot('scripts'); ?>
</body>
</html>