<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>

<!-- FontAwesome & Google Fonts for Exact UI Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    * {
        box-sizing: border-box;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    body {
        background-color: #f4f5f7;
        margin: 0;
        padding: 0;
        color: #1e293b;
    }

    .appointment-diary-wrapper {
        display: flex;
        flex-direction: column;
        height: 100vh;
        background: #f8fafc;
        overflow: hidden;
    }

    /* Top Action Bar / Header (Desktop Default) */
    .diary-header {
        background: #ffffff;
        padding: 12px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-left .icon-box {
        background: #0052cc;
        color: white;
        padding: 8px 10px;
        border-radius: 8px;
        font-size: 16px;
    }

    .header-left h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
    }

    .date-navigator {
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
    }

    .nav-btn {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 6px 12px;
        cursor: pointer;
        font-size: 13px;
        color: #334155;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .nav-btn:hover {
        background: #f1f5f9;
    }

    .current-date-range {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        min-width: 220px;
        text-align: center;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-blue {
        background: #0052cc;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-blue:hover {
        background: #0043a8;
    }

    .btn-icon-only {
        background: white;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 8px 12px;
        cursor: pointer;
        color: #334155;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-icon-only:hover {
        background: #f1f5f9;
    }

    /* Status Legends Top Bar */
    .legend-bar {
        background: #ffffff;
        padding: 10px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 24px;
        font-size: 11px;
        font-weight: 500;
        color: #475569;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: thin;
    }

    .legend-bar::-webkit-scrollbar {
        height: 4px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Main Container (Sidebar + Content) */
    .diary-body {
        display: flex;
        flex: 1;
        overflow: hidden;
    }

    /* Sidebar Design */
    .diary-sidebar {
        width: 220px;
        background: #ffffff;
        border-right: 1px solid #e2e8f0;
        padding: 16px;
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        overflow-y: auto;
    }

    .mini-calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 700;
        font-size: 12px;
        margin-bottom: 8px;
    }

    .mini-cal-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
        text-align: center;
        font-size: 10px;
        margin-bottom: 16px;
    }

    .mini-cal-day-head {
        color: #94a3b8;
        font-weight: 600;
        padding: 2px 0;
    }

    .mini-cal-date {
        padding: 4px 0;
        border-radius: 50%;
        color: #334155;
        cursor: pointer;
    }

    .mini-cal-date.active {
        background: #0052cc;
        color: white;
        font-weight: 600;
    }

    .mini-cal-date.other-month {
        color: #cbd5e1;
    }

    .sidebar-section-title {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        margin-top: 12px;
        margin-bottom: 6px;
    }

    .view-toggle-group {
        background: #f1f5f9;
        border-radius: 8px;
        padding: 3px;
        display: flex;
        gap: 2px;
    }

    .view-toggle-btn {
        flex: 1;
        border: none;
        background: transparent;
        padding: 6px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .view-toggle-btn.active {
        background: #0052cc;
        color: white;
    }

    .staff-box {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        color: #334155;
    }

    .settings-btn {
        background: transparent;
        border: none;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        padding: 8px 0;
    }

    /* Main Grid Section */
    .diary-grid-container {
        flex: 1;
        overflow: auto;
        background: #ffffff;
    }

    .diary-table {
        width: 100%;
        min-width: 800px;
        border-collapse: separate;
        border-spacing: 0;
        table-layout: fixed;
    }

    .diary-table th {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        border-right: 1px solid #f1f5f9;
        padding: 8px;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 10;
        box-shadow: 0 1px 0 #e2e8f0;
    }

    .diary-table th:first-child {
        position: sticky;
        left: 0;
        z-index: 12;
        background: #ffffff;
        border-right: 1px solid #e2e8f0;
    }

    .th-day-name {
        font-size: 12px;
        font-weight: 700;
        color: #0f172a;
        text-transform: uppercase;
    }

    .th-day-date {
        font-size: 11px;
        color: #64748b;
        font-weight: 500;
        text-transform: uppercase;
    }

    .diary-table td {
        border-bottom: 1px solid #f1f5f9;
        border-right: 1px solid #f1f5f9;
        padding: 2px 4px;
        height: 28px;
        vertical-align: middle;
        font-size: 11px;
    }

    .time-cell {
        width: 75px;
        text-align: right;
        padding-right: 8px !important;
        font-weight: 700;
        font-size: 10px;
        color: #0f172a;
        background: #ffffff;
        position: sticky;
        left: 0;
        z-index: 5;
        border-right: 1px solid #e2e8f0 !important;
    }

    .slot-cell {
        cursor: pointer;
        transition: background-color 0.12s ease-in-out;
    }

    .slot-cell:hover {
        background-color: #f8fafc;
    }

    /* Appointment Cards Styling */
    .apt-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        margin: 1px 0;
        width: 100%;
        box-sizing: border-box;
    }

    .apt-confirmed {
        background: #f8fafc;
        color: #1e293b;
    }

    .apt-pending {
        background: #fefce8;
        color: #854d0e;
    }

    .apt-not-sent {
        background: #fef2f2;
        color: #991b1b;
    }

    .apt-left-info {
        display: flex;
        align-items: center;
        gap: 6px;
        overflow: hidden;
        white-space: nowrap;
    }

    .apt-name {
        font-weight: 500;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .apt-right-icons {
        display: flex;
        align-items: center;
        gap: 4px;
        flex-shrink: 0;
    }

    .blocked-slot {
        text-align: center;
        color: #94a3b8;
    }

    .holiday-col {
        background: #fafafa;
        text-align: center;
        vertical-align: middle !important;
    }

    .holiday-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #475569;
        height: 100%;
    }

    .holiday-icon {
        font-size: 28px;
        margin-bottom: 8px;
        color: #64748b;
    }

    .custom-toast {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: #1f1f23;
        color: #fff;
        padding: 18px 22px;
        border-radius: 16px;
        min-width: 420px;
        display: none;
        justify-content: space-between;
        align-items: center;
        z-index: 99999;
        font-size: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .25);
    }

    .custom-toast button {
        background: transparent;
        border: 0;
        color: #999;
        font-size: 20px;
        cursor: pointer;
    }

    .mobile-mini-cal-btn {
        display: none;
        /* Desktop par hidden */
    }

    /* ========================================================
       RESPONSIVE DESIGN FOR TABLET & MOBILE (<= 768px)
       ======================================================== */
    @media (max-width: 768px) {
        .diary-body {
            flex-direction: column;
        }

        .diary-sidebar {
            width: 100%;
            height: auto;
            border-right: none;
            border-bottom: 1px solid #e2e8f0;
            padding: 8px 16px;
            order: -1;
            flex-direction: row;
            flex-wrap: wrap;
            align-items: center;
            background: #ffffff;
        }

        /* Order Property Use - Controls First, Calendar Second on Mobile */
        .sidebar-controls-wrapper {
            display: flex;
            width: 100%;
            justify-content: space-between;
            align-items: center;
            order: 1;
            /* Always on top for mobile */
        }

        .mini-cal-wrapper {
            display: none;
            /* Default hidden */
            width: 100%;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
            order: 2;
            /* Drops below controls for mobile when visible */
        }

        .mini-cal-wrapper.mobile-visible {
            display: block;
            /* Shown via button click */
            animation: fadeIn 0.2s ease-in-out;
        }

        .sidebar-section-title {
            display: none;
        }

        .view-toggle-group {
            margin-bottom: 0;
            width: 160px;
        }

        .mobile-mini-cal-btn {
            display: flex;
            align-self: flex-end;
            margin-bottom: 1px;
            padding: 6px 10px;
        }

        .mobile-mini-cal-btn.active-btn {
            background: #0052cc;
            color: white;
            border-color: #0052cc;
        }

        .settings-btn {
            display: none;
        }

        .modal-dialog {
            max-width: 95% !important;
            margin: 10px auto;
        }

        .custom-toast {
            min-width: 90%;
            font-size: 14px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }



    }

    /* ========================================================
       RESPONSIVE DESIGN FOR MOBILE PHONES (<= 500px)
       ======================================================== */
    @media (max-width: 500px) {
        .diary-header {
            padding: 10px 12px;
            gap: 8px;
        }

        .header-left h4 {
            font-size: 15px;
            /* Slightly smaller title */
        }

        .date-navigator {
            gap: 4px;
            /* Reduced gap between navigation buttons */
            width: 100%;
            justify-content: center;
        }

        .current-date-range {
            font-size: 12px;
            /* Smaller text for the date string */
            min-width: auto;
            /* Remove the 220px min-width restriction */
            padding: 0 4px;
            white-space: nowrap;
            /* Prevent date from breaking into two lines */
        }

        .nav-btn {
            padding: 4px 8px;
            /* Compact padding for < > and Today buttons */
            font-size: 11px;
        }

        .btn-icon-only {
            padding: 5px 8px;
            /* Compact padding for calendar icon */
            font-size: 12px;
        }

        .header-right {
            width: 100%;
            justify-content: flex-start;
        }

        .btn-blue {
            padding: 6px 12px;
            font-size: 12px;
            /* width: 100%; */
            justify-content: center;
        }

        .legend-bar {
            padding: 8px 12px;
        }
    }
