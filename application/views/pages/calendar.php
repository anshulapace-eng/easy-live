<?php extend('layouts/backend_layout1'); ?>

<?php section('content'); ?>

<!-- FontAwesome & Google Fonts for Exact UI Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
        background: #F4F4F8;
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
        background: #5A3FEE;
        color: white;
        padding: 8px 10px;
        border-radius: 8px;
        font-size: 16px;
    }

    .header-left h4 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #000000;
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
        font-size: 14px;
        font-weight: 600;
        color: #000000;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .nav-btn:hover {
        background: #f1f5f9;
    }

    .current-date-range {
        font-size: 18px;
        font-weight: 700;
        color: #000000;
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
        font-size: 14px;
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
        background: #F4F4F8;
        padding: 10px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 24px;
        font-size: 12px;
        font-weight: 600;
        color: #000000;
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
        width: 240px;
        background: #F4F4F8;
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
        font-size: 15px;
        color: #000000;
        margin-bottom: 12px;
    }

    .mini-cal-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
        text-align: center;
        font-size: 11px;
        margin-bottom: 16px;
    }

    .mini-cal-day-head {
        color: #000000;
        font-weight: 700;
        padding: 2px 0;
        font-size: 11px;
    }

    .mini-cal-date {
        padding: 4px 0;
        border-radius: 50%;
        color: #000000;
        font-weight: 600;
        cursor: pointer;
        font-size: 12px;
    }

    .mini-cal-date.active {
        background: #5A3FEE;
        color: white;
        font-weight: 700;
    }

    .mini-cal-date.other-month {
        color: #cbd5e1;
        font-weight: 500;
    }

    .sidebar-section-title {
        font-size: 14px;
        font-weight: 700;
        color: #000000;
        margin-top: 12px;
        margin-bottom: 8px;
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
        font-size: 13px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        color: #000000;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .view-toggle-btn.active {
        background: #5A3FEE;
        color: #ffffff;
    }

    /* =========================================================
       EXACT IMAGE MATCH: SIDEBAR PROMO CARD
    ========================================================= */
    .sidebar-promo-card {
        margin-top: 24px;
        background: #ece8f9; /* exact soft lavender tint */
        border-radius: 16px;
        padding: 22px 14px 20px 14px;
        text-align: center;
        border: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .promo-illustration-box {
        width: 105px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .promo-title {
        font-size: 12px;
        font-weight: 700;
        color: #5A3FEE; /* Same purple accent as image */
        margin-top: 8px;
        margin-bottom: 4px;
        line-height: 1.35;
    }

    .promo-desc {
        font-size: 10px;
        font-weight: 600;
        color: #1E293B; /* Dark gray/black text */
        line-height: 1.4;
        margin: 0;
    }

    .staff-box {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #000000;
    }

    .settings-btn {
        background: transparent;
        border: none;
        color: #000000;
        font-size: 13px;
        font-weight: 700;
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
        padding: 4px 8px;
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

    .diary-table th {
        padding: 2px 4px !important;
        height: 42px !important;
        vertical-align: middle !important;
    }

    .th-day-name {
        font-size: 14px !important;
        line-height: 1.1 !important;
        margin-bottom: 0px !important;
        font-weight: 700;
        text-transform: none;
    }

    .th-day-date {
        font-size: 13px !important;
        line-height: 1.1 !important;
        margin-top: 2px !important;
        font-weight: 700;
        text-transform: none;
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
        font-size: 11.5px;
        color: #000000;
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

    .apt-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11.5px;
        margin: 1px 0;
        width: 100%;
        box-sizing: border-box;
    }

    .apt-confirmed {
        background: #f8fafc;
        color: #000000;
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
        font-weight: 700;
        color: #000000;
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
        color: #000000;
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
    }

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

        .sidebar-controls-wrapper {
            display: flex;
            width: 100%;
            justify-content: space-between;
            align-items: center;
            order: 1;
        }

        .mini-cal-wrapper {
            display: none;
            width: 100%;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
            order: 2;
        }

        .mini-cal-wrapper.mobile-visible {
            display: block;
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

        .sidebar-promo-card {
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

    @media (max-width: 500px) {
        .diary-header {
            padding: 10px 12px;
            gap: 8px;
        }

        .header-left h4 {
            font-size: 18px;
        }

        .date-navigator {
            gap: 4px;
            width: 100%;
            justify-content: center;
        }

        .current-date-range {
            font-size: 14px;
            min-width: auto;
            padding: 0 4px;
            white-space: nowrap;
        }

        .nav-btn {
            padding: 4px 8px;
            font-size: 12px;
        }

        .btn-icon-only {
            padding: 5px 8px;
            font-size: 12px;
        }

        .header-right {
            width: 100%;
            justify-content: flex-start;
        }

        .btn-blue {
            padding: 6px 12px;
            font-size: 12px;
            justify-content: center;
        }

        .legend-bar {
            padding: 8px 12px;
        }
    }

    .modal-header,
    #message-modal .modal-header,
    .modal-delete .modal-header,
    #appointment-details-modal .modal-header {
        background-color: #0052cc !important;
        background: #0052cc !important;
        color: #ffffff !important;
    }

    .modal-header h3,
    .modal-header h5,
    .modal-header .modal-title,
    .modal-header .modal-header-title,
    #message-modal .modal-header h3,
    #message-modal .modal-header .modal-title {
        color: #ffffff !important;
    }

    .modal-header .btn-close,
    .modal-header .btn-close-custom {
        filter: brightness(0) invert(1) !important;
        color: #ffffff !important;
        opacity: 1 !important;
    }

    .modal-footer .btn,
    .modal-footer .btn-primary,
    .modal-footer .btn-secondary,
    .modal-footer button,
    #message-modal .modal-footer .btn,
    #message-modal .modal-footer button {
        background-color: #0052cc !important;
        border-color: #0052cc !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(0, 82, 204, 0.25) !important;
        transition: all 0.25s ease;
    }

    .modal-footer .btn:hover,
    .modal-footer .btn-primary:hover,
    .modal-footer .btn-secondary:hover,
    .modal-footer button:hover,
    #message-modal .modal-footer .btn:hover,
    #message-modal .modal-footer button:hover {
        background-color: #0043a8 !important;
        border-color: #0043a8 !important;
        transform: translateY(-1px);
        color: #ffffff !important;
    }

    .export-btn-shadow {
    /* Soft border jaisa image me hai */
    border: 1px solid #e2e8f0 !important; 
    
    /* Rounded corners */
    border-radius: 8px !important; 
    
    /* Bahut halka aur smooth shadow */
    box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.08) !important; 
    
    transition: all 0.2s ease;
}

/* Hover par shadow thoda sa dark karne ke liye */
.export-btn-shadow:hover {
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.12) !important;
    background-color: #f8fafc !important; /* Halka sa gray background */
}

/* Past / Expired Slots Styling */
.slot-cell.past-slot {
    background-color: #f1f5f9 !important;
    color: #cbd5e1 !important;
    cursor: not-allowed !important;
    pointer-events: none !important;
}

.slot-cell.past-slot .apt-card {
    opacity: 0.6;
    pointer-events: none;
}

