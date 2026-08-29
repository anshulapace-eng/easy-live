<?php extend('layouts/backend_layout1'); ?>

<?php section('content'); ?>
<!-- FontAwesome & Google Fonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">


<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
    }
    .logs-card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        background: #ffffff;
    }
    .table-custom th {
        background-color: #f1f5f9 !important;
        color: #475569 !important;
        font-weight: 700;
        font-size: 11.5px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-bottom: 1px solid #e2e8f0;
    }
    .table-custom td {
        vertical-align: middle;
        padding: 12px 16px;
        color: #1e293b;
        font-size: 13px;
        border-bottom: 1px solid #f1f5f9;
    }
    .badge-action {
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11.5px;
    }
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 6px 12px;
        font-size: 13px;
    }
    /* Dropdown arrow aur text ka overlap fix */
    .dataTables_wrapper .dataTables_length select {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 4px 30px 4px 8px !important;
        font-size: 13px;
        text-align-last: center;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.active .page-link {
        background-color: #5A3FEE !important;
        border-color: #5A3FEE !important;
        color: white !important;
        border-radius: 6px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button .page-link {
        border-radius: 6px;
        color: #334155;
    }

  
    .logs-card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        background: #ffffff;
        padding: 12px !important;
    }
    
    /* Table ko content ke hisab se auto-fit karne ke liye width: auto aur max-width */
    #activityLogsTable {
        width: auto !important;
        max-width: 100%;
        margin: 0 auto;
    }

    .table-custom th {
        background-color: #f1f5f9 !important;
        color: #475569 !important;
        font-weight: 700;
        font-size: 10px !important; /* Th ka font size aur chhota kar diya */
        letter-spacing: 0.3px;
        text-transform: uppercase;
        border-bottom: 1px solid #e2e8f0;
        padding: 6px 10px !important; /* Padding kam ki */
        height: 30px !important;
    }
    
    .table-custom td {
        vertical-align: middle;
        padding: 5px 10px !important; /* Rows ki padding kam ki */
        color: #1e293b;
        font-size: 11.5px !important; /* Content font size chhota */
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap; /* Text ko ek hi line me rakhne ke liye taaki width content ke mutabiq adjust ho */
    }

    /* Details column ko thoda wrap hone dena agar lamba ho */
    /* .table-custom td:nth-child(6) {
        white-space: normal; 
        max-width: 170.881px;
    } */

    .badge-action {
        font-weight: 600;
        padding: 3px 8px !important;
        border-radius: 6px;
        font-size: 10px !important;
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 4px 8px;
        font-size: 11.5px;
    }

    .dataTables_wrapper .dataTables_length select {
        padding-right: 25px !important;
        text-align-last: center;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.active .page-link {
        background-color: #5A3FEE !important;
        border-color: #5A3FEE !important;
        color: white !important;
        border-radius: 6px;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button .page-link {
        border-radius: 6px;
        color: #334155;
        font-size: 11.5px;
    }

    .dataTables_info {
        font-size: 11.5px !important;
    }
</style>

<div class="container py-4" style="max-width: 1150px;">
    <!-- Page Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-sm-8">
            <h3 class="fw-bold text-dark mb-1" style="font-size: 20px;">
                <i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i> Appointment Activity Logs
            </h3>
            <p class="text-muted small mb-0">Track all actions, cancellations, rescheduling, and status changes made by users in real-time.</p>
        </div>
        <div class="col-sm-4 text-sm-end mt-3 mt-sm-0">
            <a href="<?= site_url('calendar') ?>" class="btn btn-sm btn-light border fw-semibold px-3 py-2 shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Calendar
            </a>
        </div>
    </div>

    <!-- Logs Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card logs-card p-3">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-custom table-hover w-100">
                        <thead>
                            <tr>
                                <th class="ps-3" style="width: 60px;">S.No</th>
                                <th>Staff Name</th>
                                <th>Customer Name</th>
                                <th style="width: 100px !important;">Customer Phone</th>
                                <th>Action Performed</th>
                                <th>Details</th>
                                <th class="pe-3">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $logs = vars('logs');
                            if (!empty($logs)):
                                $counter = 0;
                                foreach ($logs as $log):
                            ?>
                                <tr>
                                    <td class="ps-3 fw-bold text-muted"><?= ++$counter; ?></td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= html_escape($log['user_name']); ?></div>
                                         <!--<div class="text-muted" style="font-size: 11px;">User ID: <?= $log['appointment_id'] ?? 'System'; ?></div> -->
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-primary"><?= html_escape($log['customer_name'] ?? 'N/A'); ?></div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-primary"><?= html_escape($log['customer_phone'] ?? 'N/A'); ?></div>
                                    </td>
                                    <td>
                                        <?php 
                                            $badgeColor = 'bg-secondary text-white';
                                            $action = $log['action'];
                                            
                                            if (stripos($action, 'Canceled') !== false || stripos($action, 'Deleted') !== false) {
                                                $badgeColor = 'bg-danger text-white';
                                            } elseif (stripos($action, 'Rescheduled') !== false) {
                                                $badgeColor = 'bg-warning text-dark';
                                            } elseif (stripos($action, 'Checked In') !== false || stripos($action, 'Sent') !== false || stripos($action, 'Confirmed') !== false) {
                                                $badgeColor = 'bg-success text-white';
                                            } elseif (stripos($action, 'Created') !== false) {
                                                $badgeColor = 'bg-primary text-white';
                                            } elseif (stripos($action, 'Checked Out') !== false || stripos($action, 'Video') !== false) {
                                                $badgeColor = 'bg-dark text-white';
                                            }else{
                                               $badgeColor = 'bg-dark text-white';
                                            }
                                        ?>
                                        <span class="badge badge-action <?= $badgeColor; ?>"><?= html_escape($action); ?></span>
                                    </td>
                                    <td>
                                        <?php if (!empty($log['details'])): ?>
                                            <span class="text-dark bg-light px-2 py-1 rounded border" style="font-size: 12px; display: inline-block; font-weight: 500;">
                                                <?= html_escape($log['details']); ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="pe-3 text-muted">
                                        <div class="fw-semibold text-dark"><?= date('d M Y', strtotime($log['created_at'])); ?></div>
                                        <div style="font-size: 11.5px;"><?= date('h:i:s A', strtotime($log['created_at'])); ?></div>
                                    </td>
                                </tr>
                            <?php 
                                endforeach;
                            endif; 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<?php end_section('scripts'); ?>