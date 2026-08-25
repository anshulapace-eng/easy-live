<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment & Contact Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        body { background: #f8fafc; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; margin: 0; }
        .login-split-card { background: #ffffff; border-radius: 20px; box-shadow: 0 20px 40px -15px rgba(0, 82, 204, 0.07), 0 10px 20px -10px rgba(0, 0, 0, 0.04); overflow: hidden; width: 100%; max-width: 960px; display: flex; flex-direction: row; border: 1px solid rgba(226, 232, 240, 0.8); }
        .login-illustration-side { flex: 1; background: linear-gradient(135deg, #065cdb 0%, #06ff8a80 100%); position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 50px; color: #ffffff; }
        .login-illustration-side::before, .login-illustration-side::after { content: '+'; position: absolute; color: rgba(255, 255, 255, 0.06); font-weight: 800; font-size: 160px; line-height: 1; z-index: 1; user-select: none; }
        .login-illustration-side::before { top: -10px; left: 20px; transform: rotate(12deg); }
        .login-illustration-side::after { bottom: -30px; right: 30px; transform: rotate(-15deg); font-size: 220px; }
        .illustration-content { text-align: center; z-index: 2; max-width: 320px; }
        .illustration-content i { background: rgba(255, 255, 255, 0.1); width: 80px; height: 80px; line-height: 80px; border-radius: 50%; margin-bottom: 24px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); display: inline-block; }
        .illustration-content h3 { font-weight: 700; font-size: 32px; margin-bottom: 16px; letter-spacing: -0.5px; }
        .illustration-content p { font-size: 15px; opacity: 0.88; line-height: 1.6; font-weight: 400; margin: 0; }
        .login-form-side { flex: 1.25; padding: 35px 45px; display: flex; flex-direction: column; background-color: #ffffff; max-height: 92vh; overflow-y: auto; }
        .form-header { margin-bottom: 20px; position: relative; }
        .form-header .badge-tag { display: inline-flex; align-items: center; gap: 6px; background: #e0f2fe; color: #0284c7; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 50px; margin-bottom: 10px; letter-spacing: 0.3px; text-transform: uppercase; }
        .form-header h3 { font-weight: 800; color: #0f172a; font-size: 24px; letter-spacing: -0.8px; margin-bottom: 4px; }
        .form-control, .form-select { padding: 11px 16px 11px 42px; font-size: 0.9rem; border-radius: 10px; border: 1.5px solid #cbd5e1; background-color: #f8fafc; }
        .form-control:focus, .form-select:focus { border-color: #0052cc; background-color: #ffffff; box-shadow: 0 0 0 4px rgba(0, 82, 204, 0.1); }
        .input-group { position: relative; }
        .input-group>.input-group-text { position: absolute; left: 0; top: 0; bottom: 0; z-index: 10; background: transparent !important; border: none; padding-left: 16px; color: #94a3b8; }
        .input-group:focus-within .input-group-text { color: #0052cc; }
        .btn-submit { background-color: #0052cc; border: none; padding: 12px; font-size: 1rem; font-weight: 700; border-radius: 10px; box-shadow: 0 4px 14px rgba(0, 82, 204, 0.28); transition: all 0.2s; color: #ffffff; width: 100%; }
        .btn-submit:hover { background-color: #0043a8; box-shadow: 0 6px 20px rgba(0, 82, 204, 0.38); transform: translateY(-1px); }
        .btn-pdf { background-color: #16a34a; border: none; padding: 12px; font-size: 1rem; font-weight: 700; border-radius: 10px; box-shadow: 0 4px 14px rgba(22, 163, 74, 0.28); transition: all 0.2s; color: #ffffff; width: 100%; }
        .btn-pdf:hover { background-color: #15803d; box-shadow: 0 6px 20px rgba(22, 163, 74, 0.38); transform: translateY(-1px); }
        #customer_search_results { position: absolute; width: 100%; max-height: 180px; overflow-y: auto; z-index: 1000; background: #fff; border: 1px solid #cbd5e1; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); display: none; top: 100%; left: 0; }
        .customer-item { padding: 10px 15px; cursor: pointer; border-bottom: 1px solid #f1f5f9; font-size: 13.5px; }
        .customer-item:hover { background-color: #f8fafc; }
        
        .radio-options-wrapper { 
    display: flex; 
    gap: 10px; 
}
.custom-radio-card { 
    flex: 1; 
    border: 1.5px solid #cbd5e1; 
    border-radius: 8px; 
    padding: 6px 12px; /* Padding kam kar di hai */
    cursor: pointer; 
    transition: all 0.2s; 
    background: #f8fafc; 
    text-align: center; 
}
.custom-radio-card:hover { 
    border-color: #94a3b8; 
}
.form-check-input:checked + .custom-radio-card { 
    border-color: #0052cc; 
    background: #eff6ff; 
    box-shadow: 0 0 0 3px rgba(0, 82, 204, 0.1); 
}
/* Icon aur text ka size chota karne ke liye */
.custom-radio-card i { 
    font-size: 1rem !important; 
    margin-bottom: 2px !important; 
}
.custom-radio-card span { 
    font-size: 0.8rem !important; 
}
        
        @media (max-width: 768px) { .login-split-card { flex-direction: column; max-width: 460px; margin: 20px; } .login-illustration-side { display: none; } .login-form-side { padding: 30px 20px; max-height: none; } }
    </style>
</head>

<body>

    <div class="login-split-card mx-auto">
        <!-- Left Side: Illustration Panel -->
        <div class="login-illustration-side">
            <div class="illustration-content">
                <i class="fas fa-calendar-check fa-2x"></i>
                <h3>Dr. Sahu<br>Clinic</h3>
                <p>Book your medical appointments instantly, select your preferred time slots, and manage your visits seamlessly.</p>
            </div>
        </div>

        <!-- Right Side: Form Panel -->
        <div class="login-form-side">
            <!-- Form Header -->
            <div class="form-header text-center" id="form_header_section">
                <h3>Book an Appointment</h3>
                <div class="badge-tag">
                    <i class="fa-solid fa-calendar-plus"></i> Online Booking
                </div>
            </div>

            <!-- Error Alert -->
            <div id="form_error_alert" class="alert alert-danger alert-dismissible fade show shadow-sm mb-3 py-2 small" role="alert" style="display: none;">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                <span id="error_message_text"></span>
            </div>

            <!-- Success Summary Card -->
            <div id="appointment_success_summary" style="display: none;">
                <div id="pdf_printable_area">
                    <div class="text-center mb-3">
                        <div style="width: 50px; height: 50px; background-color: #dcfce7; color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px auto; font-size: 22px;">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <h4 style="font-weight: 700; color: #0f172a; font-size: 20px; margin-bottom: 2px;">Appointment Booked!</h4>
                        <p class="text-muted small mb-0">Dr. Sahu Clinic - Appointment Receipt</p>
                    </div>

                    <div class="card border-0 shadow-sm bg-light p-3 rounded-4 mb-3">
                        <ul class="list-unstyled mb-0" style="font-size: 13.5px;">
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted fw-semibold"><i class="fa-solid fa-user-doctor me-2 text-primary"></i> Doctor:</span>
                                <strong id="summary_provider" class="text-dark"></strong>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted fw-semibold"><i class="fa-solid fa-user me-2 text-primary"></i> Patient Name:</span>
                                <strong id="summary_patient" class="text-dark"></strong>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted fw-semibold"><i class="fa-solid fa-user-pen me-2 text-primary"></i> Contact Name:</span>
                                <strong id="summary_contact" class="text-dark"></strong>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted fw-semibold"><i class="fa-solid fa-phone me-2 text-primary"></i> Phone:</span>
                                <strong id="summary_phone" class="text-dark"></strong>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted fw-semibold"><i class="fa-solid fa-calendar-days me-2 text-primary"></i> Date & Time:</span>
                                <strong id="summary_datetime" class="text-dark"></strong>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted fw-semibold"><i class="fa-solid fa-stethoscope me-2 text-primary"></i> Mode:</span>
                                <strong id="summary_mode" class="text-dark"></strong>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" id="download_pdf_btn" class="btn-pdf flex-fill">
                        <i class="fa-solid fa-file-pdf me-2"></i> Download PDF
                    </button>
                    <button type="button" class="btn-submit flex-fill" onclick="location.reload();">
                        <i class="fa-solid fa-plus me-2"></i> New Booking
                    </button>
                </div>
            </div>

            <!-- Form Start -->
            <form id="appointment_main_form" action="<?= site_url('home/submit_appointment'); ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= vars('csrf_token'); ?>">
                <input type="hidden" name="customer_type" id="customer_type" value="new">

                <div class="row g-3">
                    <!-- Top Tabs -->
                    <div class="col-12">
                        <ul class="nav nav-pills nav-fill p-1 bg-light rounded-3" id="bookingTypeTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold py-2 small rounded-2" id="new-tab" data-bs-toggle="tab" data-bs-target="#new-customer-pane" type="button" role="tab">
                                    <i class="fa-solid fa-user-plus me-1"></i> New Customer
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold py-2 small rounded-2" id="existing-tab" data-bs-toggle="tab" data-bs-target="#existing-customer-pane" type="button" role="tab">
                                    <i class="fa-solid fa-user-check me-1"></i> Existing Customer
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Search Pane -->
                    <div class="col-12 tab-content p-0" id="customerSearchContainer">
                        <div class="tab-pane fade" id="existing-customer-pane" role="tabpanel">
                            <div class="position-relative">
                                <label class="form-label small fw-bold text-secondary mb-1">Search by Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                                    <input type="text" id="customer_phone_search" class="form-control" placeholder="Enter phone number to search...">
                                </div>
                                <div id="customer_search_results"></div>
                            </div>

                            <div id="selected_customer_info" class="mt-2" style="display: none;">
                                <div class="alert alert-success p-2 small mb-0">
                                    <strong>Selected:</strong> <span id="disp_cust_name"></span> (<span id="disp_cust_phone"></span>)
                                    <input type="hidden" name="existing_customer_id" id="existing_customer_id">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 d-none">
                        <select name="id_users_provider" id="id_users_provider" class="form-select" required>
                            <?php if (!empty($available_providers)): ?>
                                <?php foreach ($available_providers as $provider): ?>
                                    <option value="<?= $provider['id']; ?>" <?= ($provider['id'] === 19) ? 'selected' : ''; ?>>
                                        <?= trim(($provider['first_name'] ?? '') . ' ' . ($provider['last_name'] ?? '')); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Existing Customer fields -->
                    <div id="existing_customer_fields_wrapper" class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary mb-1">Patient Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                <input type="text" name="first_name" id="new_first_name" class="form-control" placeholder="Enter patient name">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary mb-1">Phone Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                <input type="tel" name="phone" id="form_phone" class="form-control" placeholder="9876543210">
                            </div>
                        </div>

                        <div class="col-12" id="contact_checkbox_wrapper" style="display: none;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="show_last_name_check">
                                <label class="form-check-label small text-secondary fw-semibold" for="show_last_name_check">
                                    Contact name is different from patient name
                                </label>
                            </div>
                        </div>

                        <div class="col-12" id="last_name_wrapper" style="display: none;">
                            <label class="form-label small fw-bold text-secondary mb-1">Contact Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-user-pen"></i></span>
                                <input type="text" name="last_name" id="last_name_input" class="form-control" placeholder="Enter contact name">
                            </div>
                        </div>
                    </div>
                    
                    <!-- NEW: Appointment Type Selection -->
                    <div class="col-12 mt-3">
                        <label class="form-label small fw-bold text-secondary mb-1">Consultation Mode <span class="text-danger">*</span></label>
                        <div class="radio-options-wrapper">
                            <label class="form-check m-0 p-0 flex-fill d-flex">
                                <input class="form-check-input d-none" type="radio" name="appointment_type" value="in-clinic" checked>
                                <div class="custom-radio-card">
                                    <i class="fa-solid fa-house-medical text-primary d-block mb-1 fs-5"></i>
                                    <span class="fw-bold small d-block">In-Clinic</span>
                                </div>
                            </label>
                            <label class="form-check m-0 p-0 flex-fill d-flex">
                                <input class="form-check-input d-none" type="radio" name="appointment_type" value="video">
                                <div class="custom-radio-card">
                                    <i class="fa-solid fa-video text-primary d-block mb-1 fs-5"></i>
                                    <span class="fw-bold small d-block">Video Call</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Calendar Date Picker -->
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary mb-1">Select Date <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                            <input type="date" name="appointment_date" id="appointment_date" class="form-control" required
                                min="<?= date('Y-m-d'); ?>"
                                max="<?= date('Y-m-d', strtotime('+14 days')); ?>">
                        </div>
                    </div>

                    <!-- Time Select -->
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary mb-1">Select Time Slot <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
                            <select name="appointment_time" id="appointment_time" class="form-select" required>
                                <option value="" selected disabled>Choose date first...</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold text-secondary mb-1">Additional Notes</label>
                        <textarea name="note" id="appointment_note" class="form-control" style="padding-left: 16px !important;" rows="2" placeholder="Write any specific requirements..."></textarea>
                    </div>

                    <div class="col-12 mt-2">
                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-check-circle me-2"></i> Confirm Booking
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        let currentDaySlots = []; // Global variable to store fetched slots

        // JS Function to render Time Slots based on Appointment Type selection
        function renderTimeSlots() {
            let selectedType = $('input[name="appointment_type"]:checked').val();
            let timeslot = $("#appointment_time");
            
            timeslot.empty();
            timeslot.append('<option value="" selected disabled>Choose time...</option>');

            if (currentDaySlots.length === 0) return;

            let filteredSlots = currentDaySlots.filter(s => s.type === selectedType);

            if (filteredSlots.length > 0) {
                filteredSlots.forEach(function(slot) {
                    let disabledAttr = slot.available ? '' : 'disabled class="text-muted bg-light"';
                    timeslot.append(`
                        <option value="${slot.start}" ${disabledAttr}>
                            ${slot.label}
                        </option>
                    `);
                });
            } else {
                timeslot.append('<option value="" disabled>No slots available for this mode</option>');
            }
        }

        $(document).ready(function() {
            $('#new_first_name').on('blur', function() {
                let patientName = $(this).val().trim();
                if (patientName.length > 0) {
                    $('#contact_checkbox_wrapper').slideDown(200);
                } else {
                    $('#contact_checkbox_wrapper').slideUp(200);
                    $('#show_last_name_check').prop('checked', false).trigger('change');
                }
            });

            $('#show_last_name_check').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#last_name_wrapper').slideDown(200);
                    $('#last_name_input').attr('required', 'required');
                } else {
                    $('#last_name_wrapper').slideUp(200);
                    $('#last_name_input').removeAttr('required');
                    $('#last_name_input').val('');
                }
            });

            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                if ($(e.target).attr('id') === 'existing-tab') {
                    $('#customer_type').val('existing');
                    $('#new_first_name').removeAttr('required');
                    $('#form_phone').attr('readonly', true);
                    $('#contact_checkbox_wrapper').show();
                    $('#existing_customer_fields_wrapper').hide();
                } else {
                    $('#customer_type').val('new');
                    $('#new_first_name').attr('required', 'required');
                    $('#form_phone').removeAttr('readonly');
                    $('#selected_customer_info').hide();
                    $('#existing_customer_id').val('');
                    $('#existing_customer_fields_wrapper').show();
                }
            });

            let fetchedCustomers = [];
            $('#customer_phone_search').on('keyup', function() {
                let query = $(this).val().trim();
                if (query.length > 1 && query.length <= 10) {
                    $.ajax({
                        url: '<?= site_url("home/search_customer_ajax"); ?>',
                        type: 'GET',
                        data: { phone: query },
                        dataType: 'json',
                        success: function(response) {
                            fetchedCustomers = response;
                            let resultsBox = $('#customer_search_results');
                            resultsBox.empty().show();
                            if (response.length > 0) {
                                response.forEach(function(cust) {
                                    let fullName = (cust.first_name || '') + ' ' + (cust.last_name || '');
                                    resultsBox.append(`
                                    <div class="customer-item" data-id="${cust.id}">
                                        <strong>${fullName}</strong><br>
                                        <small class="text-muted"><i class="fa-solid fa-phone me-1"></i>${cust.phone_number}</small>
                                    </div>
                                `);
                                });
                            } else {
                                resultsBox.append('<div class="p-2 text-muted small text-center">No customer found</div>');
                            }
                        }
                    });
                } else {
                    $('#customer_search_results').hide();
                }
            });

            $(document).on('click', '.customer-item', function() {
                let customerId = $(this).data('id');
                let cust = fetchedCustomers.find(c => c.id == customerId);
                if (cust) {
                    let firstName = cust.first_name || '';
                    let lastName = cust.last_name || '';
                    let fullName = firstName + ' ' + lastName;
                    let phone = cust.phone_number || '';

                    $('#existing_customer_id').val(cust.id);
                    $('#new_first_name').val(firstName).trigger('blur');
                    $('#form_phone').val(phone);
                    $('#existing_customer_fields_wrapper').slideDown(200);
                    $('#contact_checkbox_wrapper').show();

                    if (lastName && lastName.trim() !== "") {
                        $('#show_last_name_check').prop('checked', true).trigger('change');
                        $('#last_name_input').val(lastName);
                    } else {
                        $('#show_last_name_check').prop('checked', false).trigger('change');
                        $('#last_name_input').val('');
                    }

                    $('#disp_cust_name').text(fullName);
                    $('#disp_cust_phone').text(phone);
                    $('#selected_customer_info').show();
                    $('#customer_search_results').hide();
                    $('#customer_phone_search').val('');
                }
            });

            $(document).click(function(e) {
                if (!$(e.target).closest('#customer_phone_search, #customer_search_results').length) {
                    $('#customer_search_results').hide();
                }
            });

            // Re-render slots if Appointment Type changes
            $('input[name="appointment_type"]').on('change', function() {
                if(currentDaySlots.length > 0) {
                    renderTimeSlots();
                }
            });

            // Date Change
            $("#appointment_date").on('change', function() {
                let selectdate = $(this).val();
                let timeslot = $("#appointment_time");

                if (!selectdate) return;
                timeslot.html('<option value="" disabled selected>Loading slots...</option>');

                $.ajax({
                    url: "<?= site_url('home') ?>",
                    type: "GET",
                    data: { date: selectdate },
                    dataType: 'json',
                    success: function(slots) {
                        currentDaySlots = slots; // Save to global
                        renderTimeSlots();       // Render based on selected Type
                    },
                    error: function() {
                        timeslot.html('<option value="" disabled>Failed to load slots</option>');
                    }
                });
            });

            // Submit Form
            $('#appointment_main_form').on('submit', function(e) {
                e.preventDefault();

                let patientName = $('#new_first_name').val().trim();
                let phone = $('#form_phone').val().trim();
                let appointmentDate = $('#appointment_date').val().trim();
                let appointmentTime = $('#appointment_time').val().trim();
                let provider = $('#id_users_provider').val().trim();
                let appointmentType = $('input[name="appointment_type"]:checked').val();

                let errorMessage = "";

                if (!patientName) {
                    errorMessage = "Patient Name field is required.";
                    $('#new_first_name').focus();
                } else if (!phone) {
                    errorMessage = "Phone Number field is required.";
                    $('#form_phone').focus();
                } else if (!appointmentDate) {
                    errorMessage = "Appointment Date field is required.";
                    $('#appointment_date').focus();
                } else if (!appointmentTime || appointmentTime === "") {
                    errorMessage = "Please select a valid Time Slot.";
                    $('#appointment_time').focus();
                } else if (!provider || provider === "") {
                    errorMessage = "Please select a provider.";
                    $('#id_users_provider').focus();
                }

                if (errorMessage !== "") {
                    $('#error_message_text').text(errorMessage);
                    $('#form_error_alert').fadeIn(200);
                    setTimeout(function() {
                        $('#form_error_alert').fadeOut(200);
                    }, 4000);
                    return;
                }

                let formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#appointment_main_form').hide();
                            $('#form_header_section').hide();

                            let providerName = $('#id_users_provider option:selected').text().trim();
                            let contactName = $('#show_last_name_check').is(':checked') ? $('#last_name_input').val() : patientName;
                            
                            let modeText = (appointmentType === 'video') ? 'Online (Video Call)' : 'In-Person (Clinic Visit)';

                            $('#summary_provider').text(providerName);
                            $('#summary_patient').text(patientName);
                            $('#summary_contact').text(contactName);
                            $('#summary_phone').text(phone);
                            $('#summary_datetime').text(appointmentDate + ' at ' + appointmentTime);
                            $('#summary_mode').text(modeText);

                            $('#appointment_success_summary').fadeIn(300);
                        } else {
                            $('#error_message_text').text(response.message || 'Failed to book appointment.');
                            $('#form_error_alert').fadeIn(200);
                            setTimeout(function() { $('#form_error_alert').fadeOut(200); }, 8000);
                        }
                    },
                    error: function() {
                        $('#error_message_text').text('Failed to book appointment. Please try again.');
                        $('#form_error_alert').fadeIn(200);
                    }
                });
            });

            // PDF Download
            $('#download_pdf_btn').on('click', function() {
                let element = document.getElementById('pdf_printable_area');
                let opt = { margin: 10, filename: 'Appointment_Receipt.pdf', image: { type: 'jpeg', quality: 0.98 }, html2canvas: { scale: 2 }, jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' } };
                html2pdf().from(element).set(opt).save();
            });
        });
    </script>

</body>
</html>