/* 1. General Body & Table Font Reduction */
    .appointment-diary-wrapper, 
    .diary-table td, 
    .diary-table th,
    .diary-sidebar,
    .legend-bar {
        font-size: 10.5px !important;
    }

    /* 2. Header & Date Navigator Compactness */
    .header-left h4 {
        font-size: 14px !important;
    }
    .current-date-range {
        font-size: 12.5px !important;
        min-width: 150px !important;
    }
    .nav-btn, #today-btn, #datepicker-trigger-btn {
        font-size: 11px !important;
        padding: 3px 6px !important;
    }

    /* 3. Table Header & Time Slots */
    .diary-table th {
        height: 32px !important;
        padding: 2px !important;
    }
    .th-day-name {
        font-size: 12px !important;
    }
    .th-day-date {
        font-size: 11px !important;
    }
    .time-cell {
        font-size: 10px !important;
        width: 65px !important;
    }

    /* 4. Appointment Cards Compactness */
    .apt-card {
        padding: 2px 4px !important;
        font-size: 10px !important;
        margin: 0.5px 0 !important;
    }
    .apt-name {
        font-size: 10px !important;
    }
    .apt-right-icons i, .apt-left-info i {
        font-size: 9.5px !important;
    }

    /* 5. Sidebar Mini Calendar & Controls */
    .mini-cal-grid {
        font-size: 10px !important;
    }
    .mini-cal-date {
        font-size: 10px !important;
        padding: 2px 0 !important;
    }
    .mini-calendar-header {
        font-size: 12px !important;
        margin-bottom: 8px !important;
    }
    .sidebar-section-title {
        font-size: 11px !important;
        margin-top: 8px !important;
        margin-bottom: 4px !important;
    }
    .view-toggle-btn {
        font-size: 11px !important;
        padding: 4px !important;
    }
    .staff-box {
        font-size: 11px !important;
        padding: 4px 8px !important;
    }

    /* 6. Legends Bar Compactness */
    .legend-bar {
        font-size: 10px !important;
        padding: 6px 16px !important;
        gap: 16px !important;
    }
    .legend-item {
        gap: 4px !important;
    }
    .legend-bar span {
        width: 10px !important;
        height: 10px !important;
    }

    /* 7. Modals Font Scaling */
    #appointment-details-modal .modal-title {
        font-size: 12px !important;
    }
    #appointment-details-modal .modal-body {
        font-size: 10px !important;
    }
</style>

<div id="toast-message" class="custom-toast">
    <span id="toast-text"></span>
    <button type="button" onclick="hideToast()">
        <i class="fas fa-times"></i>
    </button>
</div>

<div class="appointment-diary-wrapper">
<style>
    /* Compact Mobile & Fluid Single-Row Adjustments */
    @media (max-width: 1200px) {
        .diary-header {
            padding: 8px 12px !important;
            gap: 6px !important;
        }
        .header-left h4 {
            font-size: 15px !important;
        }
        .header-left .icon-box {
            width: 30px !important;
            height: 30px !important;
            font-size: 12px !important;
            padding: 0 !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .current-date-range {
            font-size: 12.5px !important;
            min-width: 140px !important;
        }
        .nav-btn, .btn-icon-only, #today-btn {
            padding: 3px 7px !important;
            font-size: 11px !important;
        }
        .header-right .btn, #new-appointment-btn {
            padding: 4px 10px !important;
            font-size: 11.5px !important;
        }
    }


    
</style>

<div class="diary-header" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; padding: 8px 16px; gap: 8px;">

    <!-- Left: Title -->
    <div class="header-left" style="display: flex; align-items: center; justify-content: center; gap: 8px; flex-shrink: 0; margin-bottom: 0;">
        <div class="icon-box" style="background: #0d7774; color: white; width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 13px;"><i class="fa-regular fa-calendar-days"></i></div>
        <h4 style="margin: 0; font-size: 16px; font-weight: 700; color: #17252d; font-family: 'Plus Jakarta Sans', sans-serif; white-space: nowrap; line-height: 1.2;">Appointment Diary</h4>
    </div>

    <!-- Center: Date Navigator -->
    <div class="date-navigator" style="display: flex; align-items: center; gap: 4px; flex-wrap: wrap; position: relative; margin-bottom: 0; flex-shrink: 1;">
        <button class="nav-btn" id="prev-btn" style="padding: 4px 8px; font-size: 11px; display: inline-flex; align-items: center; justify-content: center;"><i class="fa-solid fa-chevron-left"></i></button>
        <div class="current-date-range" id="date-range-display" style="font-size: 13.5px; font-weight: 700; color: #17252d; min-width: 175px; text-align: center; line-height: 1.2;">Loading...</div>
        <button class="nav-btn" id="next-btn" style="padding: 4px 8px; font-size: 11px; display: inline-flex; align-items: center; justify-content: center;"><i class="fa-solid fa-chevron-right"></i></button>

        <button class="nav-btn" id="today-btn" style="padding: 4px 10px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; justify-content: center;">Today</button>

        <button class="btn-icon-only" id="datepicker-trigger-btn" title="Pick Date" style="padding: 4px 8px; font-size: 12px; display: inline-flex; align-items: center; justify-content: center;">
            <i class="fa-regular fa-calendar"></i>
        </button>
        <input type="date" id="calendar-date-picker" style="position: absolute; opacity: 0; pointer-events: none; width: 0; height: 0;">
    </div>

    <!-- Right: Export Report & New Appointment Buttons -->
    <div class="header-right" style="display: flex; align-items: center; gap: 6px; flex-shrink: 0; margin-bottom: 0;">
        
        <!-- Zaroori Hidden Triggers for Auto-Refresh -->
        <button id="reload-appointments" style="display: none;"></button>
        <a href="#" id="insert-appointment" style="display: none;"></a>
        <a href="#" id="insert-unavailability" style="display: none;"></a>

        <!-- Export Dropdown -->
        <div class="dropdown export-btn-shadow" style="display: inline-block; margin-bottom: 0;">
            <button class="btn dropdown-toggle shadow-sm" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #fff; color:#17252d; border: 1px solid #cbd5e1; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                <i class="fa-solid fa-file-excel" style="color: #137333 !important;"></i> Export
            </button>
            <ul class="dropdown-menu p-3 shadow-sm" aria-labelledby="exportDropdown" style="width: 230px; font-size: 13px;">
                <li><a class="dropdown-item fw-bold export-option" href="#" data-range="today"><i class="fa-solid fa-calendar-day me-2 text-primary"></i> Today</a></li>
                <li>
                    <a class="dropdown-item fw-bold export-option d-flex align-items-center py-2" href="#" data-range="yesterday">
                        <div style="width: 24px; text-align: center; display: flex; justify-content: center;">
                            <span class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle" style="width: 16px; height: 16px;">
                                <i class="fa-solid fa-arrow-right-long" style="font-size: 9px;"></i>
                            </span>
                        </div>
                        Yesterday
                    </a>
                </li>
                <li><a class="dropdown-item fw-bold export-option" href="#" data-range="tomorrow"><i class="fa-solid fa-calendar-plus me-2 text-success"></i> Tomorrow</a></li>
                <li><a class="dropdown-item fw-bold export-option" href="#" data-range="week"><i class="fa-solid fa-calendar-week me-2 text-warning"></i> This Week</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <label class="form-label fw-bold mb-1" style="font-size: 11px;">Custom Range:</label>
                    <input type="date" id="export-start-date" class="form-control form-control-sm mb-2">
                    <input type="date" id="export-end-date" class="form-control form-control-sm mb-2">
                    <button type="button" class="btn btn-sm btn-primary w-100" id="btn-custom-export" style="font-size: 12px;">Download Excel</button>
                </li>
            </ul>
        </div>

        <!-- New Appointment Button -->
        <button class="btn" style="background: #0d7774; color:#fff; font-weight: 600; border-radius: 6px; padding: 4px 10px; font-size: 12px; white-space: nowrap; display: inline-flex; align-items: center; gap: 4px;" id="new-appointment-btn">
            <i class="fa-solid fa-plus"></i> New Appointment
        </button>
    </div>
