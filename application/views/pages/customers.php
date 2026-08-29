<?php extend('layouts/backend_layout1'); ?>

<?php section('content'); ?>
<!-- FontAwesome & Google Fonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
    }

    /* Card Styling */
    .customers-card {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05);
        background: #ffffff;
        padding: 20px !important;
    }

    #customersTable {
        width: 100% !important;
        margin: 0 auto;
        border-collapse: separate;
        border-spacing: 0;
    }

    /* Table Headers */
    .table-custom th {
        background-color: #f8fafc !important;
        color: #64748b !important;
        font-weight: 600;
        font-size: 11px !important;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-bottom: 2px solid #e2e8f0 !important;
        border-top: none !important;
        padding: 10px 14px !important;
        white-space: nowrap !important;
    }

    /* Table Rows & Cells */
    .table-custom td {
        vertical-align: middle;
        padding: 4px 4% !important;
        color: #334155;
        font-size: 12px !important;
        font-weight: 400 !important;
        border-bottom: 1px solid #f1f5f9 !important;
        background-color: #ffffff;
        white-space: nowrap !important;
    }

    .table-custom tbody tr:hover td {
        background-color: #fafcfd !important;
    }

    /* Search & Length Inputs */
    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        padding: 5px 10px;
        font-size: 12px;
        background-color: #ffffff;
        color: #334155;
        outline: none;
    }

    .dataTables_wrapper .dataTables_length select {
        padding-right: 25px !important;
        text-align-last: left;
    }

    /* Pagination Styling */
    .dataTables_wrapper .dataTables_paginate .paginate_button.active .page-link {
        background-color: #3b82f6 !important;
        border-color: #3b82f6 !important;
        color: white !important;
        border-radius: 6px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button .page-link {
        border-radius: 6px;
        color: #475569;
        font-size: 12px;
        border: 1px solid transparent;
        padding: 5px 10px;
        margin: 0 2px;
    }

    .dataTables_info,
    .dataTables_length,
    .dataTables_filter {
        font-size: 12px !important;
        color: #64748b !important;
        margin-bottom: 14px;
    }

    .form-label-custom {
        font-size: 12px;
        font-weight: 500;
        color: #334155;
        margin-bottom: 4px;
    }

    .form-control-custom,
    .form-select-custom {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 8px 12px;
        font-size: 13px;
        color: #334155;
    }

    .form-control-custom:focus,
    .form-select-custom:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    .input-group-custom {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background-color: #fff;
        overflow: hidden;
    }

    .input-group-custom:focus-within {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    .input-group-custom .input-group-text {
        background: transparent;
        border: none;
        color: #64748b;
        padding: 8px 10px;
    }

    .input-group-custom .form-control,
    .input-group-custom .form-select {
        border: none;
        box-shadow: none;
        padding: 8px 10px;
        font-size: 13px;
        color: #334155;
    }

    .input-group-custom .form-control:focus,
    .input-group-custom .form-select:focus {
        box-shadow: none;
    }

    .select2-container--bootstrap-5 .select2-results__option {
        font-size: 12px !important;
        font-weight: normal !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        font-size: 12px !important;
        font-weight: normal !important;
    }
</style>

<div class="container py-4" style="max-width: 1100px;">

    <?php if (session('success')): ?>
        <div id="success-alert" class="alert alert-success alert-dismissible fade show shadow-sm mb-3" role="alert" style="font-size: 13px; border-radius: 8px;">
            <i class="fa-solid fa-circle-check me-2"></i><?= session('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <!-- Page Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-sm-8">
            <h3 class="fw-bold text-dark mb-1" style="font-size: 20px;">
                <i class="fa-solid fa-users me-2 text-primary"></i> Customer Management
            </h3>
            <p class="text-muted small mb-0">View and manage all registered customers, appointments, and assigned providers.</p>
        </div>
        <div class="col-sm-4 text-sm-end mt-3 mt-sm-0">
            <!-- नया Add Customer बटन -->
            <button type="button" class="btn btn-sm btn-primary fw-semibold px-3 py-2 shadow-sm me-2" data-bs-toggle="modal" data-bs-target="#addCustomerModal" style="border-radius: 6px;">
                <i class="fa-solid fa-user-plus me-1"></i> Add Customer
            </button>

        </div>
    </div>

    <!-- Customers Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card customers-card">
                <div class="table-responsive">
                    <table id="customersTable" class="table table-custom table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th class="ps-3" style="width: 40px;">S.No</th>
                                <th>Customer Name</th>
                                <th>Phone</th>
                                <th>Assigned Provider</th>
                                <th>Appointment Date & Time</th>
                                <th class="pe-3 text-center" style="width: 70px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($customers)):
                                $counter = 0;
                                foreach ($customers as $row):
                            ?>
                                    <tr>
                                        <td class="ps-3 text-muted"><?= ++$counter; ?></td>
                                        <td>
                                            <div class="fw-medium text-dark"><?= html_escape(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? '')); ?></div>
                                            <?php if (!empty($row['email'])): ?>
                                                <div class="text-muted" style="font-size: 11px;"><?= html_escape($row['email']); ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td><span><?= html_escape($row['phone_number'] ?? 'N/A'); ?></span></td>
                                        <td>
                                            <?php if (!empty($row['provider_first_name'])): ?>
                                                <?= html_escape($row['provider_first_name'] . ' ' . $row['provider_last_name']); ?>
                                            <?php else: ?>
                                                <span class="text-muted fst-italic">Unassigned</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($row['start_datetime'])): ?>
                                                <?= date('d M Y', strtotime($row['start_datetime'])); ?> |
                                                <?= date('h:i A', strtotime($row['start_datetime'])); ?>
                                                <?php if (!empty($row['end_datetime'])): ?>
                                                    - <?= date('h:i A', strtotime($row['end_datetime'])); ?>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted fst-italic">No Appointment</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="pe-3 text-center">
                                            <button type="button" class="btn btn-sm btn-light border text-primary px-2 py-1" data-bs-toggle="modal" data-bs-target="#customermodal_<?= $row['id']; ?>" title="Edit Customer" style="font-size: 11px; border-radius: 4px;">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
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


<!-- Add New Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom px-3 py-2 bg-primary text-white">
                <h5 class="modal-title fw-bold" id="addCustomerModalLabel" style="font-size: 16px;">
                    <i class="fa-solid fa-user-plus me-2"></i> Add New Customer
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= site_url('customers/store') ?>" method="POST" class="customer-add-form">
                <input type="hidden" name="csrf_token" id="form_csrf_token">

                <div class="modal-body p-4 bg-light">
                    <div class="bg-white p-3 rounded-3 border shadow-sm">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label form-label-custom">Patient Name <span class="text-danger">*</span></label>
                                <input type="text" name="customer[first_name]" id="first-name1" class="form-control form-control-custom" placeholder="Enter patient name">
                                <span class="text-danger errortext"></span>
                            </div>
                            <div class="col-12">
                                <label class="form-label form-label-custom">Contact Name</label>
                                <div class="form-check form-check-inline m-0">
                                    <input class="form-check-input same-as-patient-checkbox" type="checkbox">
                                    <label class="form-check-label text-muted" style="font-size: 11px;">Same as Patient</label>
                                </div>
                                <input type="text" name="customer[last_name]" id="last-name1" class="form-control form-control-custom" placeholder="Enter contact name">
                                <span class="text-danger errortext"></span>

                            </div>
                            <div class="col-12">
                                <label class="form-label form-label-custom">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="customer[phone_number]" id="phone-number1" class="form-control form-control-custom" required placeholder="Enter phone number">
                                <span class="text-danger errortext"></span>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3 bg-white">
                    <button type="button" class="btn btn-light border px-4 fw-semibold text-secondary shadow-sm" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm" style="border-radius: 8px;"><i class="fa-solid fa-check me-1"></i> Save Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .modal-body {
        padding: 12px 16px !important;
    }

    .modal-body .bg-white {
        padding: 10px 12px !important;
        margin-bottom: 8px !important;
    }

    .form-control-custom,
    .form-select-custom {
        padding: 5px 10px !important;
        font-size: 12px !important;
    }

    .form-label-custom {
        margin-bottom: 2px !important;
    }