</style>

<div id="toast-message" class="custom-toast">
    <span id="toast-text"></span>
    <button type="button" onclick="hideToast()">
        <i class="fas fa-times"></i>
    </button>
</div>

<div class="appointment-diary-wrapper">
    <!-- Header -->
    <div class="diary-header">
        <div class="header-left">
            <div class="icon-box"><i class="fa-regular fa-calendar-days"></i></div>
            <h4>Appointment Diary</h4>
        </div>

        <div class="date-navigator">
            <button class="nav-btn" id="prev-btn"><i class="fa-solid fa-chevron-left"></i></button>
            <div class="current-date-range" id="date-range-display">Loading...</div>
            <button class="nav-btn" id="next-btn"><i class="fa-solid fa-chevron-right"></i></button>

            <!-- Dynamic Today Button -->
            <button class="nav-btn" id="today-btn">Today</button>

            <!-- Dynamic DatePicker Button -->
            <button class="btn-icon-only" id="datepicker-trigger-btn" title="Pick Date">
                <i class="fa-regular fa-calendar"></i>
            </button>
            <input type="date" id="calendar-date-picker" style="position: absolute; opacity: 0; pointer-events: none; width: 0; height: 0;">
        </div>

        <div class="header-right">
            <!-- Hidden button for auto-refresh handling -->
            <button id="reload-appointments" style="display: none;"></button>
            <a href="#" id="insert-appointment" style="display: none;"></a>
            <a href="#" id="insert-unavailability" style="display: none;"></a>

            <button class="btn-blue" id="new-appointment-btn"><i class="fa-solid fa-plus"></i> New Appointment</button>
        </div>
    </div>

    <!-- Legends Bar -->
    <div class="legend-bar">
        <div class="legend-item"><i class="fa-brands fa-whatsapp legend-icon" style="color: #22c55e;"></i> WhatsApp sent & Patient Confirmed</div>
        <div class="legend-item"><i class="fa-regular fa-clock legend-icon" style="color: #eab308;"></i> WhatsApp sent & Not yet responded</div>
        <div class="legend-item"><i class="fa-solid fa-circle-exclamation legend-icon" style="color: #ef4444;"></i> WhatsApp not sent</div>
        <div class="legend-item"><i class="fa-solid fa-ban legend-icon" style="color: #64748b;"></i> Blocked by office (Unavailable)</div>
        <div class="legend-item"><i class="fa-regular fa-square legend-icon" style="color: #cbd5e1;"></i> Vacant Slot (Available)</div>
        <div class="legend-item"><i class="fa-solid fa-star legend-icon" style="color: #f59e0b;"></i> Old booking > 2 weeks</div>
    </div>

    <!-- Main Body -->
    <div class="diary-body">
        <!-- Sidebar -->
        <div class="diary-sidebar">

            <!-- Mini Calendar (Now First on Desktop) -->
            <div class="mini-cal-wrapper">
                <div class="mini-calendar-header">
                    <span id="mini-cal-month-year">Month Year</span>
                    <div>
                        <i class="fa-solid fa-chevron-left" id="mini-prev-month" style="cursor:pointer; margin-right: 6px;"></i>
                        <i class="fa-solid fa-chevron-right" id="mini-next-month" style="cursor:pointer;"></i>
                    </div>
                </div>

                <div class="mini-cal-grid" id="mini-cal-days-grid"></div>
            </div>

            <!-- Sidebar Controls (Now Second on Desktop, but reordered to First on Mobile) -->
            <div class="sidebar-controls-wrapper">
                <!-- View Switcher (Week / Day) -->
                <div>
                    <div class="sidebar-section-title">View</div>
                    <div class="view-toggle-group">
                        <button class="view-toggle-btn active" id="view-week"><i class="fa-regular fa-calendar-days"></i> Week</button>
                        <button class="view-toggle-btn" id="view-day"><i class="fa-regular fa-calendar"></i> Day</button>
                    </div>
                </div>

                <!-- Mobile Mini Calendar Toggle Button -->
                <button type="button" class="btn-icon-only mobile-mini-cal-btn" id="toggle-mini-cal-btn" title="Toggle Calendar">
                    <i class="fa-regular fa-calendar-days"></i>
                </button>

                <!-- Staff Selector -->
                <div style="display: none;" class="desktop-only-staff">
                    <div class="sidebar-section-title">Staff (All)</div>
                    <div class="staff-box">All Staff</div>
                </div>
            </div>

        </div>

        <!-- Calendar Main Grid -->
        <div class="diary-grid-container">
            <table class="diary-table">
                <thead id="diary-thead"></thead>
                <tbody id="appointment-tbody"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Page Modal Components -->
<?php component('appointments_modal', [
    'available_services' => vars('available_services'),
    'appointment_status_options' => vars('appointment_status_options'),
    'timezones' => vars('timezones'),
    'require_first_name' => vars('require_first_name'),
    'require_last_name' => vars('require_last_name'),
    'require_email' => vars('require_email'),
    'require_phone_number' => vars('require_phone_number'),
    'require_address' => vars('require_address'),
    'require_city' => vars('require_city'),
    'require_zip_code' => vars('require_zip_code'),
    'require_notes' => vars('require_notes'),
]); ?>

<?php component('unavailabilities_modal', [
    'timezones' => vars('timezones'),
    'timezone' => vars('timezone'),
]); ?>

<?php component('working_plan_exceptions_modal'); ?>