</div>

    <!-- Legends Bar -->
    <div class="legend-bar">
        <div class="legend-item"><span style="width: 14px; height: 14px; display: inline-block; background: #93c5fd; border-radius: 3px;"></span> Booked</div>
        <div class="legend-item"><span style="width: 14px; height: 14px; display: inline-block; background: #bbf7d0; border-radius: 3px;"></span> Checked In</div>
        <div class="legend-item"><span style="width: 14px; height: 14px; display: inline-block; background: #cbd5e1; border-radius: 3px;"></span> Checked Out</div>
        <div class="legend-item"><span style="width: 14px; height: 14px; display: inline-block; background: #c084fc; border-radius: 3px;"></span> Today's Booking</div>
        <div class="legend-item"><span style="width: 14px; height: 14px; display: inline-block; background: #bfdbfe; border-radius: 3px;"></span> Past Booking</div>
        <div class="legend-item"><span style="width: 14px; height: 14px; display: inline-block; background: #fca5a5; border-radius: 3px;"></span> Cancelled</div>
        <div class="legend-item"><span style="width: 14px; height: 14px; display: inline-block; background: #a78bfa; border-radius: 3px;"></span> Video Visit</div>

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

            <div class="sidebar-controls-wrapper">
                <div>
                    <div class="sidebar-section-title">View</div>
                    <div class="view-toggle-group">
                        <button class="view-toggle-btn active" id="view-week"><i class="fa-regular fa-calendar-days"></i> Week</button>
                        <button class="view-toggle-btn" id="view-day"><i class="fa-regular fa-calendar"></i> Day</button>
                    </div>
                </div>

                <button type="button" class="btn-icon-only mobile-mini-cal-btn" id="toggle-mini-cal-btn" title="Toggle Calendar">
                    <i class="fa-regular fa-calendar-days"></i>
                </button>

                <div style="display: none;" class="desktop-only-staff">
                    <div class="sidebar-section-title">Staff (All)</div>
                    <div class="staff-box">All Staff</div>
                </div>
            </div>

            <!-- =========================================================
                 EXACT MATCH PROMO CARD (SAME TO SAME AS IMAGE)
            ========================================================== -->
            <div class="sidebar-promo-card">
                <div class="promo-illustration-box">
                    <svg viewBox="0 0 120 110" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: 100%;">
                        <!-- Light Lavender Circle Background -->
                        <circle cx="60" cy="48" r="42" fill="#E9E3FF"/>
                        
                        <!-- Purple Floor / Shadow Drops -->
                        <rect x="28" y="72" width="28" height="6" rx="3" fill="#6D48E5"/>
                        <rect x="74" y="72" width="22" height="6" rx="3" fill="#6D48E5"/>
                        
                        <!-- Main Calendar Base (White) -->
                        <rect x="36" y="28" width="46" height="44" rx="6" fill="#FFFFFF"/>
                        <!-- Calendar Header Purple -->
                        <path d="M36 34C36 30.6863 38.6863 28 42 28H76C79.3137 28 82 30.6863 82 34V40H36V34Z" fill="#7C3AED"/>
                        
                        <!-- Binder Rings -->
                        <rect x="43" y="24" width="4" height="8" rx="2" fill="#C4B5FD"/>
                        <rect x="71" y="24" width="4" height="8" rx="2" fill="#C4B5FD"/>
                        
                        <!-- Calendar Date Grid Dots -->
                        <rect x="42" y="44" width="6" height="6" rx="2" fill="#C4B5FD"/>
                        <rect x="51" y="44" width="6" height="6" rx="2" fill="#C4B5FD"/>
                        <rect x="60" y="44" width="6" height="6" rx="2" fill="#7C3AED"/>
                        <rect x="69" y="44" width="6" height="6" rx="2" fill="#7C3AED"/>

                        <rect x="42" y="53" width="6" height="6" rx="2" fill="#C4B5FD"/>
                        <rect x="51" y="53" width="6" height="6" rx="2" fill="#7C3AED"/>
                        <rect x="60" y="53" width="6" height="6" rx="2" fill="#7C3AED"/>

                        <rect x="42" y="62" width="6" height="6" rx="2" fill="#C4B5FD"/>
                        <rect x="51" y="62" width="6" height="6" rx="2" fill="#C4B5FD"/>

                        <!-- Overlapping Purple Clock -->
                        <circle cx="70" cy="62" r="14" fill="#A78BFA" stroke="#6D48E5" stroke-width="2.5"/>
                        <path d="M70 55V62L74 64" stroke="#6D48E5" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="70" cy="62" r="1.5" fill="#6D48E5"/>
                    </svg>
                </div>
                <div class="promo-title">Manage your appointments</div>
                <p class="promo-desc">efficiently and never miss a schedule.</p>
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
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; overflow: hidden; background: #ffffff;">

            <!-- Header -->
            <div class="modal-header" style="background: #ffffff; border: none; padding: 10px 14px 4px 14px; display: flex; align-items: center; justify-content: space-between;">
                <button type="button" class="btn" style="background: none; border: none; font-size: 14px; color: #1e293b; padding: 0; cursor: pointer; display: flex; align-items: center;">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <h5 class="modal-title" style="margin: 0; font-size: 13px; font-weight: 700; color: #0f172a; flex: 1; text-align: center;">Appointment Details</h5>
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close" style="background: none; border: none; font-size: 15px; color: #475569; padding: 0; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body" style="padding: 4px 14px 12px 14px;">

                <!-- Avatar & Name -->
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                    <div style="width: 40px; height: 40px; background: #ede9fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #7c3aed; font-weight: 700; font-size: 14px; flex-shrink: 0;" class="customer-avatar">SM</div>
                    <div style="overflow: hidden; flex: 1;">
                        <h6 style="margin: 0; font-size: 14px; font-weight: 700; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" class="customer-name">Sophia Martin</h6>
                        <span style="display: inline-block; margin-top: 2px; padding: 1px 6px; background: #e6f4ea; color: #137333; border-radius: 8px; font-size: 9px; font-weight: 600;" class="appointment-status">Confirmed</span>
                    </div>
                </div>

                <!-- Date, Time, Location Box -->
                <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 8px; background: #f8fafc; padding: 6px 10px; border-radius: 8px;">
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 11px; color: #334155; font-weight: 500;">
                        <i class="fa-regular fa-calendar" style="color: #64748b; width: 14px; text-align: center;"></i>
                        <span class="appointment-date">Mon, 15 June 2026</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 11px; color: #334155; font-weight: 500;">
                        <i class="fa-regular fa-clock" style="color: #64748b; width: 14px; text-align: center;"></i>
                        <span class="appointment-time">12:15 PM – 12:30 PM <span style="color: #94a3b8; font-weight: 400;">(15 min)</span></span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 11px; color: #334155; font-weight: 500;">
                        <i class="fa-solid fa-location-dot" style="color: #64748b; width: 14px; text-align: center;"></i>
                        <span class="appointment-location">Main Clinic – Room 2</span>
                    </div>
                </div>

                <!-- Booked Details -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                    <span style="font-size: 11px; color: #0f172a; font-weight: 600;">Booked on</span>
                    <span style="font-size: 11px; color: #334155; font-weight: 500;" class="booked-on">13 June 2026, 09:15 AM</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <span style="font-size: 11px; color: #0f172a; font-weight: 600;">Booked by</span>
                    <div style="text-align: right;" class="booked-by">
                        <span style="font-size: 11px; color: #334155; font-weight: 500;">Jane Smith </span>
                        <span style="font-size: 10px; color: #64748b;">(Receptionist)</span>
                    </div>
                </div>

                <!-- Call / WhatsApp Buttons -->
                <div style="display: flex; gap: 8px; margin-bottom: 8px;">
                    <a href="tel:1234567899" class="btn btn-call-phone" style="flex: 1; padding: 4px 8px; border: 1.5px solid #22c55e; background: white; color: #16a34a; border-radius: 6px; font-weight: 700; font-size: 11px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 4px; text-decoration: none;">
                        <i class="fa-solid fa-phone" style="font-size: 10px;"></i> Call
                    </a>
                    <a href="#" target="_blank" class="btn btn-send-whatsapp" style="flex: 1; padding: 4px 8px; border: 1.5px solid #22c55e; background: white; color: #16a34a; border-radius: 6px; font-weight: 700; font-size: 11px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 4px; text-decoration: none;">
                        <i class="fa-brands fa-whatsapp" style="font-size: 12px;"></i> WhatsApp
                    </a>
                </div>

                <!-- Message Box -->
                <div style="margin-bottom: 8px;">
                    <div style="font-size: 10px; color: #0f172a; font-weight: 700; margin-bottom: 2px;">
                        Message <span style="color: #94a3b8; font-weight: 400;">(Copy for WhatsApp)</span>
                    </div>
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 6px 8px; border-radius: 6px; display: flex; align-items: center; justify-content: space-between; gap: 6px;">
                        <p style="margin: 0; font-size: 10px; color: #334155; line-height: 1.3; font-weight: 500;" class="message-text">
                            <!-- Message JS se aayega -->
                        </p>
                        <button type="button" class="copy-msg-btn" style="background: none; border: none; color: #2563eb; cursor: pointer; padding: 2px; font-size: 12px; flex-shrink: 0;" title="Copy Message">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Status Toggles -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                    <span style="font-size: 11px; color: #0f172a; font-weight: 600;">WhatsApp sent</span>
                    <div style="display: flex; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 1px;">
                        <span class="whatsapp-sent-status" onclick="handleAppointmentAction(this, $('#cancelid').val(), { action: 'toggle_whatsapp' })" style="padding: 1px 6px; border-radius: 4px; font-size: 9px; font-weight: 700; display: flex; align-items: center; gap: 4px; cursor: pointer;">
                            -
                        </span>
                    </div>
                </div>
                
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                    <span style="font-size: 11px; color: #0f172a; font-weight: 600;">Confirmed by patient</span>
                    <div style="display: flex; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 1px;">
                        <span class="confirmed-patient"
                            onclick="handleAppointmentAction(this, $('#cancelid').val(), { action: 'toggle_confirm' })"
                            style="padding: 1px 6px; background: #fee2e2; color: #991b1b; border-radius: 4px; font-size: 9px; font-weight: 700; display: flex; align-items: center; gap: 4px; cursor: pointer;">
                            No <i class="fa-solid fa-circle-xmark" style="font-size: 9px;"></i>
                        </span>
                    </div>
                </div>

                

                

                <!-- Appointment Type (In-Clinic / Video) -->
                <div style="display: flex; gap: 6px; margin-bottom: 10px;">
                    <!-- IN CLINIC OPTION -->
                    <div class="appointment-type-inclinic"
                        onclick="handleAppointmentAction(this, $('#cancelid').val(), { appointment_type: 'in-clinic' })"
                        style="flex: 1; border: 1px solid #e2e8f0; border-radius: 6px; padding: 4px 6px; display: flex; align-items: center; justify-content: space-between; cursor: pointer;">
                        <div style="display: flex; align-items: center; gap: 4px;">
                            <i class="fa-regular fa-calendar-check" style="color: #16a34a; font-size: 11px;"></i>
                            <div>
                                <div style="font-size: 9px; font-weight: 700; color: #0f172a;">In Clinic</div>
                                <div style="font-size: 7px; color: #64748b;">Face to face</div>
                            </div>
                        </div>
                        <div style="width: 10px; height: 10px; border: 1.5px solid #cbd5e1; border-radius: 50%;" class="type-indicator"></div>
                    </div>

                    <!-- VIDEO CALL OPTION -->
                    <div class="appointment-type-video"
                        onclick="handleAppointmentAction(this, $('#cancelid').val(), { appointment_type: 'video' })"
                        style="flex: 1; border: 1px solid #e2e8f0; background: #ffffff; border-radius: 6px; padding: 4px 6px; display: flex; align-items: center; justify-content: space-between; cursor: pointer;">
                        <div style="display: flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-video" style="color: #9333ea; font-size: 10px;"></i>
                            <div>
                                <div style="font-size: 9px; font-weight: 700; color: #0f172a;">Video Call</div>
                                <div style="font-size: 7px; color: #64748b;" class="type-subtext">Online video</div>
                            </div>
                        </div>
                        <div style="width: 10px; height: 10px; border: 1.5px solid #cbd5e1; border-radius: 50%;" class="type-indicator"></div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div id="modal-action-buttons" style="display: flex; gap: 6px;">
                    <input type="hidden" id="cancelid" name="cancelid" value="">

                    <div class="dropdown" style="flex: 1;">
                        <button class="btn dropdown-toggle w-100" type="button" id="appointmentActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 5px 0; border: 1px solid #cbd5e1; background: #ffffff; color: #334155; border-radius: 6px; font-weight: 700; font-size: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 4px;">
                            Actions
                        </button>
                        <ul class="dropdown-menu shadow-sm" aria-labelledby="appointmentActionsDropdown" style="font-size: 11px; min-width: 110px;">
                            <li><a class="dropdown-item text-success fw-bold action-check-status" href="#" data-check-type="1" style="padding: 4px 10px;"><i class="fa-solid fa-circle-check me-1"></i> Check In</a></li>
                            <li><a class="dropdown-item text-primary fw-bold action-check-status checkout-status" href="#" data-check-type="0" style="padding: 4px 10px;"><i class="fa-solid fa-circle-right me-1"></i> Check Out</a></li>
                            <li>
                                <hr class="dropdown-divider my-1">
                            </li>
                            <li><a class="dropdown-item text-danger fw-bold action-cancel" href="#" style="padding: 4px 10px;" id="cancelbutton"><i class="fa-regular fa-calendar-xmark me-1"></i> Cancel</a></li>
                        </ul>
                    </div>

                    <button type="button" class="btn btn-reschedule-appointment" data-appointment="" style="flex: 1.2; padding: 5px 0; border: 1px solid #93c5fd; background: #ffffff; color: #2563eb; border-radius: 6px; font-weight: 700; font-size: 10px;">
                        <i class="fa-regular fa-calendar-days"></i> Reschedule/Edit
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
                Are you sure that you want to cancel this appointment? This action cannot be undone.
            </div>
            <div class="modal-footer border-0">
                <input type="hidden" id="delete-appointment-id" value="">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-confirm-delete" id="btn-confirm-delete-action">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom Add New Event Choice Modal -->
