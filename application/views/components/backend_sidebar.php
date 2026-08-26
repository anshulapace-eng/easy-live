<style>
    /* Sidebar Menu Items */
    .sidebar-menu>li>a {
        padding: 8px 10px !important;
        font-size: 13.5px !important;
        font-weight: 500 !important;
    }

    /* Menu Icons */
    .sidebar-menu>li>a i.bx {
        font-size: 14px !important;
        margin-right: 10px !important;
    }

    /* Submenu Styling */
    .submenu {
        padding-left: 30px !important;
    }

    .submenu>li>a {
        padding: 7px 10px !important;
        font-size: 12.5px !important;
        font-weight: 400 !important;
    }

    .submenu>li>a i.bx {
        font-size: 16px !important;
        margin-right: 10px !important;
    }

    /* Chamber Top Button Styling */
    .sidebar-top {
        padding: 12px !important;
    }

    .chamber-btn {
        padding: 8px 10px !important;
    }

    .chamber-name {
        font-size: 13px !important;
    }

    /* Collapsed Sidebar Adjustments (Desktop minimised state) */
    @media (min-width: 992px) {
        :root {
            --sidebar-collapsed-width: 75px;
        }

        body.sidebar-collapse .sidebar {
            width: var(--sidebar-collapsed-width);
        }

        body.sidebar-collapse .header {
            left: var(--sidebar-collapsed-width);
        }

        body.sidebar-collapse .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }
    }
</style>

