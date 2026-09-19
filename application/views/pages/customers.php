<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>
<!-- FontAwesome & Google Fonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">


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
                    <table id="dataTable" class="table table-custom table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th class="ps-3" style="width: 40px;">S.No</th>
                                <th>Patient Name</th>
                                <th>Contact Name</th>
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
                                            <div class="fw-medium text-dark"><?= html_escape(($row['first_name'] ?? '')); ?></div>
                                            <?php if (!empty($row['email'])): ?>
                                                <div class="text-muted" style="font-size: 11px;"><?= html_escape($row['email']); ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="fw-medium text-dark"><?= html_escape(($row['last_name'] ?? '')); ?></div>
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
                                                <?php endif; ?> <br>
                                                (<?= $row['appointment_status'] ?>)
                                            <?php else: ?>
                                                <span class="text-muted fst-italic">No Appointment</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="pe-3 text-center">
                                            <button type="button" class="btn btn-sm btn-light border text-primary px-2 py-1 edit-customer-btn" data-customer-id="<?= $row['id']; ?>" title="Edit Customer" style="font-size: 11px; border-radius: 4px;">
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

<?php
// 1. Pehle hi saare customers ka option HTML ek variable me bana lein
$customer_options_html = '<option value="">Select customer from list...</option>';
if (!empty($customers)) {
    foreach ($customers as $cust) {
        $fname = html_escape($cust['first_name'] ?? '');
        $lname = html_escape($cust['last_name'] ?? '');
        $phone = html_escape($cust['phone_number'] ?? 'No Phone');
        
        $customer_options_html .= '<option style="font-size: 10px;" value="' . $cust['id'] . '" ' .
            'data-firstname="' . $fname . '" ' . 
            'data-lastname="' . $lname . '" ' . 
            'data-phone="' . html_escape($cust['phone_number'] ?? '') . '">' . 
            $fname . ' ' . $lname . ' (' . $phone . ')' . 
            '</option>';
    }
}
?>

<!-- Modals for Editing Customers & Appointments -->
<!-- Single Dynamic Edit Modal -->
<div class="modal fade" id="sharedCustomerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom px-2 py-2 bg-primary text-white">
                <h5 class="modal-title fw-bold" style="font-size: 16px;">
                    <i class="fa-solid fa-pen-to-square text-white me-2"></i> Edit Appointment & Customer Details
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= site_url('customers/update') ?>" method="POST" class="customer-update-form">
                <div class="modal-body p-4 bg-light" id="shared-modal-body-content">
                    <!-- AJAX ke zariye form ke fields yahan dynamically load honge -->
                    <div class="text-center py-4">
                        <i class="fa-solid fa-spinner fa-spin fa-2x text-primary"></i>
                        <p class="text-muted mt-2 mb-0" style="font-size: 12px;">Loading details...</p>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3 bg-white">
                    <button type="button" class="btn btn-light border px-4 fw-semibold text-secondary shadow-sm" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm" style="border-radius: 8px;"><i class="fa-solid fa-check me-1"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#success-alert').fadeOut(200, function() {
                $(this).remove();
            });
        }, 6000);

        $(document).on('click', '.edit-customer-btn', function() {
    let customerId = $(this).data('customer-id');
    let $modal =$('#sharedCustomerModal');
    let $modalBody =$('#shared-modal-body-content');

    // 1. Pehle modal khol dein aur loading state dikhayein
    $modal.modal('show');$modalBody.html(`
        <div class="text-center py-4">
            <i class="fa-solid fa-spinner fa-spin fa-2x text-primary"></i>
            <p class="text-muted mt-2 mb-0" style="font-size: 12px;">Loading details...</p>
        </div>
    `);

   
    $.ajax({
        url: "<?= site_url('customers/get_edit_form'); ?>", 
        type: "GET",
        data: { 
            customer_id: customerId ,
            csrf_token: vars('csrf_token')
        },
        success: function(response) {
          
            $modalBody.html(response);

            // Agar andar Select2 ya kuch initialize karna ho toh yahan kar sakte hain
            $modal.find('.select2-enable').each(function() {
                if (!$(this).hasClass("select2-hidden-accessible")) {
                    $(this).select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $modal
                    });
                }
            });
        },
        error: function() {
            $modalBody.html('<div class="alert alert-danger text-center mb-0">Failed to load customer details. Please try again.</div>');
        }
    });
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