<div class="modal fade" id="addNewEventModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px; margin: auto;">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 40px -15px rgba(0, 82, 204, 0.15); overflow: hidden; background: #ffffff;">

            <div class="modal-header" style="background-color: #0052cc !important; border: none; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;">
                <h5 class="modal-title" style="margin: 0; font-size: 16px; font-weight: 700; color: #ffffff;">
                    Add New Event
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0) invert(1); cursor: pointer;"></button>
            </div>

            <div class="modal-body" style="padding: 25px 20px; font-size: 15px; color: #334155; font-weight: 500; text-align: left;">
                What kind of event would you like to add?
            </div>

            <div class="modal-footer border-0" style="padding: 10px 20px 20px 20px; display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" id="btn-event-unavailability" class="btn" style="background-color: #0052cc; border-color: #0052cc; color: #ffffff; font-weight: 600; padding: 8px 24px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 82, 204, 0.25);">
                    Unavailability
                </button>
                <button type="button" id="btn-event-appointment" class="btn" style="background-color: #16a34a; border-color: #16a34a; color: #ffffff; font-weight: 600; padding: 8px 24px; border-radius: 8px; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);">
                    Appointment
                </button>
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

        // Export Option Click Handler
        $(document).on('click', '.export-option', function(e) {
            e.preventDefault();
            let range = $(this).data('range');
            let url = "<?= site_url('calendar/export_excel'); ?>?range=" + range;
            window.location.href = url;
        });

        // Custom Date Range Export Handler
        $(document).on('click', '#btn-custom-export', function(e) {
            e.stopPropagation();
            let startDate = $('#export-start-date').val();
            let endDate = $('#export-end-date').val();

            if (!startDate || !endDate) {
                alert("Please select both start and end dates.");
                return;
            }

            let url = "<?= site_url('calendar/export_excel'); ?>?start_date=" + startDate + "&end_date=" + endDate;
            window.location.href = url;
        });

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
                url: "<?= site_url('calendar/cancel_appointment') ?>",
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
                        showToast("Appointment cancelled successfully.");
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
                url: "<?= site_url('calendar/update_check_status') ?>",
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


    function handleAppointmentAction(element, appointmentId, actionData) {
        if (!appointmentId) {
            alert("Appointment ID nahi mili!");
            return;
        }

        let $el = $(element);
        let postData = {
            appointment_id: appointmentId,
            csrf_token: vars('csrf_token')
        };
        let successMsg = "Updated successfully.";

        if (actionData.action === 'toggle_confirm') {
            let currentText = $el.text().trim();
            postData.status = currentText.startsWith('No') ? 'confirmed' : 'booked';
            successMsg = postData.status === 'confirmed' ? "Appointment confirmed" : "Status updated to unconfirmed.";
        }

        if (actionData.action === 'toggle_whatsapp') {
            let currentText = $el.text().trim();
            postData.is_whatsapp_sent = (currentText.startsWith('No') || currentText === "-") ? '1' : '0';
            successMsg = postData.is_whatsapp_sent === '1' ? "WhatsApp marked as sent." : "WhatsApp marked as not sent.";
        }
        if (actionData.appointment_type) {
            postData.appointment_type = actionData.appointment_type;
            successMsg = postData.appointment_type === 'video' ? "Changed to Video Call." : "Changed to In-Clinic.";
        }
        if (actionData.check_type !== undefined) {
            postData.check_type = actionData.check_type;
            successMsg = postData.check_type === 1 ? "Checked in successfully." : "Checked out successfully.";
        }

        if (actionData.action === 'delete_unavailability') {
            if (!confirm("Are you sure you want to make this slot available?")) {
                return;
            }
            postData.is_unavailability = 0;
            successMsg = "Slot is now available!";
        }


        $.ajax({
            url: "<?= site_url('calendar/update_appointment_field') ?>",
            type: "POST",
            dataType: "json",
            data: postData,
            success: function(response) {
                if (response.success) {

                if (postData.is_whatsapp_sent !== undefined) {
                    if (Number(postData.is_whatsapp_sent) === 1) {
                        $el.css({
                            'background': '#dcfce7',
                            'color': '#15803d'
                        }).html('Yes <i class="fa-solid fa-circle-check" style="font-size: 10px;"></i>');
                    } else {
                        $el.css({
                            'background': '#fee2e2',
                            'color': '#991b1b'
                        }).html('No <i class="fa-solid fa-circle-xmark" style="font-size: 10px;"></i>');
                    }
                }

                    if (postData.status) {
                        if (postData.status === 'confirmed') {
                            $el.css({
                                    'background': '#dcfce7',
                                    'color': '#15803d'
                                })
                                .html('Yes <i class="fa-solid fa-circle-check" style="font-size: 10px;"></i>');
                        } else {
                            $el.css({
                                    'background': '#fee2e2',
                                    'color': '#991b1b'
                                })
                                .html('No <i class="fa-solid fa-circle-xmark" style="font-size: 10px;"></i>');
                        }
                    }

                    if (postData.appointment_type) {
                        let $modal = $('#appointment-details-modal');
                        let $inClinic = $modal.find('.appointment-type-inclinic');
                        let $video = $modal.find('.appointment-type-video');

                        if (postData.appointment_type === 'video') {
                            $video.css({
                                'border': '1px solid #c084fc',
                                'background': '#faf5ff'
                            });
                            $video.find('.type-indicator').replaceWith('<i class="fa-solid fa-circle-check type-indicator" style="color: #7e22ce; font-size: 12px;"></i>');

                            $inClinic.css({
                                'border': '1px solid #e2e8f0',
                                'background': '#ffffff'
                            });
                            $inClinic.find('.type-indicator').replaceWith('<div style="width: 12px; height: 12px; border: 1.5px solid #cbd5e1; border-radius: 50%;" class="type-indicator"></div>');
                        } else {
                            $inClinic.css({
                                'border': '1px solid #16a34a',
                                'background': '#f0fdf4'
                            });
                            $inClinic.find('.type-indicator').replaceWith('<i class="fa-solid fa-circle-check type-indicator" style="color: #16a34a; font-size: 12px;"></i>');

                            $video.css({
                                'border': '1px solid #e2e8f0',
                                'background': '#ffffff'
                            });
                            $video.find('.type-indicator').replaceWith('<div style="width: 12px; height: 12px; border: 1.5px solid #cbd5e1; border-radius: 50%;" class="type-indicator"></div>');
                        }
                    }

                    if (postData.is_unavailability === '0') {
                        $el.removeClass('blocked-slot')
                            .addClass('slot-cell')
                            .removeAttr('style')
                            .removeAttr('onclick')
                            .css({
                                'cursor': 'pointer',
                                'background-color': '#ffffff',
                                'border-bottom': '1px solid #f1f5f9',
                                'height': '42px'
                            })
                            .html('');
                    }

                    if (postData.check_type !== undefined) {
                        $('#appointment-details-modal').modal('hide');
                    }

                    $('#appointment-details-modal').modal('hide');
                    showToast(successMsg);

                    refreshCalendar();
                } else {
                    alert(response.message || "Failed to update.");
                }
            },
            error: function() {
                alert("Server connection error.");
            }
        });
    }

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
        const shortMonthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        const dayKeysMap = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
        const dayNamesShort = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

        const dayColors = {
            0: '#9333ea',
            1: '#2563eb',
            2: '#16a34a',
            3: '#f97316',
            4: '#ec4899',
            5: '#ef4444',
            6: '#0d9488'
        };

        function getCalendarDateRange() {
            // Selected date ka poora mahina (Month start se Month end tak)
            const startDate = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), 1);
            startDate.setHours(0, 0, 0, 0);

            const endDate = new Date(selectedDate.getFullYear(), selectedDate.getMonth() + 1, 0);
            endDate.setHours(23, 59, 59, 999);

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
            const customerName = appointment.customer.first_name === appointment.customer.last_name ?
                appointment.customer.first_name :
                [appointment.customer.first_name, appointment.customer.last_name].filter(Boolean).join(' - ') || '-';
            const customerInitials = ((appointment.customer.first_name?.[0] || '') + (appointment.customer.last_name?.[0] || '')).toUpperCase() || 'AP';

            const providerName = [appointment.provider.first_name, appointment.provider.last_name].filter(Boolean).join(' ') || '-';
            const location = appointment.location || '-';
            const status = appointment.status || 'pending';

            const appointmentType = appointment.appointment_type || 'in_clinic';

            const startDate = new Date(appointment.start_datetime.replace(' ', 'T'));
            const endDate = new Date(appointment.end_datetime.replace(' ', 'T'));
            const duration = Math.round((endDate - startDate) / 60000);

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const aptDate = new Date(startDate);
            aptDate.setHours(0, 0, 0, 0);

            if (aptDate < today || appointment.check_type === "0" || appointment.is_canceled === "1") {
                $('#modal-action-buttons').hide();
            } else {
                $('#modal-action-buttons').show();
            }
            if (appointment.check_type == null) {
                $(".checkout-status").prop('disabled', true).addClass('disabled');
            } else {
                $(".checkout-status").prop('disabled', false).removeClass('disabled');
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

            const bookedOn = new Date(appointment.create_datetime || new Date()).toLocaleString('en-US', {
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

            const customerPhone = appointment.customer?.phone_number || '';
            let cleanPhone = String(customerPhone).replace(/\D/g, '');
            if (cleanPhone.length === 10) {
                cleanPhone = '91' + cleanPhone;
            }

            // let whatsappMessage = `Your Appointment with Dr. Monashis Sahu (Endocrinologist) has been scheduled for :
            //     Date: ${formattedStartDate}
            //     Time: ${formattedStartTime}
            //     Location: Dr. Sahu's Clinic, E 339, GK1, New Delhi
            //     Map location : https://maps.app.goo.gl/Z7oFhN7qNqTSPofV9`;
            let whatsappMessage = '';
            let activeLocation = '';

            if (appointmentType === 'video' || appointmentType === 'video_call') {
                activeLocation = 'Video platform';
                whatsappMessage = `Your Appointment with Dr. Monashis Sahu (Endocrinologist) has been scheduled for :
                Date: ${formattedStartDate}
                Time: ${formattedStartTime}
                Location: Video platform`;
            } else {
                activeLocation = "Dr. Sahu's Clinic, E 339, GK1, New Delhi";
                whatsappMessage = `Your Appointment with Dr. Monashis Sahu (Endocrinologist) has been scheduled for :
                Date: ${formattedStartDate}
                Time: ${formattedStartTime}
                Location: Dr. Sahu's Clinic, E 339, GK1, New Delhi
                Map location : https://maps.app.goo.gl/Z7oFhN7qNqTSPofV9`;
            }
            let encodedMessage = encodeURIComponent(whatsappMessage);
            // $modal.find('.btn-send-whatsapp').attr('href', `https://wa.me/${cleanPhone}?text=${encodedMessage}`);
            $modal.find('.btn-send-whatsapp').attr('href', `https://wa.me/${cleanPhone}`);

            $modal.find('.appointment-status').text(status.charAt(0).toUpperCase() + status.slice(1));
            $modal.find('.appointment-date').text(formattedStartDate);
            $modal.find('.appointment-time').html(`${formattedStartTime} - ${formattedEndTime} <span style="color: #94a3b8;">(${duration} min)</span>`);
            $modal.find('.appointment-location').text(location);
            $modal.find('.booked-on').text(bookedOn);
            $modal.find('.booked-by').html(`${providerName}<br><span style="font-size: 12px; color: #64748b;">(Provider)</span>`);
            let visibleMessage = `Your Appointment with Dr. Monashis Sahu (Endocrinologist) has been scheduled for :<br>
            <b>Date:</b> ${formattedStartDate}
            <b>Time:</b> ${formattedStartTime} <span style="color: #94a3b8;">...</span>`;

            $modal.find('.message-text').html(visibleMessage);

            $modal.find('.copy-msg-btn').off('click').on('click', function() {
                navigator.clipboard.writeText(whatsappMessage).then(() => {
                    showToast("WhatsApp message copied to clipboard!");
                }).catch(err => {
                    console.error('Failed to copy: ', err);
                });
            });

            const callPhoneNum = appointment.customer?.phone_number || '9810826144';
            $modal.find('.btn-call-phone').attr('href', `tel:${callPhoneNum}`);

            const isWhatsappSent = Number(appointment.is_whatsapp_sent) === 1;
            const $whatsappStatusSpan = $modal.find('.whatsapp-sent-status');
            if (isWhatsappSent) {
                $whatsappStatusSpan.css({
                    'background': '#dcfce7',
                    'color': '#15803d'
                }).html('Yes <i class="fa-solid fa-circle-check" style="font-size: 10px;"></i>');
            } else {
                $whatsappStatusSpan.css({
                    'background': '#fee2e2',
                    'color': '#991b1b'
                }).html('No <i class="fa-solid fa-circle-xmark" style="font-size: 10px;"></i>');
            }

            let isConfirmed = false;
            if (appointment && appointment.status) {
                let currentStatus = appointment.status.toLowerCase();
                if (currentStatus === 'confirm' || currentStatus === 'confirmed') {
                    isConfirmed = true;
                }
            }

            const $confirmedSpan = $modal.find('.confirmed-patient');
            $confirmedSpan.attr('data-appointment-id', appointment.id);

            if (isConfirmed) {
                $confirmedSpan.css({
                    'background': '#dcfce7',
                    'color': '#15803d'
                }).html('Yes <i class="fa-solid fa-circle-check" style="font-size: 10px;"></i>');
            } else {
                $confirmedSpan.css({
                    'background': '#fee2e2',
                    'color': '#991b1b'
                }).html('No <i class="fa-solid fa-circle-xmark" style="font-size: 10px;"></i>');
            }

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

        window.openNewAppointmentModal = function(startDateTime) {
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

        window.openNewUnavailabilityModal = function(startDateTime) {
            App.Components.UnavailabilitiesModal.resetModal();
            const $unavailabilitiesModal = $('#unavailabilities-modal');
            const $startDateTime = $unavailabilitiesModal.find('#unavailability-start');
            const $endDateTime = $unavailabilitiesModal.find('#unavailability-end');

            App.Utils.UI.setDateTimePickerValue($startDateTime, startDateTime);
            App.Utils.UI.setDateTimePickerValue($endDateTime, new Date(startDateTime.getTime() + 15 * 60000));

            $unavailabilitiesModal.find('.modal-header h3').text(lang('new_unavailability_title'));
            $unavailabilitiesModal.modal('show');
        }

        let globalSelectedStartDateTime = null;

        function showAddNewEventDialog(startDateTime) {
            globalSelectedStartDateTime = startDateTime;

            $('#btn-event-unavailability').text(lang('unavailability') || 'Unavailability');
            $('#btn-event-appointment').text(lang('appointment') || 'Appointment');
            $('#addNewEventModal .modal-title').text(lang('add_new_event') || 'Add New Event');
            $('#addNewEventModal .modal-body').text(lang('what_kind_of_event') || 'What kind of event would you like to add?');

            $('#addNewEventModal').modal('show');
        }

        $(document).on('click', '#btn-event-unavailability', function() {
            $('#addNewEventModal').modal('hide');
            if (typeof openNewUnavailabilityModal === 'function' && globalSelectedStartDateTime) {
                openNewUnavailabilityModal(globalSelectedStartDateTime);
            }
        });

        $(document).on('click', '#btn-event-appointment', function() {
            $('#addNewEventModal').modal('hide');
            if (typeof openNewAppointmentModal === 'function' && globalSelectedStartDateTime) {
                openNewAppointmentModal(globalSelectedStartDateTime);
            }
        });

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

                let headRow = `<tr><th style="width: 80px; text-align: center; background:  #F9F9FA !important; color: #3a3838 !important;  vertical-align: middle; font-weight: 700;">Time</th>`;

                weekDays.forEach((d) => {
                    const dayColor = dayColors[d.dayIndex] || '#334155';
                    headRow += `<th style="text-align: center; background: #F4F5F8; padding: 10px 4px; border-bottom: 1px solid #e2e8f0;">
                        <div class="th-day-name" style="font-size: 14px; font-weight: 700; color: ${dayColor}; text-transform: none;">${d.name}</div>
                        <div class="th-day-date" style="font-size: 13px; font-weight: 600; color: ${dayColor}; margin-top: 2px; text-transform: none;">${d.dateStr}</div>
                    </th>`;
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
                    let row = `<tr><td class="time-cell" style="background:  #F9F9FA !important; color: #3a3838 !important; text-align: center !important; padding-right: 0 !important; border-bottom: 1px solid #e2e8f0 !important;">${time}</td>`;

                    weekDays.forEach((d) => {
                        const dateAttr = `${d.dateObj.getFullYear()}-${String(d.dateObj.getMonth() + 1).padStart(2, '0')}-${String(d.dateObj.getDate()).padStart(2, '0')}`;

                        if (!workingPlan[d.dayKey]) {
                            if (index === 0) {
                                row += `<td rowspan="${uniqueTimeSlots.length}" class="holiday-col" style="background: #FAF9FF; text-align: center; border-right: 1px solid #e2e8f0;">
                                    <div class="holiday-content" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%;">
                                        <div style="margin-bottom: 8px; filter: drop-shadow(0px 4px 6px rgba(157, 123, 255, 0.35));">
                                            <i class="fa-solid fa-calendar-xmark" style="font-size: 36px; color: #9D7BFF;"></i>
                                        </div>
                                        <div style="font-weight: 700; font-size: 15px; color: #1E1B4B; margin-bottom: 2px; letter-spacing: -0.3px;">Holiday</div>
                                        <div style="font-size: 12.5px; font-weight: 600; color: #9D7BFF;">(Office Closed)</div>
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
                            row += `<td class="break-slot" style="background-color: rgb(190, 190, 190); color: #000; text-align: center;">
                              <i class="fa-solid fa-ban"></i>
                               Unavailable
                            </td>`;
                            return;
                        }

                        const appointment = findAppointmentAt(dateAttr, time);
                        const unavailability = appointment ? null : findUnavailabilityAt(dateAttr, time);
                        const blockedPeriod = appointment || unavailability ? null : findBlockedPeriodAt(dateAttr, time);
                        let blockId = unavailability ? unavailability.id : (blockedPeriod ? blockedPeriod.id : '');
                        
                        const [yearVal, monthVal, dayVal] = dateAttr.split('-').map(Number);
                        const slot24Time = formatTimeSlotTo24(time); // Day view me yahan slotObj.time hoga
                        const [hVal, minVal] = slot24Time.split(':').map(Number);
                        const slotDateTime = new Date(yearVal, monthVal - 1, dayVal, hVal, minVal);
                        const now = new Date();
                        const cutoffTime = new Date(now.getTime() - (5 * 60 * 60 * 1000));

                        const isPastSlot = slotDateTime < cutoffTime;
                        

                        if (unavailability || blockedPeriod) {
                            row += `<td class="blocked-slot" data-date="${dateAttr}" data-slot="${time}" onclick="handleAppointmentAction(this, '${blockId}', { action: 'delete_unavailability' })" style="background-color: rgb(190, 190, 190); color: #000; cursor: pointer; text-align: center;">
                                <i class="fa-solid fa-ban"></i> Unavailable
                            </td>`;
                        } else if (appointment) {
                            // Appointment wale cell par past-slot nahi lagega taaki wo clickable rahe
                            row += `<td class="slot-cell" data-date="${dateAttr}" data-slot="${time}" data-appointment-id="${appointment.id}">${createCardHtml(appointment)}</td>`;
                        } else {
                            // Sirf khali/empty slots hi disable honge past hone par
                            const pastClass = isPastSlot ? 'past-slot' : '';
                            row += `<td class="slot-cell ${pastClass}" data-date="${dateAttr}" data-slot="${time}" ${isPastSlot ? '' : 'style="cursor: pointer;"'}></td>`;
                        }
                    });
                    row += `</tr>`;
                    tbody.append(row);
                });

            } else if (currentView === 'day') {
                const dayKey = dayKeysMap[selectedDate.getDay()];
                const dateAttr = `${selectedDate.getFullYear()}-${String(selectedDate.getMonth() + 1).padStart(2, '0')}-${String(selectedDate.getDate()).padStart(2, '0')}`;
                $('#date-range-display').text(`${monthNames[selectedDate.getMonth()]} ${selectedDate.getDate()}, ${selectedDate.getFullYear()}`);

                const currentDayIndex = selectedDate.getDay();
                const dayColor = dayColors[currentDayIndex] || '#334155';

                thead.append(`<tr>
                    <th style="width: 80px; text-align: center; background:  #F9F9FA !important; color: #000 !important;  border-bottom: 1px solid #e2e8f0; vertical-align: middle; font-weight: 700;">Time</th>
                    <th style="text-align: center; background: #F4F5F8; padding: 12px 0; border-bottom: 1px solid #e2e8f0;">
                        <div class="th-day-name" style="font-size: 16px; font-weight: 700; color: ${dayColor}; text-transform: none;">${dayNamesShort[currentDayIndex]}</div>
                        <div class="th-day-date" style="font-size: 15px; font-weight: 600; color: ${dayColor}; margin-top: 4px; text-transform: none;">${shortMonthNames[selectedDate.getMonth()]} ${selectedDate.getDate()}</div>
                    </th>
                </tr>`);

                let daySlots = generateSlotsWithBreaks(dayKey);
                if (daySlots.length === 0) {
                    tbody.append(`<tr><td colspan="2" class="holiday-col" style="height: 400px; text-align: center; background: #FAF9FF;">
                        <div class="holiday-content" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%;">
                            <div style="margin-bottom: 10px; filter: drop-shadow(0px 4px 6px rgba(157, 123, 255, 0.35));">
                                <i class="fa-solid fa-calendar-xmark" style="font-size: 42px; color: #9D7BFF;"></i>
                            </div>
                            <div style="font-weight: 700; font-size: 18px; color: #1E1B4B; margin-bottom: 4px; letter-spacing: -0.3px;">Holiday</div>
                            <div style="font-size: 14px; font-weight: 600; color: #9D7BFF;">(Office Closed)</div>
                        </div>
                    </td></tr>`);
                    return;
                }

                daySlots.forEach((slotObj) => {
                    let row = `<tr><td class="time-cell" style="background:  #F9F9FA !important; color: #000 !important;  text-align: center !important; padding-right: 0 !important; border-bottom: 1px solid #000 !important;">${slotObj.time}</td>`;

                    if (slotObj.isBreak) {
                        row += `<td class="break-slot" style="background-color: rgb(190, 190, 190); color: #000; text-align: center;">
                          <i class="fa-solid fa-ban"></i> Unavailable
                        </td>`;
                    } else {
                        const appointment = findAppointmentAt(dateAttr, slotObj.time);
                        const unavailability = appointment ? null : findUnavailabilityAt(dateAttr, slotObj.time);
                        const blockedPeriod = appointment || unavailability ? null : findBlockedPeriodAt(dateAttr, slotObj.time);
                        
                        const [yearVal, monthVal, dayVal] = dateAttr.split('-').map(Number);
                        const slot24Time = formatTimeSlotTo24(slotObj.time); // Day view me yahan slotObj.time hoga
                        const [hVal, minVal] = slot24Time.split(':').map(Number);
                        const slotDateTime = new Date(yearVal, monthVal - 1, dayVal, hVal, minVal);
                        const now = new Date();
                        const cutoffTime = new Date(now.getTime() - (5 * 60 * 60 * 1000));

                        const isPastSlot = slotDateTime < cutoffTime;

                        if (unavailability || blockedPeriod) {
                            row += `<td class="blocked-slot" data-date="${dateAttr}" data-slot="${slotObj.time}" style="text-align: center; color: #94a3b8; background-color: #ffffff; padding: 10px; border-bottom: 1px solid #f1f5f9;">
                                <i class="fa-solid fa-ban" style="color: #cbd5e1;"></i> Blocked Slot
                            </td>`;
                        } if (appointment) {
                            // Appointment wale cell par past-slot nahi lagega
                            row += `<td class="slot-cell day-view-slot" data-date="${dateAttr}" data-slot="${slotObj.time}" data-appointment-id="${appointment.id}" style="padding: 0; background-color: #ffffff;">${createCardHtml(appointment, true)}</td>`;
                        } else {
                            // Sirf khali slots disable honge
                            const pastClass = isPastSlot ? 'past-slot' : '';
                            row += `<td class="slot-cell ${pastClass}" data-date="${dateAttr}" data-slot="${slotObj.time}" style="${isPastSlot ? '' : 'cursor: pointer;'} background-color: #ffffff; border-bottom: 1px solid #f1f5f9; height: 42px;"></td>`;
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

            const isCanceled = Number(data.is_canceled) === 1 || data.status?.toLowerCase() === 'canceled';
            let isConfirmed = ['confirm', 'confirmed'].includes(data.status?.toLowerCase());

            if (Number(data.is_whatsapp_sent) === 1) {
                if (!isConfirmed) {
                 
                    icon = `<i class="fa-regular fa-clock" style="color: #eab308;" title="WhatsApp sent & Not yet responded"></i>`;
                } else {
                    
                    icon = `<i class="fa-brands fa-whatsapp" style="color: #22c55e;" title="WhatsApp Sent & Confirmed"></i>`;
                }
            } else {
                icon = `<i class="fa-solid fa-circle-exclamation" style="color: #ef4444;" title="WhatsApp Not Sent"></i>`;
            }

            let customerName = [
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

            const aptType = data.appointment_type || 'in-clinic';
            let typeIcon = '';
            if (aptType === 'video' || aptType === 'video_call') {
                typeIcon = `<i class="fa-solid fa-video" style="color: #9333ea; font-size: 11px;" title="Video Call"></i>`;
            } else {
                typeIcon = `<i class="fa-regular fa-calendar-check" style="color: #16a34a; font-size: 11px;" title="In Clinic"></i>`;
            }

            const isStatusBookedOrConfirmed = ['booked', 'confirm', 'confirmed'].includes(data.status?.toLowerCase());
            const isVideoAppointment = aptType === 'video' || aptType === 'video_call' || String(data.check_type).toLowerCase() === 'video';

            if (isStatusBookedOrConfirmed) {
                customStyle = 'background-color: #E3F4EE;';
            }

            if (isVideoAppointment) {
                customStyle = 'background-color: #F8EEF5;';
            }

            let rightIcons = '';
            if (data.check_type !== null && data.check_type !== undefined && data.check_type !== "") {
                if (Number(data.check_type) === 1) {
                    rightIcons += `<i class="fa-solid fa-circle-right" style="color: #16a34a; font-size: 11px;" title="Checked In"></i> `;
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

                const diffTime = currentDate - appointmentDate;
                const diffDays = diffTime / (1000 * 60 * 60 * 24);

                if (diffDays > 14 || data.star) {
                    rightIcons += ` <i class="fa-solid fa-star" style="color: #f59e0b; font-size: 11px;" title="Old booking > 2 weeks"></i>`;
                }
            }

            if (isCanceled) {
                customStyle = 'background-color: #fca5a5; opacity: 0.9; color: #ffffff !important;';
                icon = `<i class="fa-solid fa-ban" style="color: #ffffff;" title="Canceled"></i>`;
                rightIcons = '';
                customerName = 'Cancelled';
            }

                return `<div class="apt-card ${bgClass}" data-appointment-id="${data.id}" style="${customStyle}" draggable="true" title="Drag to Reschedule">
                        <div class="apt-left-info">
                            ${icon}
                            <div class="apt-name">${data.customer?.first_name}</div>
                        </div>
                        <div class="apt-right-icons">${rightIcons}</div>
                    </div>`;
        }

        $(document).on('dragstart', '.apt-card', function(e) {
            let aptId = $(this).attr('data-appointment-id');
            e.originalEvent.dataTransfer.effectAllowed = 'move';
            e.originalEvent.dataTransfer.setData('text/plain', aptId);
            setTimeout(() => { $(this).css('opacity', '0.4'); }, 0); 
        });

        $(document).on('dragend', '.apt-card', function(e) {
            $(this).css('opacity', '1'); 
        });

        $(document).on('dragover', '.slot-cell', function(e) {
            e.preventDefault(); 
            e.originalEvent.dataTransfer.dropEffect = 'move';
            $(this).css('background-color', '#e2e8f0'); 
        });

        $(document).on('dragleave', '.slot-cell', function(e) {
            $(this).css('background-color', ''); 
        });

        $(document).on('drop', '.slot-cell', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).css('background-color', ''); 

            let aptId = e.originalEvent.dataTransfer.getData('text/plain');
            let newDate = $(this).attr('data-date'); 
            let newTimeStr = $(this).attr('data-slot'); 

            if (!aptId || !newDate || !newTimeStr) return;

            if ($(this).find('.apt-card').length > 0 || $(this).hasClass('blocked-slot') || $(this).hasClass('break-slot')) {
                showToast("Cannot drop here. Slot is unavailable or occupied!");
                return;
            }

            if(confirm(`Are you sure you want to reschedule this appointment to ${newDate} at ${newTimeStr}?`)) {
                processDragDropReschedule(aptId, newDate, newTimeStr);
            }
        });

        function processDragDropReschedule(appointmentId, newDate, newTimeStr) {
            let appointment = getAppointmentById(appointmentId);
            if(!appointment) return;

            let formatted24Time = formatTimeSlotTo24(newTimeStr);
            
            let oldStart = new Date(appointment.start_datetime.replace(' ', 'T'));
            let oldEnd = new Date(appointment.end_datetime.replace(' ', 'T'));
            
            let durationMs = oldEnd.getTime() - oldStart.getTime(); 
            if(isNaN(durationMs) || durationMs <= 0) durationMs = 15 * 60000;

            let [y, m, d] = newDate.split('-');
            let [h, min] = formatted24Time.split(':');
            let newStartObj = new Date(y, m - 1, d, h, min, 0);
            let newEndObj = new Date(newStartObj.getTime() + durationMs);

            let pad = (n) => String(n).padStart(2, '0');
            let newStartDatetime = `${newStartObj.getFullYear()}-${pad(newStartObj.getMonth()+1)}-${pad(newStartObj.getDate())} ${pad(newStartObj.getHours())}:${pad(newStartObj.getMinutes())}:00`;
            let newEndDatetime = `${newEndObj.getFullYear()}-${pad(newEndObj.getMonth()+1)}-${pad(newEndObj.getDate())} ${pad(newEndObj.getHours())}:${pad(newEndObj.getMinutes())}:00`;

            $.ajax({
                url: "<?= site_url('calendar/reschedule_appointment_drag_drop') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    appointment_id: appointmentId,
                    start_datetime: newStartDatetime,
                    end_datetime: newEndDatetime,
                    csrf_token: vars('csrf_token')
                },
                success: function(response) {
                    if (response.success) {
                        showToast("Appointment Rescheduled Successfully!");
                        refreshCalendar(); 
                    } else {
                        alert(response.message || "Failed to reschedule.");
                    }
                },
                error: function() {
                    alert("Server connection error.");
                }
            });
        }

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
            if (currentView === 'day') {
                selectedDate.setDate(selectedDate.getDate() - 1);
            } else {
                selectedDate.setDate(selectedDate.getDate() - 7);
            }
            window.refreshCalendar();
        });

        $('#mini-next-month').on('click', function() {
            if (currentView === 'day') {
                selectedDate.setDate(selectedDate.getDate() + 1);
            } else {
                selectedDate.setDate(selectedDate.getDate() + 7);
            }
            window.refreshCalendar();
        });

        $(document).on('click', '.mini-cal-date:not(.other-month)', function() {
            const day = parseInt($(this).data('day'));
            selectedDate.setDate(day);
            window.refreshCalendar();
        });

        $(document).on('click', '.apt-card', function(event) {
            event.stopPropagation();
            const appointmentId = $(this).data('appointment-id');
            const appointment = getAppointmentById(appointmentId);
            if (appointment) {
                showAppointmentDetails(appointment);
            }
        });

        $(document).on('click', '.slot-cell', function(event) {
             if ($(this).hasClass('past-slot')) {
                return;
            }
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