<aside class="sidebar" id="sidebar">
    <!-- TOP: Chamber Switcher Box -->
    <div class="sidebar-top">
        <a href="#" class="chamber-btn" id="chamberToggleBtn">
            <div class="d-flex align-items-center">
                <div class="chamber-icon" style="background: var(--primary-light, #e8f7f5); color: var(--primary-color, #0d7774); border-radius: 10px; display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; font-size: 18px; flex-shrink: 0;">
                    <i class='bx bx-calendar-star'></i>
                </div>
                <div class="chamber-info" style="margin-left: 10px;">
                    <span class="chamber-label" style="font-size: 11px; font-weight: 700; color: #17252d; display: block;">Dr. Sahu</span>
                    <p style="font-size: 10px; color: #586b7d; margin: 0; font-weight: 500; line-height: 1.2;">Online Appointment Scheduler</p>
                </div>
            </div>
            <div class="chamber-arrow">
                <i class='bx bx-chevron-down'></i>
            </div>
        </a>

        <!-- Smooth Dropdown Panel -->
        <div class="chamber-dropdown-panel" id="chamberDropdownPanel">
            <div class="panel-header" style="padding-bottom: 8px; margin-bottom: 8px;">
                <div class="panel-title-box">
                    <span class="panel-subtitle" style="font-size: 9px; font-weight: 600; letter-spacing: 0.4px; color: #94a3b8;">YOUR DOCTLY ACCOUNTS</span>
                    <small style="font-size: 11.5px; font-weight: 500; color: #475569;">Chamber Name</small>
                </div>
                <button class="panel-close-btn" id="closePanelBtn" style="width: 26px; height: 26px; min-width: 26px; font-size: 16px;">
                    <i class='bx bx-x'></i>
                </button>
            </div>
            <ul class="panel-menu-list">
                <li>
                    <a href="#" class="panel-menu-item active" style="padding: 8px 10px; font-size: 12.5px; font-weight: 500;">
                        <span>Chamber Name</span>
                        <div class="item-check" style="width: 18px; height: 18px; font-size: 11px;"><i class='bx bx-check'></i></div>
                    </a>
                </li>
            </ul>
            <div class="panel-divider" style="margin: 6px 0;"></div>
            <a href="#" class="panel-action-item" style="padding: 7px 10px; font-size: 12.5px; font-weight: 400; gap: 8px;"><i class='bx bx-buildings' style="font-size: 16px;"></i> Manage Chambers</a>
            <a href="#" class="panel-action-item" style="padding: 7px 10px; font-size: 12.5px; font-weight: 400; gap: 8px;"><i class='bx bx-user' style="font-size: 16px;"></i> Manage Profile</a>
            <a href="#" class="panel-action-item" style="padding: 7px 10px; font-size: 12.5px; font-weight: 400; gap: 8px;"><i class='bx bx-log-out' style="font-size: 16px;"></i> Sign Out</a>
        </div>
    </div>

    <!-- Sidebar Navigation Menu -->
    <div class="sidebar-menu-wrapper">
        <ul class="sidebar-menu">
            <li><a href="<?= site_url('dashboard') ?>"><i class='bx bxs-dashboard'></i> <span>Dashboard</span></a></li>

            <?php $hidden = can('view', PRIV_APPOINTMENTS) ? '' : 'd-none'; ?>
            <li class="<?= $hidden ?>"><a href="<?= site_url('calendar' . (vars('calendar_view') === CALENDAR_VIEW_TABLE ? '?view=table' : '')) ?>"><i class='bx bx-time-five'></i> <span>Calendar</span></a></li>

            <?php $hidden = can('view', PRIV_CUSTOMERS) ? '' : 'd-none'; ?>
            <li class="<?= $hidden ?>"><a href="<?= site_url('customers') ?>"><i class='bx bx-user-plus'></i> <span>Customers</span></a></li>

            <?php $hidden = can('view', PRIV_SERVICES) ? '' : 'd-none'; ?>
            <li class="has-submenu <?= $hidden ?>">
                <a href="#">
                    <i class='bx bx-briefcase'></i> <span>Services</span>
                    <i class='bx bx-chevron-down arrow'></i>
                </a>
                <ul class="submenu">
                    <li><a href="<?= site_url('services') ?>"><i class='bx bx-list-ul'></i> Services</a></li>
                    <li><a href="<?= site_url('service_categories') ?>"><i class='bx bx-category'></i> Categories</a></li>
                </ul>
            </li>

            <?php $hidden = can('view', PRIV_USERS) ? '' : 'd-none'; ?>
            <li class="has-submenu <?= $hidden ?>">
                <a href="#">
                    <i class='bx bx-user-pin'></i> <span>Users</span>
                    <i class='bx bx-chevron-down arrow'></i>
                </a>
                <ul class="submenu">
                    <li><a href="<?= site_url('providers') ?>"><i class='bx bx-user-plus'></i> Providers</a></li>
                    <li><a href="<?= site_url('secretaries') ?>"><i class='bx bx-group'></i> Secretaries</a></li>
                    <li><a href="<?= site_url('admins') ?>"><i class='bx bx-shield-alt-2'></i> Admins</a></li>
                </ul>
            </li>

            <li class="has-submenu">
                <a href="#">
                    <i class='bx bx-calendar'></i> <span>Appointments</span>
                    <i class='bx bx-chevron-down arrow'></i>
                </a>
                <ul class="submenu">
                    <li><a href="#"><i class='bx bx-right-arrow-alt'></i> Create New</a></li>
                    <li><a href="#"><i class='bx bx-right-arrow-alt'></i> List by Date</a></li>
                </ul>
            </li>

             <?php $hidden = can('view', PRIV_SYSTEM_SETTINGS) || can('view', PRIV_USER_SETTINGS) ? '' : 'd-none'; ?>
             <?php if (can('view', PRIV_SYSTEM_SETTINGS)): ?>
            <li class="has-submenu <?= $hidden ?>">
                <a href="#">
                    <i class='bx bx-cog'></i> <span>Settings</span>
                    <i class='bx bx-chevron-down arrow'></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="<?= site_url('general_settings') ?>">
                            <i class='bx bx-slider-alt'></i> <?= lang('general_settings') ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('booking_settings') ?>">
                            <i class='bx bx-calendar-edit'></i> <?= lang('booking_settings') ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('business_settings') ?>">
                            <i class='bx bx-briefcase-alt-2'></i> <?= lang('business_logic') ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('legal_settings') ?>">
                            <i class='bx bx-book-content'></i> <?= lang('legal_contents') ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('integrations') ?>">
                            <i class='bx bx-plug'></i> <?= lang('integrations') ?>
                        </a>
                    </li>
                </ul>
            </li>
            <?php endif;  ?>
        </ul>
    </div>
</aside>