</style>

<!-- Modals for Editing Customers & Appointments -->
<?php
if (!empty($customers)):
    foreach ($customers as $data):
?>
        <div class="modal fade" id="customermodal_<?= $data['id']; ?>" tabindex="-1" aria-labelledby="customermodalLabel_<?= $data['id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header border-bottom px-2 py-2">
                        <h5 class="modal-title fw-bold text-white" id="customermodalLabel_<?= $data['id']; ?>" style="font-size: 16px;">
                            <i class="fa-solid fa-pen-to-square text-primary me-2"></i> Edit Appointment & Customer Details
                        </h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?= site_url('customers/update') ?>" method="POST" class="customer-update-form">
                        <div class="modal-body p-4 bg-light">

                            <!-- Appointment Details Section -->
                            <?php if (!empty($data['appointment_id'])): ?>
                                <div class="bg-white p-3 rounded-3 border mb-3 shadow-sm">
                                    <h6 class="fw-bold text-dark mb-3" style="font-size: 14px;">Appointment Details</h6>
                                    <input type="hidden" value="<?= $data['appointment_id']; ?>" name="appointment_id" id="appointment_id">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label form-label-custom">Provider <span class="text-danger">*</span></label>
                                            <select name="provider_id" id="provider_id" class="form-select form-select-custom select2-enable" required>
                                                <option value="">Select Provider</option>
                                                <option value="<?= $data['id_users_provider']; ?>" <?= (isset($data['id_users_provider']) && $data['id_users_provider'] == 1) ? 'selected' : ''; ?>>Dr. Monashish Sahu</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label form-label-custom">Select Date <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="fa-regular fa-calendar"></i></span>
                                                <input type="date" name="start_date" id="start_date" class="form-control appointment-date" value="<?= !empty($data['start_datetime']) ? date('Y-m-d', strtotime($data['start_datetime'])) : ''; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label form-label-custom">Select Time Slot <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-custom">
                                                <span class="input-group-text"><i class="fa-regular fa-clock"></i></span>
                                                <select name="start_time" id="start_time" class="form-select appointment-time" required>
                                                    <?php
                                                    if (!empty($data['start_datetime'])):
                                                        $start_time_val = date('H:i', strtotime($data['start_datetime']));
                                                        $start_label = date('H:i', strtotime($data['start_datetime']));
                                                        $end_label = !empty($data['end_datetime']) ? date('H:i', strtotime($data['end_datetime'])) : '';
                                                        $display_label = $end_label ? $start_label . ' - ' . $end_label : $start_label;
                                                    ?>
                                                        <option value="<?= $start_time_val; ?>" selected>
                                                            <?= $display_label; ?>
                                                        </option>
                                                    <?php else: ?>
                                                        <option value="">Choose date first...</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label form-label-custom">Status</label>
                                            <select name="status" id="status" class="form-select form-select-custom">
                                                <option value="Booked" <?= (isset($data['appointment_status']) && $data['appointment_status'] == 'Booked') ? 'selected' : ''; ?>>Booked</option>
                                                <option value="Confirmed" <?= (isset($data['appointment_status']) && $data['appointment_status'] == 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                                                <option value="Rescheduled" <?= (isset($data['appointment_status']) && $data['appointment_status'] == 'Rescheduled') ? 'selected' : ''; ?>>Rescheduled</option>
                                                <option value="Cancelled" <?= (isset($data['appointment_status']) && $data['appointment_status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                                <option value="Draft" <?= (isset($data['appointment_status']) && $data['appointment_status'] == 'Draft') ? 'selected' : ''; ?>>Draft</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label form-label-custom">Appointment Types <span class="text-danger">*</span></label>
                                            <select name="appointment_type" id="appointment_type" class="form-select form-select-custom" required>
                                                <option value="in-clinic" <?= (isset($data['appointment_type']) && $data['appointment_type'] == 'in-clinic') ? 'selected' : ''; ?>>In Clinic (Face to face)</option>
                                                <option value="video" <?= (isset($data['appointment_type']) && $data['appointment_type'] == 'video') ? 'selected' : ''; ?>>Video Call</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Customer Details Section -->
                            <div class="bg-white p-3 rounded-3 border shadow-sm">
                                <input type="hidden" value="<?= $data['id']; ?>" name="customer_id" id="customer_id">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;">Customer Details</h6>
                                    <div class="btn-group btn-group-sm customer-mode-toggle" role="group">
                                        <button type="button" class="btn btn-outline-secondary active btn-new-mode" data-mode="new">
                                            <i class="fa-solid fa-user-plus me-1"></i> New
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-select-mode" data-mode="select">
                                            <i class="fa-solid fa-hand-pointer me-1"></i> Select
                                        </button>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3 select-search-container d-none">
                                    <div class="col-12">
                                        <label class="form-label form-label-custom text-primary fw-bold">Search & Select Customer</label>
                                        <select class="form-select form-select-custom master-customer-select">
                                            <option value="">Select customer from list...</option>
                                            <?php foreach ($customers as $cust): ?>
                                                <option style="font-size: 10px;" value="<?= $cust['id']; ?>"
                                                    data-firstname="<?= html_escape(($cust['first_name'] ?? '')); ?>"
                                                    data-lastname="<?= html_escape(($cust['last_name'] ?? '')); ?>"
                                                    data-phone="<?= html_escape($cust['phone_number'] ?? ''); ?>">
                                                    <?= html_escape(($cust['first_name'] ?? '') . ' ' . ($cust['last_name'] ?? '')) . ' (' . html_escape($cust['phone_number'] ?? 'No Phone') . ')'; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="hidden" class="default-value-holder"
                                            data-fname="<?= html_escape($data['first_name'] ?? ''); ?>"
                                            data-lname="<?= html_escape($data['last_name'] ?? ''); ?>"
                                            data-dphone="<?= html_escape($data['phone_number'] ?? ''); ?>">
                                        <label class="form-label form-label-custom">Patient Name <span class="text-danger">*</span></label>
                                        <input type="text" name="first-name" id="first-name" class="form-control form-control-custom patient-input" value="<?= html_escape(($data['first_name'] ?? '')); ?>" required placeholder="Enter patient name">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label form-label-custom mb-0">Contact Name</label>
                                            <div class="form-check form-check-inline m-0">
                                                <input class="form-check-input same-as-patient-checkbox" type="checkbox">
                                                <label class="form-check-label text-muted" style="font-size: 11px;">Same as Patient</label>
                                            </div>
                                        </div>
                                        <input type="text" name="last-name" id="last-name" class="form-control form-control-custom contact-input" value="<?= html_escape($data['last_name'] ?? ''); ?>" placeholder="Enter contact name">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label form-label-custom">Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" name="phone-number" id="phone-number" class="form-control form-control-custom phone-input" value="<?= html_escape($data['phone_number'] ?? ''); ?>" required placeholder="Enter phone number">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer border-top px-4 py-3 bg-white">
                            <button type="button" class="btn btn-light border px-4 fw-semibold text-secondary shadow-sm" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                            <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm" style="border-radius: 8px;"><i class="fa-solid fa-check me-1"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php
    endforeach;
endif;
?>

<?php end_section('content'); ?>

<?php section('scripts'); ?>
<!-- DataTables JS & Bootstrap 5 Integration JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#success-alert').fadeOut(200, function() {
                $(this).remove();
            });
        }, 6000);


        $('#customersTable').DataTable({
            "order": [
                [0, "asc"]
            ],
            "pageLength": 10,
            "language": {
                "search": "Search customers:",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries"
            }
        });

        // Initialize Select2 inside Bootstrap Modals properly
        $('.modal').on('shown.bs.modal', function() {
            let $modal = $(this);

            $modal.find('.select2-enable').each(function() {
                if (!$(this).hasClass("select2-hidden-accessible")) {
                    $(this).select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $modal
                    });
                }
            });

            let patientInput = $modal.find('input[name="first-name"]');
            let contactInput = $modal.find('input[name="last-name"]');
            let checkbox = $modal.find('.same-as-patient-checkbox');

            if (patientInput.val().trim() !== '' && patientInput.val().trim() === contactInput.val().trim()) {
                checkbox.prop('checked', true);
                patientInput.off('input.sameAs').on('input.sameAs', function() {
                    contactInput.val(patientInput.val());
                });
            }
        });

        // Toggle between 'New' and 'Select' customer modes
        $(document).on('click', '.customer-mode-toggle button', function() {
            let $group = $(this).closest('.customer-mode-toggle');
            let $modal = $(this).closest('.modal');
            let mode = $(this).data('mode');

            $group.find('button').removeClass('active');
            $(this).addClass('active');

            let searchContainer = $modal.find('.select-search-container');
            let masterSelect = $modal.find('.master-customer-select');
            let patientInput = $modal.find('input[name="first-name"]');
            let contactInput = $modal.find('input[name="last-name"]');
            let phoneInput = $modal.find('input[name="phone-number"]');

            if (mode === 'select') {
                searchContainer.removeClass('d-none');

                if (!masterSelect.hasClass("select2-hidden-accessible")) {
                    masterSelect.select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $modal
                    });
                }
            } else {
                searchContainer.addClass('d-none');
                if (masterSelect.hasClass("select2-hidden-accessible")) {
                    masterSelect.val(null).trigger('change');
                }

                let defaultInput = $modal.find('.default-value-holder');
                let fName = defaultInput.data('fname');
                let lName = defaultInput.data('lname');
                let dPhone = defaultInput.data('dphone');

                patientInput.val(fName);
                contactInput.val(lName);
                phoneInput.val(dPhone);
            }
        });


        $(document).on('change', '.master-customer-select', function() {
            let selectedOption = $(this).find(':selected');
            let $modal = $(this).closest('.modal');

            let firstnamename = selectedOption.data('firstname');
            let lastnamename = selectedOption.data('lastname');
            let phone = selectedOption.data('phone');

            $modal.find('input[name="first-name"]').val(firstnamename);
            $modal.find('input[name="last-name"]').val(lastnamename);
            $modal.find('input[name="phone-number"]').val(phone);
        });

        $(document).on('change', '.same-as-patient-checkbox', function() {
            let $modal = $(this).closest('.modal');
            let patientInput = $modal.find('input[name="first-name"]');
            let contactInput = $modal.find('input[name="last-name"]');


            let patientInput1 = $modal.find('#first-name1');
            let contactInput1 = $modal.find('#last-name1');

            if ($(this).is(':checked')) {
                if (patientInput.length) {
                    contactInput.val(patientInput.val());
                    patientInput.on('input.sameAs', function() {
                        contactInput.val(patientInput.val());
                    });
                }
                if (patientInput1.length) {
                    contactInput1.val(patientInput1.val());
                    patientInput1.on('input.sameAs1', function() {
                        contactInput1.val(patientInput1.val());
                    });
                }
            } else {
                patientInput.off('input.sameAs');
                contactInput.val('');

                patientInput1.off('input.sameAs1');
                contactInput1.val('');
            }
        });


        $(document).on('change', '.appointment-date', function() {
            let selectedDate = $(this).val();
            let $modal = $(this).closest('.modal');
            let timeSelect = $modal.find('.appointment-time');

            if (!selectedDate) return;

            timeSelect.html('<option value="">Loading slots...</option>');

            $.ajax({
                url: '<?= site_url("customers") ?>',
                type: 'GET',
                data: {
                    date: selectedDate
                },
                dataType: 'json',
                success: function(response) {
                    timeSelect.empty();
                    if (response && response.length > 0) {
                        timeSelect.append('<option value="">Select Time Slot</option>');
                        $.each(response, function(index, slot) {
                            let disabledAttr = slot.available ? '' : 'disabled';
                            let badgeText = slot.available ? '' : ' (' + slot.status.toUpperCase() + ')';
                            timeSelect.append(
                                `<option value="${slot.start}" ${disabledAttr}>${slot.label}${badgeText}</option>`
                            );
                        });
                    } else {
                        timeSelect.append('<option value="">No slots available</option>');
                    }
                },
                error: function() {
                    timeSelect.html('<option value="">Failed to load slots</option>');
                }
            });
        });


        function validationerror(input, errorMessage, e) {
            $input.addClass('is-invalid');
            $input.siblings('.errortext').text(errorMessage);
            $input.focus();
            e.preventDefault();
            return false;
        }

        // jQuery validation and dynamic form submit handling
        $(document).on('submit', '.customer-update-form', function(e) {
            e.preventDefault();
            let $form = $(this);
            let $modal = $form.closest('.modal');

            // Clear previous errors
            $form.find('.is-invalid').removeClass('is-invalid');
            $modal.find('.custom-error-alert').remove();

            let firstName = $form.find('input[name="first-name"]').val().trim();
            let phoneNumber = $form.find('input[name="phone-number"]').val().trim();
            let appointmentId = $form.find('input[name="appointment_id"]').val();

            let data = new FormData($form[0]);
            data.append('csrf_token', vars('csrf_token'));

            $.ajax({
                url: $form.attr('action'),
                type: "POST",
                dataType: "json",
                data: data,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $form.find('button[type="submit"]').prop("disabled", true).html('<i class="fa-solid fa-spinner fa-spin me-1"></i> Saving...');
                },
                success: function(response) {
                    $form.find('button[type="submit"]').prop("disabled", false).html('<i class="fa-solid fa-check me-1"></i> Save');
                    if (response && response.success) {
                        $modal.modal("hide");
                        location.reload();
                        setTimeout(function() {
                            $(".alert-success").fadeOut(200);
                        }, 6000);
                        // showToast('updated successfully');
                    } else {
                        showToast('something error');
                        // location.reload();
                    }
                },
                error: function() {
                    $form.find('button[type="submit"]').prop("disabled", false).html('<i class="fa-solid fa-check me-1"></i> Save');
                    // location.reload();
                }
            });
        });

        $(document).on('submit', '.customer-add-form', function(e) {
            let $form = $(this);
            
            $form.find('.errortext').text('');
            $form.find('.form-control').removeClass('is-invalid');

            let $firstNameInput = $('#first-name1');
            let $phoneInput = $('#phone-number1');

           
            if ($firstNameInput.val().trim() === '') {
                return showFieldError($firstNameInput, 'Patient Name is required.', e);
            }

            if ($phoneInput.val().trim() === '') {
                return showFieldError($phoneInput, 'Phone Number is required.', e);
            }

           
            $('#form_csrf_token').val(vars('csrf_token'));
        });


    });
</script>
<?php end_section('scripts'); ?>