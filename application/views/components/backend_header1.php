<header class="header" id="header">
    <div class="header-left">
        <button class="toggle-btn" id="sidebarToggle">
            <i class='bx bx-menu'></i>
        </button>
    </div>

    <div class="header-actions">
        
        <a href="<?= site_url('home/index') ?>" target="_blank" class="btn-topbar btn-light-action d-none d-lg-flex text-dark">
            <i class='bx bx-calendar-event text-primary'></i> <span>Booking page</span>
        </a>

        <!-- Create As New Dropdown -->
        <div class="dropdown d-none d-sm-block">
            <button class="btn-topbar btn-light-action border-0 shadow-none text-dark" type="button" data-bs-toggle="dropdown">
                <i class='bx bx-plus-circle text-primary'></i> <span>Create As New</span> <i class='bx bx-chevron-down ms-1'></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end mt-2">
                <li><a class="dropdown-item" href="#"><i class='bx bx-file me-2 text-muted'></i> Prescription</a></li>
                <li><a class="dropdown-item" href="<?= site_url('providers') ?>"><i class='bx bx-user-plus me-2 text-muted'></i> Staff</a></li>
                <li><a class="dropdown-item" href="<?= site_url('customers') ?>"><i class='bx bx-user me-2 text-muted'></i> Patient</a></li>
                <li><a class="dropdown-item" href="<?= site_url('calendar') ?>"><i class='bx bx-calendar-plus me-2 text-muted'></i> Appointment</a></li>
            </ul>
        </div>

        <a href="#" class="icon-btn d-none d-md-flex" id="fullscreenToggle" title="Fullscreen">
            <i class='bx bx-fullscreen'></i>
        </a>

        <a href="#" class="icon-btn" title="Notifications">
            <i class='bx bx-bell'></i>
            <span class="noti-dot"></span>
        </a>

        <!-- User Profile Dropdown -->
          <?php $hidden = can('view', PRIV_SYSTEM_SETTINGS) || can('view', PRIV_USER_SETTINGS) ? '' : 'd-none'; ?>
        <div class="dropdown ms-1 <?= $hidden; ?>">
            <a href="#" class="user-profile-btn" data-bs-toggle="dropdown">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode(vars('user_display_name') ?: 'Admin') ?>&background=0d7774&color=fff" alt="User">
                <span class="d-none d-md-block"><?= e(vars('user_display_name')) ?></span>
                <i class='bx bx-chevron-down d-none d-md-block text-muted'></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end mt-2" style="width: 210px;">
                <li>
                    <div class="px-3 py-2">
                        <h6 class="mb-0 font-weight-bold" style="font-size: 13.5px;"><?= e(vars('user_display_name')) ?></h6>
                        <small class="text-muted" style="font-size: 11.5px;"><?= session('email') ?? 'admin@doctly.com' ?></small>
                    </div>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
                <li><a class="dropdown-item" href="<?= site_url('account') ?>"><i class='bx bx-user me-2'></i> Account</a></li>
                <?php if (can('view', PRIV_SYSTEM_SETTINGS)): ?>
                <li><a class="dropdown-item" href="<?= site_url('general_settings') ?>"><i class='bx bx-cog me-2'></i> Settings</a></li>
                <?php endif; ?>
                
                <?php if (can('view', PRIV_SYSTEM_SETTINGS) || (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 210)): ?>
                    <li><a class="dropdown-item" href="<?= site_url('calendar/logs_view') ?>"><i class='bx bx-history me-2'></i> Action Track</a></li>
                <?php endif; ?>

                <li><hr class="dropdown-divider my-1"></li>
                <li><a class="dropdown-item text-danger" href="<?= site_url('logout') ?>"><i class='bx bx-log-out me-2'></i> Logout</a></li>
            </ul>
        </div>
    </div>
</header>