<div class="modal fade" id="appointment-details-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 350px; margin: auto;">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 12px 35px rgba(0,0,0,0.12); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; overflow: hidden; background: #ffffff;">

            <!-- Modal Header -->
            <div class="modal-header" style="background: #ffffff; border: none; padding: 12px 16px 6px 16px; display: flex; align-items: center; justify-content: space-between;">
                <button type="button" class="btn" style="background: none; border: none; font-size: 15px; color: #1e293b; padding: 0; cursor: pointer; display: flex; align-items: center;">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <h5 class="modal-title" style="margin: 0; font-size: 14px; font-weight: 700; color: #0f172a; flex: 1; text-align: center;">Appointment Details</h5>

                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close" style="background: none; border: none; font-size: 16px; color: #475569; padding: 0; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="padding: 6px 16px 16px 16px;">

                <!-- Customer Avatar & Info -->
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <div style="width: 46px; height: 46px; background: #ede9fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #7c3aed; font-weight: 700; font-size: 15px; flex-shrink: 0;" class="customer-avatar">SM</div>
                    <div style="overflow: hidden; flex: 1;">
                        <h6 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" class="customer-name">Sophia Martin</h6>
                        <span style="display: inline-block; margin-top: 2px; padding: 2px 8px; background: #e6f4ea; color: #137333; border-radius: 10px; font-size: 10px; font-weight: 600;" class="appointment-status">Confirmed</span>
                    </div>
                </div>

                <!-- Date, Time & Location -->
                <div style="display: flex; flex-direction: column; gap: 6px; margin-bottom: 12px; background: #f8fafc; padding: 8px 10px; border-radius: 8px;">
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: #334155; font-weight: 500;">
                        <i class="fa-regular fa-calendar" style="color: #64748b; width: 14px; text-align: center;"></i>
                        <span class="appointment-date">Mon, 15 June 2026</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: #334155; font-weight: 500;">
                        <i class="fa-regular fa-clock" style="color: #64748b; width: 14px; text-align: center;"></i>
                        <span class="appointment-time">12:15 PM – 12:30 PM <span style="color: #94a3b8; font-weight: 400;">(15 min)</span></span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: #334155; font-weight: 500;">
                        <i class="fa-solid fa-location-dot" style="color: #64748b; width: 14px; text-align: center;"></i>
                        <span class="appointment-location">Main Clinic – Room 2</span>
                    </div>
                </div>

                <!-- Booking Info -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <span style="font-size: 12px; color: #0f172a; font-weight: 600;">Booked on</span>
                    <span style="font-size: 12px; color: #334155; font-weight: 500;" class="booked-on">13 June 2026, 09:15 AM</span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <span style="font-size: 12px; color: #0f172a; font-weight: 600;">Booked by</span>
                    <div style="text-align: right;" class="booked-by">
                        <span style="font-size: 12px; color: #334155; font-weight: 500;">Jane Smith </span>
                        <span style="font-size: 10px; color: #64748b;">(Receptionist)</span>
                    </div>
                </div>

                <!-- Call & WhatsApp Buttons -->
                <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                    <button type="button" class="btn" style="flex: 1; padding: 6px 10px; border: 1.5px solid #22c55e; background: white; color: #16a34a; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;">
                        <i class="fa-solid fa-phone" style="font-size: 11px;"></i> Call
                    </button>
                    <button type="button" class="btn btn-send-whatsapp" style="flex: 1; padding: 6px 10px; border: 1.5px solid #22c55e; background: white; color: #16a34a; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;">
                        <i class="fa-brands fa-whatsapp" style="font-size: 13px;"></i> WhatsApp
                    </button>
                </div>

                <!-- Message Section -->
                <div style="margin-bottom: 12px;">
                    <div style="font-size: 11px; color: #0f172a; font-weight: 700; margin-bottom: 4px;">
                        Message <span style="color: #94a3b8; font-weight: 400;">(Copy for WhatsApp)</span>
                    </div>
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 8px 10px; border-radius: 8px; display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                        <p style="margin: 0; font-size: 11px; color: #334155; line-height: 1.3; font-weight: 500;" class="message-text">
                            Your appointment with Dr Sahu is booked for 15 June 2026, 12:15 PM at Main Clinic – Room 2.
                        </p>
                        <button type="button" style="background: none; border: none; color: #2563eb; cursor: pointer; padding: 2px; font-size: 14px; flex-shrink: 0;">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </div>
                </div>

                <!-- WhatsApp Sent Switch -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                    <span style="font-size: 12px; color: #0f172a; font-weight: 600;">WhatsApp sent</span>
                    <div style="display: flex; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 2px;">
                        <span class="whatsapp-sent" style="padding: 2px 8px; background: #dcfce7; color: #15803d; border-radius: 4px; font-size: 10px; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                            Yes <i class="fa-solid fa-circle-check" style="font-size: 10px;"></i>
                        </span>
                    </div>
                </div>

                <!-- Confirmed Patient Switch -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="font-size: 12px; color: #0f172a; font-weight: 600;">Confirmed by patient</span>
                    <div style="display: flex; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 2px;">
                        <span class="confirmed-patient" style="padding: 2px 8px; background: #dcfce7; color: #15803d; border-radius: 4px; font-size: 10px; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                            Yes <i class="fa-solid fa-circle-check" style="font-size: 10px;"></i>
                        </span>
                    </div>
                </div>

                <!-- Appointment Type Selection -->
                <div style="display: flex; gap: 8px; margin-bottom: 14px;">
                    <!-- In Clinic -->
                    <div class="appointment-type-inclinic" style="flex: 1; border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px 8px; display: flex; align-items: center; justify-content: space-between; cursor: pointer;">
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <i class="fa-regular fa-calendar-check" style="color: #16a34a; font-size: 13px;"></i>
                            <div>
                                <div style="font-size: 10px; font-weight: 700; color: #0f172a;">In Clinic</div>
                                <div style="font-size: 8px; color: #64748b;">Face to face</div>
                            </div>
                        </div>
                        <div style="width: 12px; height: 12px; border: 1.5px solid #cbd5e1; border-radius: 50%;" class="type-indicator"></div>
                    </div>

                    <!-- Video Consultation -->
                    <div class="appointment-type-video" style="flex: 1; border: 1px solid #e2e8f0; background: #ffffff; border-radius: 8px; padding: 6px 8px; display: flex; align-items: center; justify-content: space-between; cursor: pointer;">
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-video" style="color: #9333ea; font-size: 12px;"></i>
                            <div>
                                <div style="font-size: 10px; font-weight: 700; color: #0f172a;">Video Call</div>
                                <div style="font-size: 8px; color: #64748b;" class="type-subtext">Online video</div>
                            </div>
                        </div>
                        <div style="width: 12px; height: 12px; border: 1.5px solid #cbd5e1; border-radius: 50%;" class="type-indicator"></div>
                    </div>
                </div>

                <!-- Bottom Action Buttons -->
                <div id="modal-action-buttons" style="display: flex; gap: 6px;">
                    <input type="hidden" id="cancelid" name="cancelid" value="">

                    <!-- Dropdown for Cancel, Check In, Check Out -->
                    <div class="dropdown" style="flex: 1;">
                        <button class="btn dropdown-toggle w-100" type="button" id="appointmentActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 7px 0; border: 1px solid #cbd5e1; background: #ffffff; color: #334155; border-radius: 6px; font-weight: 700; font-size: 11px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 4px;">
                            Actions
                        </button>
                        <ul class="dropdown-menu shadow-sm" aria-labelledby="appointmentActionsDropdown" style="font-size: 11px; min-width: 110px;">
                            <li><a class="dropdown-item text-success fw-bold action-check-status" href="#" data-check-type="1" style="padding: 4px 10px;"><i class="fa-solid fa-circle-check me-1"></i> Check In</a></li>
                            <li><a class="dropdown-item text-primary fw-bold action-check-status" href="#" data-check-type="0" style="padding: 4px 10px;"><i class="fa-solid fa-circle-right me-1"></i> Check Out</a></li>
                            <li>
                                <hr class="dropdown-divider my-1">
                            </li>
                            <li><a class="dropdown-item text-danger fw-bold action-cancel" href="#" style="padding: 4px 10px;" id="cancelbutton"><i class="fa-regular fa-calendar-xmark me-1"></i> Cancel</a></li>
                        </ul>
                    </div>

                    <button
                        type="button"
                        class="btn btn-reschedule-appointment"
                        data-appointment=""
                        style="flex: 1.2; padding: 7px 0; border: 1px solid #93c5fd; background: #ffffff; color: #2563eb; border-radius: 6px; font-weight: 700; font-size: 11px;">
                        <i class="fa-regular fa-calendar-days"></i> Reschedule
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade modal-delete" id="deleteAppointmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure that you want to delete this record? This action cannot be undone.
            </div>
            <div class="modal-footer border-0">
                <input type="hidden" id="delete-appointment-id" value="">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-confirm-delete" id="btn-confirm-delete-action">Delete</button>
            </div>
        </div>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>
<script src="<?= asset_url('assets/vendor/fullcalendar/index.global.min.js') ?>"></script>
<script src="<?= asset_url('assets/vendor/fullcalendar-moment/index.global.min.js') ?>"></script>
<script src="<?= asset_url('assets/vendor/jquery-jeditable/jquery.jeditable.min.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/ui.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/calendar_default_view.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/calendar_table_view.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/calendar_event_popover.js') ?>"></script>
<script src="<?= asset_url('assets/js/http/calendar_http_client.js') ?>"></script>
<script src="<?= asset_url('assets/js/http/customers_http_client.js') ?>"></script>
<?php if (vars('calendar_view') === CALENDAR_VIEW_DEFAULT): ?>
    <script src="<?= asset_url('assets/js/utils/calendar_sync.js') ?>"></script>
    <script src="<?= asset_url('assets/js/http/google_http_client.js') ?>"></script>
    <script src="<?= asset_url('assets/js/http/caldav_http_client.js') ?>"></script>
<?php endif; ?>
<script src="<?= asset_url('assets/js/pages/calendar.js') ?>"></script>

<script>
    function showToast(message) {
        $('#toast-text').text(message);
        $('#toast-message').fadeIn(200);
        setTimeout(function() {
            $('#toast-message').fadeOut(200);
        }, 6000);
    }

    function hideToast() {
        $('#toast-message').fadeOut(200);
    }

    $(document).ready(function() {
        // Toggle Mini Calendar on Mobile
        $('#toggle-mini-cal-btn').on('click', function() {
            $('.mini-cal-wrapper').toggleClass('mobile-visible');
            $(this).toggleClass('active-btn');
        });

        // Auto-refresh trigger listener
        $('#reload-appointments').on('click', function() {
            refreshCalendar();
        });

        $(document).on('click', '.btn-reschedule-appointment', function() {
            let appointment = JSON.parse($(this).attr('data-appointment'));
            const customerName = [appointment.customer?.first_name, appointment.customer?.last_name].filter(Boolean).join(' ') || 'Customer';
            const providerName = [appointment.provider?.first_name, appointment.provider?.last_name].filter(Boolean).join(' ') || 'Doctor';
            const startDate = new Date(appointment.start_datetime.replace(' ', 'T'));

            const formattedStartDate = startDate.toLocaleDateString('en-US', {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
            const formattedStartTime = startDate.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });

            App.Components.AppointmentsModal.resetModal();

            $('#appointment-id').val(appointment.id);
            $('#appointment-status').val(appointment.status);
            $('#appointment-location').val(appointment.location);
            $('#appointment-meeting-link').val(appointment.meeting_link);
            $('#appointment-notes').val(appointment.notes);

            const appointmentType = appointment.appointment_type || 'in_clinic';
            $('#appointment-type').val(appointmentType);

            const serviceId = appointment.id_services || appointment.service?.id || '';
            const providerId = appointment.id_users_provider || appointment.provider?.id || '';
            const $serviceSelect = $('#select-service');
            const $providerSelect = $('#select-provider');

            $serviceSelect.val(serviceId);
            $providerSelect.empty();

            vars('available_providers').forEach((provider) => {
                const canProvideService = provider.services.some((providerServiceId) => Number(providerServiceId) === Number(serviceId));
                const canAccessProvider =
                    vars('role_slug') !== App.Layouts.Backend.DB_SLUG_PROVIDER &&
                    vars('role_slug') !== App.Layouts.Backend.DB_SLUG_SECRETARY ?
                    true :
                    vars('role_slug') === App.Layouts.Backend.DB_SLUG_PROVIDER ?
                    Number(provider.id) === Number(vars('user_id')) :
                    (vars('secretary_providers') || []).includes(Number(provider.id));

                if (canProvideService && canAccessProvider) {
                    $providerSelect.append(new Option([provider.first_name, provider.last_name].filter(Boolean).join(' ') || 'Provider', provider.id));
                }
            });

            if (providerId && $providerSelect.find(`option[value="${providerId}"]`).length) {
                $providerSelect.val(providerId);
            } else if ($providerSelect.find('option').length) {
                $providerSelect.val($providerSelect.find('option').first().val());
            }

            const startDateTime = new Date(appointment.start_datetime.replace(' ', 'T'));
            const endDateTime = new Date(appointment.end_datetime.replace(' ', 'T'));

            App.Utils.UI.setDateTimePickerValue($('#start-datetime'), startDateTime);
            App.Utils.UI.setDateTimePickerValue($('#end-datetime'), endDateTime);

            $('#customer-id').val(appointment.customer?.id);
            $('#first-name').val(appointment.customer?.first_name);
            $('#last-name').val(appointment.customer?.last_name);
            $('#email').val(appointment.customer?.email);
            $('#phone-number').val(appointment.customer?.phone_number);
            $('#address').val(appointment.customer?.address);
            $('#city').val(appointment.customer?.city);
            $('#zip-code').val(appointment.customer?.zip_code);
            $('#timezone').val(appointment.customer?.timezone);
            $('#language').val(appointment.customer?.language);
            $('#customer-notes').val(appointment.customer?.notes);

            $('#appointments-modal').find('.btn-send-whatsapp').data({
                id: appointment.id,
                customer_name: customerName,
                doctor_name: providerName,
                phone: appointment.customer?.phone_number,
                fee: appointment.service?.price || '0',
                date: formattedStartDate,
                time: formattedStartTime
            });

            const modal = new bootstrap.Modal(document.getElementById('appointments-modal'));
            modal.show();
            $('#appointment-details-modal').modal('hide');
        });

        $(document).on('click', '#cancelbutton', function() {
            const appointmentId = $('#cancelid').val();
            if (appointmentId) {
                $('#delete-appointment-id').val(appointmentId);
                $('#appointment-details-modal').modal('hide');
                $('#deleteAppointmentModal').modal('show');
            } else {
                alert("Appointment ID nahi mili!");
            }
        });

        $("#btn-confirm-delete-action").on("click", function() {
            const appointmentId = $("#delete-appointment-id").val();
            if (!appointmentId) {
                alert("Appointment ID nahi mili!");
                return;
            }

            $.ajax({
                url: "<?= site_url('calendar/delete_appointment') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    appointment_id: appointmentId,
                    cancellation_reason: "noting",
                    notify_users: true,
                    csrf_token: vars('csrf_token')
                },
                beforeSend: function() {
                    $("#btn-confirm-delete-action").prop("disabled", true).text("Deleting...");
                },
                success: function(response) {
                    $("#btn-confirm-delete-action").prop("disabled", false).text("Delete");
                    if (response.success) {
                        $("#deleteAppointmentModal").modal("hide");
                        showToast("Appointment deleted successfully.");
                        refreshCalendar();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    $("#btn-confirm-delete-action").prop("disabled", false).text("Delete");
                    alert("Something went wrong.");
                }
            });
        });

        $(document).on('click', '.btn-send-whatsapp', function() {
            let $btn = $(this);
            let btnData = $btn.data();

            if (!btnData.phone) {
                alert("Customer phone number missing!");
                return;
            }

            $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Sending...');

            $.ajax({
                url: 'whatsapp/send',
                type: 'POST',
                data: {
                    ...btnData,
                    csrf_token: vars('csrf_token')
                },
                dataType: 'json',
                success: function(res) {
                    $btn.prop('disabled', false).html('<i class="fa-brands fa-whatsapp"></i> WhatsApp');
                    if (res.status) {
                        $("#appointment-details-modal").modal("hide");
                        showToast('WhatsApp Sent Successfully');
                    } else {
                        alert("Failed: " + (res.message || "Something went wrong"));
                    }
                },
                error: function(xhr, status, error) {
                    $btn.prop('disabled', false).html('<i class="fa-brands fa-whatsapp"></i> WhatsApp');
                    alert("Server connection error.");
                }
            });
        });

        // Common Click Handler for both Check In and Check Out
        $(document).on('click', '.action-check-status', function(e) {
            e.preventDefault();

            const appointmentId = $('#cancelid').val();
            const checkType = $(this).data('check-type');
            const successMsg = checkType === 1 ? "Checked in successfully." : "Checked out successfully.";

            if (!appointmentId) {
                alert("Appointment ID nahi mili!");
                return;
            }

            $.ajax({
                url: "<?= site_url('anshul/update_check_status') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    appointment_id: appointmentId,
                    check_type: checkType,
                    csrf_token: vars('csrf_token')
                },
                success: function(response) {
                    if (response.success) {
                        $('#appointment-details-modal').modal('hide');
                        showToast(successMsg);
                        refreshCalendar();
                    } else {
                        alert(response.message || "Something went wrong.");
                    }
                },
                error: function() {
                    alert("Server connection error.");
                }
            });
        });
    });

    window.refreshCalendar = function() {
        if (typeof loadCalendarData === 'function' && typeof renderCalendar === 'function') {
            loadCalendarData().done(renderCalendar);
        }
    };
</script>

<script>
    $(function() {
        let currentView = 'week';
        let selectedDate = new Date();
        let appointmentsData = [];
        let unavailabilitiesData = [];
        let blockedPeriodsData = [];

        let workingPlan = {};
        try {
            workingPlan = JSON.parse(vars('company_working_plan') || '{}');
        } catch (e) {
            console.error("Invalid working plan JSON", e);
        }

        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const shortMonthNames = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
        const dayKeysMap = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
        const dayNamesShort = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];

        function getCalendarDateRange() {
            const startDate = currentView === 'week' ? getMonday(selectedDate) : new Date(selectedDate);
            const endDate = new Date(startDate);
            if (currentView === 'week') {
                endDate.setDate(startDate.getDate() + 6);
            }
            return {
                startDate,
                endDate
            };
        }

        window.loadCalendarData = function() {
            const {
                startDate,
                endDate
            } = getCalendarDateRange();
            return App.Http.Calendar.getCalendarAppointmentsForTableView(startDate, endDate).done((response) => {
                appointmentsData = response.appointments || [];
                unavailabilitiesData = response.unavailabilities || [];
                blockedPeriodsData = response.blocked_periods || [];
            });
        }

        function getMonday(d) {
            const date = new Date(d);
            const day = date.getDay();
            const firstDaySetting = vars('first_weekday') || 'sunday';
            const offset = firstDaySetting === 'sunday' ? (day === 0 ? 0 : -day) : (day === 0 ? -6 : 1 - day);
            date.setDate(date.getDate() + offset);
            return date;
        }

        function getWeekDays(startDate) {
            const monday = new Date(startDate);
            let weekDays = [];
            for (let i = 0; i < 7; i++) {
                let day = new Date(monday);
                day.setDate(monday.getDate() + i);
                weekDays.push({
                    dateObj: day,
                    dayKey: dayKeysMap[day.getDay()],
                    dayIndex: day.getDay(),
                    name: dayNamesShort[day.getDay()],
                    dateStr: `${shortMonthNames[day.getMonth()]} ${day.getDate()}`
                });
            }
            return weekDays;
        }

        function generateSlotsWithBreaks(dayKey) {
            let slotList = [];
            let dayPlan = workingPlan[dayKey];
            if (!dayPlan) return slotList;

            let [startHour, startMin] = dayPlan.start.split(':').map(Number);
            let [endHour, endMin] = dayPlan.end.split(':').map(Number);

            let currentMinutes = startHour * 60 + startMin;
            let endMinutes = endHour * 60 + endMin;
            let breaks = dayPlan.breaks || [];

            while (currentMinutes < endMinutes) {
                let h = Math.floor(currentMinutes / 60);
                let m = currentMinutes % 60;

                let isBreak = breaks.some(b => {
                    let [bStartH, bStartM] = b.start.split(':').map(Number);
                    let [bEndH, bEndM] = b.end.split(':').map(Number);
                    return currentMinutes >= (bStartH * 60 + bStartM) && currentMinutes < (bEndH * 60 + bEndM);
                });

                let period = h >= 12 ? 'PM' : 'AM';
                let displayHour = h % 12 || 12;
                let displayMin = String(m).padStart(2, '0');
                let timeStr = `${displayHour}:${displayMin} ${period}`;

                slotList.push({
                    time: timeStr,
                    isBreak: isBreak
                });

                currentMinutes += 15;
            }
            return slotList;
        }

        function formatTimeSlotTo24(timeSlot) {
            const [time, period] = timeSlot.split(' ');
            let [hour, minutes] = time.split(':').map(Number);
            if (period === 'PM' && hour !== 12) hour += 12;
            if (period === 'AM' && hour === 12) hour = 0;
            return `${String(hour).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
        }

        function findAppointmentAt(date, time) {
            const slotTime = formatTimeSlotTo24(time);
            return appointmentsData.find((appointment) => appointment.start_datetime.indexOf(`${date} ${slotTime}`) === 0);
        }

        function findUnavailabilityAt(date, time) {
            const slotStart = new Date(`${date}T${formatTimeSlotTo24(time)}:00`);
            return unavailabilitiesData.find((unavailability) => {
                const start = new Date(unavailability.start_datetime.replace(' ', 'T'));
                const end = new Date(unavailability.end_datetime.replace(' ', 'T'));
                return slotStart >= start && slotStart < end;
            });
        }

        function findBlockedPeriodAt(date, time) {
            const slotStart = new Date(`${date}T${formatTimeSlotTo24(time)}:00`);
            return blockedPeriodsData.find((blocked) => {
                const start = new Date(blocked.start_datetime.replace(' ', 'T'));
                const end = new Date(blocked.end_datetime.replace(' ', 'T'));
                return slotStart >= start && slotStart < end;
            });
        }

        function getAppointmentById(appointmentId) {
            return appointmentsData.find((appointment) => Number(appointment.id) === Number(appointmentId));
        }

        function showAppointmentDetails(appointment) {
            const customerName = [appointment.customer.first_name, appointment.customer.last_name].filter(Boolean).join(' ') || '-';
            const customerInitials = ((appointment.customer.first_name?.[0] || '') + (appointment.customer.last_name?.[0] || '')).toUpperCase() || 'AP';

            const providerName = [appointment.provider.first_name, appointment.provider.last_name].filter(Boolean).join(' ') || '-';
            const location = appointment.location || '-';
            const status = appointment.status || 'pending';

            const appointmentType = appointment.appointment_type || 'in_clinic';

            const startDate = new Date(appointment.start_datetime.replace(' ', 'T'));
            const endDate = new Date(appointment.end_datetime.replace(' ', 'T'));
            const duration = Math.round((endDate - startDate) / 60000);

            const today = new Date();
            today.setHours(0, 0, 0, 0); // Set time to midnight for accurate date comparison

            const aptDate = new Date(startDate);
            aptDate.setHours(0, 0, 0, 0); // Set time to midnight

            if (aptDate < today || appointment.check_type === "0") {
                $('#modal-action-buttons').hide();
            } else {
                $('#modal-action-buttons').show();
            }



            const formattedStartDate = startDate.toLocaleDateString('en-US', {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
            const formattedStartTime = startDate.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });
            const formattedEndTime = endDate.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });

            const bookedOn = new Date(appointment.created_at || new Date()).toLocaleString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });

            const $modal = $('#appointment-details-modal');

            $modal.find('.customer-avatar').text(customerInitials);
            $modal.find('.customer-name').text(customerName);
            $modal.find('#cancelid').val(appointment.id);
            $modal.find('.btn-send-whatsapp').data({
                id: appointment.id,
                customer_name: customerName,
                doctor_name: providerName,
                phone: appointment.customer.phone_number,
                fee: appointment.service.price,
                date: formattedStartDate,
                time: formattedStartTime
            });

            $modal.find('.appointment-status').text(status.charAt(0).toUpperCase() + status.slice(1));
            $modal.find('.appointment-date').text(formattedStartDate);
            $modal.find('.appointment-time').html(`${formattedStartTime} - ${formattedEndTime} <span style="color: #94a3b8;">(${duration} min)</span>`);
            $modal.find('.appointment-location').text(location);
            $modal.find('.booked-on').text(bookedOn);
            $modal.find('.booked-by').html(`${providerName}<br><span style="font-size: 12px; color: #64748b;">(Provider)</span>`);
            $modal.find('.message-text').text(`Your appointment with ${providerName} is booked for ${formattedStartDate}, ${formattedStartTime} at ${location}.`);

            const whatsappSent = appointment.is_notification_sent ? 'Yes' : 'No';
            $modal.find('.whatsapp-sent').html(`<i class="fa-solid fa-check"></i> ${whatsappSent}`);

            const confirmedPatient = appointment.status === 'confirmed' ? 'Yes' : 'No';
            $modal.find('.confirmed-patient').html(`<i class="fa-solid fa-check"></i> ${confirmedPatient}`);

            const $inClinicOption = $modal.find('.appointment-type-inclinic');
            const $videoOption = $modal.find('.appointment-type-video');

            if (appointmentType === 'video' || appointmentType === 'video_call') {
                $videoOption.css({
                    'border': '1px solid #c084fc',
                    'background': '#faf5ff'
                });
                $videoOption.find('.type-subtext').text('Online video');
                $videoOption.find('.type-indicator').replaceWith('<i class="fa-solid fa-circle-check type-indicator" style="color: #7e22ce; font-size: 12px;"></i>');

                $inClinicOption.css({
                    'border': '1px solid #e2e8f0',
                    'background': '#ffffff'
                });
                $inClinicOption.find('.type-indicator').replaceWith('<div style="width: 12px; height: 12px; border: 1.5px solid #cbd5e1; border-radius: 50%;" class="type-indicator"></div>');
            } else {
                $inClinicOption.css({
                    'border': '1px solid #16a34a',
                    'background': '#f0fdf4'
                });
                $inClinicOption.find('.type-indicator').replaceWith('<i class="fa-solid fa-circle-check type-indicator" style="color: #16a34a; font-size: 12px;"></i>');

                $videoOption.css({
                    'border': '1px solid #e2e8f0',
                    'background': '#ffffff'
                });
                $videoOption.find('.type-indicator').replaceWith('<div style="width: 12px; height: 12px; border: 1.5px solid #cbd5e1; border-radius: 50%;" class="type-indicator"></div>');
            }

            const modal = new bootstrap.Modal(document.getElementById('appointment-details-modal'));
            modal.show();
            $('.btn-reschedule-appointment').attr('data-appointment', JSON.stringify(appointment));
        }

        function openNewAppointmentModal(startDateTime) {
            App.Components.AppointmentsModal.resetModal();
            $('#appointment-id').val('');

            const $appointmentsModal = $('#appointments-modal');
            const $startDateTime = $appointmentsModal.find('#start-datetime');
            const $endDateTime = $appointmentsModal.find('#end-datetime');
            const $selectService = $appointmentsModal.find('#select-service');
            const $selectProvider = $appointmentsModal.find('#select-provider');

            if ($selectService.find('option').length) {
                $selectService.val($selectService.find('option').first().val()).trigger('change');
            }

            if ($selectProvider.find('option').length) {
                $selectProvider.val($selectProvider.find('option').first().val()).trigger('change');
            }

            App.Utils.UI.setDateTimePickerValue($startDateTime, startDateTime);

            const serviceId = $selectService.val();
            const service = vars('available_services').find((s) => Number(s.id) === Number(serviceId));
            const duration = service && Number.isFinite(Number(service.duration)) ? Number(service.duration) : 30;
            const endDateTime = new Date(startDateTime.getTime() + duration * 60000);
            App.Utils.UI.setDateTimePickerValue($endDateTime, endDateTime);

            $appointmentsModal.find('.modal-header h3').text(lang('new_appointment_title'));
            $appointmentsModal.modal('show');
        }

        function openNewUnavailabilityModal(startDateTime) {
            App.Components.UnavailabilitiesModal.resetModal();
            const $unavailabilitiesModal = $('#unavailabilities-modal');
            const $startDateTime = $unavailabilitiesModal.find('#unavailability-start');
            const $endDateTime = $unavailabilitiesModal.find('#unavailability-end');

            App.Utils.UI.setDateTimePickerValue($startDateTime, startDateTime);
            App.Utils.UI.setDateTimePickerValue($endDateTime, new Date(startDateTime.getTime() + 15 * 60000));

            $unavailabilitiesModal.find('.modal-header h3').text(lang('new_unavailability_title'));
            $unavailabilitiesModal.modal('show');
        }

        function showAddNewEventDialog(startDateTime) {
            const buttons = [{
                    text: lang('unavailability'),
                    click: (event, messageModal) => {
                        openNewUnavailabilityModal(startDateTime);
                        messageModal.hide();
                    },
                },
                {
                    text: lang('appointment'),
                    click: (event, messageModal) => {
                        openNewAppointmentModal(startDateTime);
                        messageModal.hide();
                    },
                },
            ];
            App.Utils.Message.show(lang('add_new_event'), lang('what_kind_of_event'), buttons);
        }

        function renderMiniCalendar() {
            const year = selectedDate.getFullYear();
            const month = selectedDate.getMonth();
            $('#mini-cal-month-year').text(`${monthNames[month]} ${year}`);
            const grid = $('#mini-cal-days-grid').empty();

            ['S', 'M', 'T', 'W', 'T', 'F', 'S'].forEach(h => grid.append(`<div class="mini-cal-day-head">${h}</div>`));

            const firstDayIndex = new Date(year, month, 1).getDay();
            const totalDays = new Date(year, month + 1, 0).getDate();
            const prevMonthLastDate = new Date(year, month, 0).getDate();

            for (let x = firstDayIndex; x > 0; x--) {
                grid.append(`<div class="mini-cal-date other-month">${prevMonthLastDate - x + 1}</div>`);
            }
            for (let i = 1; i <= totalDays; i++) {
                const isToday = i === selectedDate.getDate() && month === selectedDate.getMonth() && year === selectedDate.getFullYear();
                grid.append(`<div class="mini-cal-date ${isToday ? 'active' : ''}" data-day="${i}">${i}</div>`);
            }
        }

        window.renderCalendar = function() {
            const thead = $('#diary-thead').empty();
            const tbody = $('#appointment-tbody').empty();
            renderMiniCalendar();

            if (currentView === 'week') {
                const weekDays = getWeekDays(selectedDate);
                const startDay = weekDays[0].dateObj;
                const endDay = weekDays[6].dateObj;

                $('#date-range-display').text(`${monthNames[startDay.getMonth()]} ${startDay.getDate()} – ${monthNames[endDay.getMonth()]} ${endDay.getDate()}, ${endDay.getFullYear()}`);

                let headRow = `<tr><th style="width: 75px;">TIME</th>`;
                weekDays.forEach((d) => {
                    headRow += `<th><div class="th-day-name">${d.name}</div><div class="th-day-date">${d.dateStr}</div></th>`;
                });
                headRow += `</tr>`;
                thead.append(headRow);

                let allSlotsMap = new Map();
                weekDays.forEach(d => {
                    generateSlotsWithBreaks(d.dayKey).forEach(slotObj => {
                        allSlotsMap.set(slotObj.time, true);
                    });
                });
                let uniqueTimeSlots = Array.from(allSlotsMap.keys());

                uniqueTimeSlots.forEach((time, index) => {
                    let row = `<tr><td class="time-cell">${time}</td>`;
                    weekDays.forEach((d) => {
                        const dateAttr = `${d.dateObj.getFullYear()}-${String(d.dateObj.getMonth() + 1).padStart(2, '0')}-${String(d.dateObj.getDate()).padStart(2, '0')}`;

                        if (!workingPlan[d.dayKey]) {
                            if (index === 0) {
                                row += `<td rowspan="${uniqueTimeSlots.length}" class="holiday-col">
                                    <div class="holiday-content">
                                        <i class="fa-regular fa-calendar-xmark holiday-icon"></i>
                                        <div style="font-weight: 700; font-size: 14px;">Holiday</div>
                                        <div style="font-size: 11px; color: #94a3b8;">Office Closed</div>
                                    </div>
                                </td>`;
                            }
                            return;
                        }

                        let daySlots = generateSlotsWithBreaks(d.dayKey);
                        let currentSlot = daySlots.find(s => s.time === time);

                        if (!currentSlot) {
                            row += `<td style="background: #f1f5f9;"></td>`;
                            return;
                        }

                        if (currentSlot.isBreak) {
                            row += `<td class="break-slot" style="background-color: rgb(190, 190, 190); color: #000;">
                            <i class="fa-solid fa-ban"></i>
                             Unavailable
                             </td>`;
                            return;
                        }

                        const appointment = findAppointmentAt(dateAttr, time);
                        const unavailability = appointment ? null : findUnavailabilityAt(dateAttr, time);
                        const blockedPeriod = appointment || unavailability ? null : findBlockedPeriodAt(dateAttr, time);

                        if (unavailability || blockedPeriod) {
                            row += `<td class="blocked-slot" data-date="${dateAttr}" data-slot="${time}" style="background-color: rgb(190, 190, 190); color: #000;">
                                <i class="fa-solid fa-ban"></i> Unavailable
                            </td>`;
                        } else if (appointment) {
                            row += `<td class="slot-cell" data-date="${dateAttr}" data-slot="${time}" data-appointment-id="${appointment.id}">${createCardHtml(appointment)}</td>`;
                        } else {
                            row += `<td class="slot-cell" data-date="${dateAttr}" data-slot="${time}" style="cursor: pointer;"></td>`;
                        }
                    });
                    row += `</tr>`;
                    tbody.append(row);
                });

            } else if (currentView === 'day') {
                const dayKey = dayKeysMap[selectedDate.getDay()];
                const dateAttr = `${selectedDate.getFullYear()}-${String(selectedDate.getMonth() + 1).padStart(2, '0')}-${String(selectedDate.getDate()).padStart(2, '0')}`;
                $('#date-range-display').text(`${monthNames[selectedDate.getMonth()]} ${selectedDate.getDate()}, ${selectedDate.getFullYear()}`);

                thead.append(`<tr><th style="width: 80px;">TIME</th><th><div class="th-day-name">${dayNamesShort[selectedDate.getDay()]}</div><div class="th-day-date">${shortMonthNames[selectedDate.getMonth()]} ${selectedDate.getDate()}</div></th></tr>`);

                let daySlots = generateSlotsWithBreaks(dayKey);
                if (daySlots.length === 0) {
                    tbody.append(`<tr><td colspan="2" class="holiday-col" style="height: 400px;">
                        <div class="holiday-content">
                            <i class="fa-regular fa-calendar-xmark holiday-icon"></i>
                            <div style="font-weight: 700; font-size: 14px;">Holiday</div>
                            <div style="font-size: 11px; color: #94a3b8;">Office Closed</div>
                        </div>
                    </td></tr>`);
                    return;
                }

                daySlots.forEach((slotObj) => {
                    let row = `<tr><td class="time-cell">${slotObj.time}</td>`;

                    if (slotObj.isBreak) {
                        row += `<td class="break-slot" style="background-color: rgb(190, 190, 190); color: #000;">
                          <i class="fa-solid fa-ban"></i>
                             Unavailable
                        </td>`;
                    } else {
                        const appointment = findAppointmentAt(dateAttr, slotObj.time);
                        const unavailability = appointment ? null : findUnavailabilityAt(dateAttr, slotObj.time);
                        const blockedPeriod = appointment || unavailability ? null : findBlockedPeriodAt(dateAttr, slotObj.time);

                        if (unavailability || blockedPeriod) {
                            row += `<td class="blocked-slot" data-date="${dateAttr}" data-slot="${slotObj.time}"><i class="fa-solid fa-ban"></i> Blocked Slot</td>`;
                        } else if (appointment) {
                            row += `<td class="slot-cell" data-date="${dateAttr}" data-slot="${slotObj.time}" data-appointment-id="${appointment.id}">${createCardHtml(appointment)}</td>`;
                        } else {
                            row += `<td class="slot-cell" data-date="${dateAttr}" data-slot="${slotObj.time}" style="cursor: pointer;"></td>`;
                        }
                    }
                    row += `</tr>`;
                    tbody.append(row);
                });
            }
        }

        function createCardHtml(data) {
            let bgClass = 'apt-confirmed';
            let icon = '';
            let customStyle = '';
            if (Number(data.is_whatsapp_sent) === 1) {
                icon = `<i class="fa-brands fa-whatsapp" style="color: #22c55e;" title="WhatsApp Sent"></i>`;
            } else {
                icon = `<i class="fa-solid fa-circle-exclamation" style="color: #ef4444;" title="WhatsApp Not Sent"></i>`;
                customStyle = 'background-color: #fef2f2 !important; border: 1px solid #fee2e2; color: #991b1b;';
            }

            // --- NEW LOGIC: Highlight card based on Check In (1) or Check Out (0) ---
            // if (data.check_type !== null && data.check_type !== undefined && data.check_type !== "") {
            //     if (Number(data.check_type) === 1) {
            //         // Checked In - Green
            //         customStyle = 'background-color: #dcfce7 !important; border: 1px solid #22c55e; color: #166534;';
            //     } else if (Number(data.check_type) === 0) {
            //         // Checked Out - Red
            //         customStyle = 'background-color: #fee2e2 !important; border: 1px solid #ef4444; color: #991b1b;';
            //     }
            // }

            const customerName = [
                data.customer?.first_name,
                data.customer?.last_name,
                data.customer_name,
                data.first_name,
                data.last_name,
            ].filter(Boolean).join(' ') || lang('appointment');

            if (data.status === 'pending') {
                bgClass = 'apt-pending';
                icon = `<i class="fa-regular fa-clock" style="color: #eab308;"></i>`;
            } else if (data.status === 'not-sent') {
                bgClass = 'apt-not-sent';
                icon = `<i class="fa-solid fa-circle-exclamation" style="color: #ef4444;"></i>`;
            }

            // --- Appointment Type Icon Handler ---
            const aptType = data.appointment_type || 'in-clinic';
            let typeIcon = '';
            if (aptType === 'video' || aptType === 'video_call') {
                typeIcon = `<i class="fa-solid fa-video" style="color: #9333ea; font-size: 11px;" title="Video Call"></i>`;
            } else {
                typeIcon = `<i class="fa-regular fa-calendar-check" style="color: #16a34a; font-size: 11px;" title="In Clinic"></i>`;
            }

            // --- NEW LOGIC: Add matching Icons for Check In/Out ---
            let rightIcons = '';
            if (data.check_type !== null && data.check_type !== undefined && data.check_type !== "") {
                if (Number(data.check_type) === 1) {
                    rightIcons += `<i class="fa-solid fa-circle-check" style="color: #16a34a; font-size: 11px;" title="Checked In"></i> `;
                } else if (Number(data.check_type) === 0) {
                    rightIcons += `<i class="fa-solid fa-circle-right" style="color: #ef4444; font-size: 11px;" title="Checked Out"></i> `;
                }
            }

            rightIcons += typeIcon;

            if (data.meeting_link && aptType !== 'video' && aptType !== 'video_call') {
                rightIcons += `<i class="fa-solid fa-video" style="color: #6366f1; font-size: 11px;" title="Meeting Link"></i>`;
            }
            if (data.star) rightIcons += `<i class="fa-solid fa-star" style="color: #f59e0b; font-size: 11px;" title="Old Booking"></i>`;
            if (data.blocked) rightIcons += `<i class="fa-solid fa-circle-minus" style="color: #ef4444; font-size: 11px;"></i>`;

            if (data.start_datetime) {
                const appointmentDate = new Date(data.start_datetime.replace(' ', 'T'));
                const currentDate = new Date();
                
                // Difference in milliseconds
                const diffTime = currentDate - appointmentDate;
                // Convert milliseconds to days
                const diffDays = diffTime / (1000 * 60 * 60 * 24);

                // Agar appointment ki date aaj se 14 din (2 hafte) ya usse zyada purani hai
                if (diffDays > 14 || data.star) {
                    rightIcons += ` <i class="fa-solid fa-star" style="color: #f59e0b; font-size: 11px;" title="Old booking > 2 weeks"></i>`;
                }
            }

            return `<div class="apt-card ${bgClass}" data-appointment-id="${data.id}" style="${customStyle}">
                <div class="apt-left-info">
                    ${icon}
                    <div class="apt-name">${customerName}</div>
                </div>
                <div class="apt-right-icons">${rightIcons}</div>
            </div>`;
        }

        // Navigation Handlers
        $('#prev-btn').on('click', function() {
            selectedDate.setDate(selectedDate.getDate() - (currentView === 'week' ? 7 : 1));
            window.refreshCalendar();
        });

        $('#next-btn').on('click', function() {
            selectedDate.setDate(selectedDate.getDate() + (currentView === 'week' ? 7 : 1));
            window.refreshCalendar();
        });

        $('#today-btn').on('click', function() {
            selectedDate = new Date();
            window.refreshCalendar();
        });

        $('#datepicker-trigger-btn').on('click', function() {
            const dateInput = $('#calendar-date-picker')[0];
            if (dateInput.showPicker) {
                dateInput.showPicker();
            } else {
                $('#calendar-date-picker').focus().click();
            }
        });

        $('#calendar-date-picker').on('change', function() {
            const val = $(this).val();
            if (val) {
                selectedDate = new Date(val + 'T00:00:00');
                window.refreshCalendar();
            }
        });

        $('#view-week').on('click', function() {
            $('.view-toggle-btn').removeClass('active');
            $(this).addClass('active');
            currentView = 'week';
            window.refreshCalendar();
        });

        $('#view-day').on('click', function() {
            $('.view-toggle-btn').removeClass('active');
            $(this).addClass('active');
            currentView = 'day';
            window.refreshCalendar();
        });

        $('#mini-prev-month').on('click', function() {
            selectedDate.setMonth(selectedDate.getMonth() - 1);
            window.refreshCalendar();
        });

        $('#mini-next-month').on('click', function() {
            selectedDate.setMonth(selectedDate.getMonth() + 1);
            window.refreshCalendar();
        });

        $(document).on('click', '.mini-cal-date:not(.other-month)', function() {
            const day = parseInt($(this).data('day'));
            selectedDate.setDate(day);
            window.refreshCalendar();
        });

        // Appointment Card Click Handler
        $(document).on('click', '.apt-card', function(event) {
            event.stopPropagation();
            const appointmentId = $(this).data('appointment-id');
            const appointment = getAppointmentById(appointmentId);
            if (appointment) {
                showAppointmentDetails(appointment);
            }
        });

        // Vacant Slot Click Handler (Modal Open)
        $(document).on('click', '.slot-cell', function(event) {
            const appointmentId = $(this).data('appointment-id');
            if (appointmentId) {
                return;
            }

            const date = $(this).data('date');
            const time = $(this).data('slot');

            if (!date || !time) {
                return;
            }

            const [year, month, day] = date.split('-').map(Number);
            const [timeStr, period] = time.split(' ');
            const [hourStr, minStr] = timeStr.split(':');
            let hour = Number(hourStr);
            const minutes = Number(minStr);

            if (period === 'PM' && hour !== 12) hour += 12;
            if (period === 'AM' && hour === 12) hour = 0;
            const selectedDateTime = new Date(year, month - 1, day, hour, minutes);
            showAddNewEventDialog(selectedDateTime);
        });

        $('#new-appointment-btn').on('click', function(e) {
            e.preventDefault();
            showAddNewEventDialog(new Date());
        });

        window.refreshCalendar();
    });
</script>
<?php end_section('scripts'); ?>