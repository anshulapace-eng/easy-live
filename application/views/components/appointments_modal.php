<?php
/**
 * Local variables.
 *
 * @var array $available_services
 * @var array $appointment_status_options
 * @var array $timezones
 * @var array $require_first_name
 * @var array $require_last_name
 * @var array $require_email
 * @var array $require_phone_number
 * @var array $require_address
 * @var array $require_city
 * @var array $require_zip_code
 * @var array $require_notes
 */
?>
<div id="appointments-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0052cc; color: #ffffff;">
                <h3 class="modal-title"><?= lang('edit_appointment_title') ?></h3>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="modal-message alert d-none"></div>

                <form>
                    <fieldset>
                        <h5 class="mb-3 fw-light"><?= lang('appointment_details_title') ?></h5>

                        <input id="appointment-id" type="hidden">

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3" style="display: none;">
                                    <label for="select-service" class="form-label">
                                        <?= lang('service') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="select-service" class="required form-select">
                                        <?php
                                        $has_category = false;

                                        foreach ($available_services as $service) {
                                            if (!empty($service['service_category_id'])) {
                                                $has_category = true;
                                                break;
                                            }
                                        }

                                        if ($has_category) {
                                            $grouped_services = [];

                                            foreach ($available_services as $service) {
                                                if (!empty($service['service_category_id'])) {
                                                    if (!isset($grouped_services[$service['service_category_name']])) {
                                                        $grouped_services[$service['service_category_name']] = [];
                                                    }

                                                    $grouped_services[$service['service_category_name']][] = $service;
                                                }
                                            }

                                            $grouped_services['uncategorized'] = [];

                                            foreach ($available_services as $service) {
                                                if ($service['service_category_id'] == null) {
                                                    $grouped_services['uncategorized'][] = $service;
                                                }
                                            }

                                            foreach ($grouped_services as $key => $group) {
                                                $group_label =
                                                        $key !== 'uncategorized'
                                                            ? e($group[0]['service_category_name'])
                                                            : 'Uncategorized';

                                                if (count($group) > 0) {
                                                    echo '<optgroup label="' . $group_label . '">';

                                                    foreach ($group as $service) {
                                                        echo '<option value="' .
                                                            $service['id'] .
                                                            '">' .
                                                            e($service['name']) .
                                                            '</option>';
                                                    }

                                                    echo '</optgroup>';
                                                }
                                            }
                                        } else {
                                            foreach ($available_services as $service) {
                                                echo '<option value="' .
                                                    $service['id'] .
                                                    '">' .
                                                    e($service['name']) .
                                                    '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="select-provider" class="form-label">
                                        <?= lang('provider') ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="select-provider" class="required form-select"></select>
                                </div>

                                <div class="mb-3 d-none">
                                    <?php component('color_selection', ['attributes' => 'id="appointment-color"']); ?>
                                </div>

                                <div class="mb-3 d-none">
                                    <label for="appointment-location" class="form-label">
                                        <?= lang('location') ?>
                                    </label>
                                    <input id="appointment-location" class="form-control">
                                </div>

                                <div class="mb-3 d-none">
                                    <label for="appointment-meeting-link" class="form-label">
                                        <?= lang('meeting_link') ?>
                                    </label>
                                    <input id="appointment-meeting-link" class="form-control" placeholder="https://">
                                </div>

                                <div class="mb-3">
                                    <label for="appointment-status" class="form-label">
                                        <?= lang('status') ?>
                                    </label>
                                    <select id="appointment-status" class="form-select">
                                        <?php foreach ($appointment_status_options as $appointment_status_option): ?>
                                            <option value="<?= e($appointment_status_option) ?>">
                                                <?= e($appointment_status_option) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="start-datetime"
                                           class="form-label"><?= lang('start_date_time') ?></label>
                                    <input id="start-datetime" class="required form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="end-datetime" class="form-label"><?= lang('end_date_time') ?></label>
                                    <input id="end-datetime" class="required form-control">
                                </div>

                                <div class="mb-3 d-none">
                                    <label class="form-label">
                                        <?= lang('timezone') ?>
                                    </label>

                                    <div
                                        class="border rounded d-flex justify-content-between align-items-center bg-light timezone-info">
                                        <div class="border-end w-50 p-1 text-center">
                                            <small>
                                                <?= lang('provider') ?>:
                                                <span class="provider-timezone">
                                                    -
                                                </span>
                                            </small>
                                        </div>
                                        <div class="w-50 p-1 text-center">
                                            <small>
                                                <?= lang('current_user') ?>:
                                                <span>
                                                    <?= $timezones[session('timezone', 'UTC')] ?>
                                                </span>
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 d-none">
                                    <label for="appointment-notes" class="form-label">
                                        <?= lang('notes') ?>
                                        <?php if ($require_notes): ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <textarea id="appointment-notes" class="<?= $require_notes
                                        ? 'required'
                                        : '' ?> form-control" rows="3"></textarea>
                                </div>

                            </div>

                             <div class="col-12 col-sm-6">

                                <div class="mb-3">
                                    <label for="appointment-type" class="form-label">
                                        Appointment Types <span class="text-danger">*</span>
                                    </label>
                                    <select id="appointment-type" name="appointment_type" class="form-select required">
                                        <option value="in-clinic" selected>In Clinic (Face to face)</option>
                                        <option value="video">Video Call (Online video)</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </fieldset>

                    <br>

                    <fieldset>
                        <h5 class="mb-3 fw-light">
                            <?= lang('customer_details_title') ?>
                            <button id="new-customer" class="btn btn-outline-secondary btn-sm" type="button"
                                    data-tippy-content="<?= lang('clear_fields_add_existing_customer_hint') ?>">
                                <i class="fas fa-plus-square me-2"></i>
                                <?= lang('new') ?>
                            </button>
                            <button id="select-customer" class="btn btn-outline-secondary btn-sm" type="button"
                                    data-tippy-content="<?= lang('pick_existing_customer_hint') ?>">
                                <i class="fas fa-hand-pointer me-2"></i>
                                <span>
                                    <?= lang('select') ?>
                                </span>
                            </button>

                            <input id="filter-existing-customers"
                                    placeholder="<?= lang('type_to_filter_customers') ?>"
                                    style="display: none;" class="input-sm form-control">
                        </h5>

                        <div id="existing-customers-list" style="display: none;"></div>

                        <input id="customer-id" type="hidden">

                        <div class="row">

                            <!-- Patient Name Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="first-name" class="form-label">
                                        Patient Name
                                        <?php if ($require_first_name): ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input type="text" id="first-name"
                                           class="<?= $require_first_name ? 'required' : '' ?> form-control"
                                           maxlength="100"/>
                                </div>
                            </div>

                            <!-- Contact Name Column with Checkbox aligned to the top-right -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label for="last-name" class="form-label mb-0">
                                            Contact Name
                                            <?php if ($require_last_name): ?>
                                                <span class="text-danger">*</span>
                                            <?php endif; ?>
                                        </label>
                                        <div class="form-check mb-0">
                                            <input type="checkbox" class="form-check-input border-dark" id="same-as-patient">
                                            <label class="form-check-label small" for="same-as-patient">Same as Patient Name</label>
                                        </div>
                                    </div>
                                    <input type="text" id="last-name"
                                           class="<?= $require_last_name ? 'required' : '' ?> form-control"
                                           maxlength="100"/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone-number" class="form-label">
                                        <?= lang('phone_number') ?>
                                        <?php if ($require_phone_number): ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input type="text" id="phone-number" maxlength="60"
                                           class="<?= $require_phone_number ? 'required' : '' ?> form-control"/>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="mb-3 d-none">
                                    <label for="email" class="form-label">
                                        <?= lang('email') ?>
                                        <?php if ($require_email): ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input type="text" id="email"
                                           class="<?= $require_email ? 'required' : '' ?> form-control"
                                           maxlength="120"/>
                                </div>

                                <div class="mb-3 d-none">
                                    <label class="form-label" for="language">
                                        <?= lang('language') ?>
                                        <span class="text-danger" hidden>*</span>
                                    </label>
                                    <select id="language" class="form-select required">
                                        <?php foreach (vars('available_languages') as $available_language): ?>
                                            <option value="<?= $available_language ?>">
                                                <?= ucfirst($available_language) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <?php component('custom_fields'); ?>

                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3 d-none">
                                    <label for="address" class="form-label">
                                        <?= lang('address') ?>
                                        <?php if ($require_address): ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input type="text" id="address"
                                           class="<?= $require_address ? 'required' : '' ?> form-control"
                                           maxlength="120"/>
                                </div>

                                <div class="mb-3 d-none">
                                    <label for="city" class="form-label">
                                        <?= lang('city') ?>
                                        <?php if ($require_city): ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input type="text" id="city"
                                           class="<?= $require_city ? 'required' : '' ?> form-control"
                                           maxlength="120"/>
                                </div>

                                <div class="mb-3 d-none">
                                    <label for="zip-code" class="form-label">
                                        <?= lang('zip_code') ?>
                                        <?php if ($require_zip_code): ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input type="text" id="zip-code"
                                           class="<?= $require_zip_code ? 'required' : '' ?> form-control"
                                           maxlength="120"/>
                                </div>

                                <div class="mb-3 d-none">
                                    <label class="form-label" for="timezone">
                                        <?= lang('timezone') ?>
                                        <span class="text-danger" hidden>*</span>
                                    </label>
                                    <?php component('timezone_dropdown', [
                                        'attributes' => 'id="timezone" class="form-select required"',
                                        'grouped_timezones' => vars('grouped_timezones'),
                                    ]); ?>
                                </div>

                                <div class="mb-3 d-none">
                                    <label for="customer-notes" class="form-label">
                                        <?= lang('notes') ?>
                                    </label>
                                    <textarea id="customer-notes" rows="3" class="form-control"></textarea>
                                </div>

                            </div>
                        </div>
                    </fieldset>

                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= lang('cancel') ?>
                </button>
                <button id="save-appointment" class="btn btn-primary" style="background: #0052cc;">
                    <i class="fas fa-check-square me-2"></i>
                    <?= lang('save') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript functionality for the checkbox -->
<script>
    document.getElementById('same-as-patient').addEventListener('change', function() {
        const patientNameInput = document.getElementById('first-name');
        const contactNameInput = document.getElementById('last-name');
        
        if (this.checked) {
            contactNameInput.value = patientNameInput.value;
        }
    });

    // document.getElementById('first-name').addEventListener('input', function() {
    //     const checkbox = document.getElementById('same-as-patient');
    //     if (checkbox.checked) {
    //         document.getElementById('last-name').value = this.value;
    //     }
    // });
</script>

<!-- Custom Notification Prompt Modal (Matched with image_24b69e.png) -->
<div class="modal fade" id="customNotifyModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px; margin: auto;">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 40px -15px rgba(0, 82, 204, 0.15); overflow: hidden; background: #ffffff;">

            <!-- Modal Header with #0052cc Blue Theme -->
            <div class="modal-header" style="background-color: #0052cc !important; border: none; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;">
                <h5 class="modal-title" style="margin: 0; font-size: 16px; font-weight: 700; color: #ffffff;">
                    New Appointment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0) invert(1); cursor: pointer;"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="padding: 25px 20px; font-size: 15px; color: #334155; font-weight: 500; text-align: left;">
                Would you like to send out a notification about this change?
            </div>

            <!-- Modal Footer with Action Buttons -->
            <div class="modal-footer border-0" style="padding: 10px 20px 20px 20px; display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" id="btn-notify-no" class="btn" style="background-color: #0052cc; border-color: #0052cc; color: #ffffff; font-weight: 600; padding: 8px 24px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 82, 204, 0.25);">
                    No
                </button>
                <button type="button" id="btn-notify-yes" class="btn" style="background-color: #16a34a; border-color: #16a34a; color: #ffffff; font-weight: 600; padding: 8px 24px; border-radius: 8px; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);">
                    Yes
                </button>
            </div>

        </div>
    </div>
</div>

<?php section('scripts'); ?>

<script>
/* ----------------------------------------------------------------------------
 * Easy!Appointments - Online Appointment Scheduler
 *
 * @package    EasyAppointments
 * @author     A.Tselegidis <alextselegidis@gmail.com>
 * @copyright  Copyright (c) Alex Tselegidis
 * @license    https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link       https://easyappointments.org
 * @since      v1.5.0
 * ---------------------------------------------------------------------------- */

/**
 * Appointments modal component.
 *
 * This module implements the appointments modal functionality.
 *
 * Old Name: BackendCalendarAppointmentsModal
 */
App.Components.AppointmentsModal = (function () {
    const $appointmentsModal = $('#appointments-modal');
    const $startDatetime = $('#start-datetime');
    const $endDatetime = $('#end-datetime');
    const $filterExistingCustomers = $('#filter-existing-customers');
    const $customerId = $('#customer-id');
    const $firstName = $('#first-name');
    const $lastName = $('#last-name');
    const $email = $('#email');
    const $phoneNumber = $('#phone-number');
    const $address = $('#address');
    const $city = $('#city');
    const $zipCode = $('#zip-code');
    const $language = $('#language');
    const $timezone = $('#timezone');
    const $customerNotes = $('#customer-notes');
    const $selectCustomer = $('#select-customer');
    const $saveAppointment = $('#save-appointment');
    const $appointmentId = $('#appointment-id');
    const $appointmentLocation = $('#appointment-location');
    const $appointmentMeetingLink = $('#appointment-meeting-link');
    const $appointmentStatus = $('#appointment-status');
    const $appointmentType = $('#appointment-type'); // Select field for type
    const $appointmentColor = $('#appointment-color');
    const $appointmentNotes = $('#appointment-notes');
    const $reloadAppointments = $('#reload-appointments');
    const $selectFilterItem = $('#select-filter-item');
    const $selectService = $('#select-service');
    const $selectProvider = $('#select-provider');
    const $insertAppointment = $('#insert-appointment');
    const $existingCustomersList = $('#existing-customers-list');
    const $newCustomer = $('#new-customer');
    const $customField1 = $('#custom-field-1');
    const $customField2 = $('#custom-field-2');
    const $customField3 = $('#custom-field-3');
    const $customField4 = $('#custom-field-4');
    const $customField5 = $('#custom-field-5');

    const moment = window.moment;

    let pendingAppointmentData = null;
    let pendingCustomerData = null;

    /**
     * Update the displayed timezone.
     */
    function updateTimezone() {
        const providerId = $selectProvider.val();

        const provider = vars('available_providers').find(
            (availableProvider) => Number(availableProvider.id) === Number(providerId),
        );

        if (provider && provider.timezone) {
            $('.provider-timezone').text(vars('timezones')[provider.timezone]);
        }
    }

    /**
     * Check selected time and hide/show 'In Clinic' option.
     * 9:00 AM = 540 minutes, 10:30 AM = 630 minutes
     */
    function checkTimeAndAdjustType() {
        const startDateTimeObject = App.Utils.UI.getDateTimePickerValue($startDatetime);
        if (!startDateTimeObject) return;

        const hours = startDateTimeObject.getHours();
        const minutes = startDateTimeObject.getMinutes();
        const timeInMinutes = (hours * 60) + minutes;

        // Check if time is between 9:00 (540) and 10:30 (630)
        // if (timeInMinutes >= 540 && timeInMinutes <= 630) {
        //     // Show only Video Call
        //     $appointmentType.html('<option value="video" selected>Video Call (Online video)</option>');
        // } else {
        //     // Show both options for other timings
        //     const currentSelection = $appointmentType.val();
        //     $appointmentType.html(`
        //         <option value="in-clinic">In Clinic (Face to face)</option>
        //         <option value="video">Video Call (Online video)</option>
        //     `);
        //     // Restore previous selection if exists, else default to in-clinic
        //     if (currentSelection === 'video' || currentSelection === 'in-clinic') {
        //         $appointmentType.val(currentSelection);
        //     } else {
        //         $appointmentType.val('in-clinic');
        //     }
        // }
    }

    /**
     * Add the component event listeners.
     */
    function addEventListeners() {
        /**
         * Event: Manage Appointments Dialog Save Button "Click"
         *
         * Stores the appointment changes or inserts a new appointment depending on the dialog mode.
         */
        $saveAppointment.on('click', () => {
       
            // Before doing anything the appointment data need to be validated.
            if (!App.Components.AppointmentsModal.validateAppointmentForm()) {
                return;
            }

            const startDateTimeObject = App.Utils.UI.getDateTimePickerValue($startDatetime);
            const startDatetime = moment(startDateTimeObject).format('YYYY-MM-DD HH:mm:ss');

            const endDateTimeObject = App.Utils.UI.getDateTimePickerValue($endDatetime);
            const endDatetime = moment(endDateTimeObject).format('YYYY-MM-DD HH:mm:ss');

            pendingAppointmentData = {
                id_services: $selectService.val(),
                id_users_provider: $selectProvider.val(),
                start_datetime: startDatetime,
                end_datetime: endDatetime,
                location: $appointmentLocation.val(),
                meeting_link: $appointmentMeetingLink.val(),
                color: App.Components.ColorSelection.getColor($appointmentColor),
                status: $appointmentStatus.val(),
                appointment_type: $appointmentType.val(),
                notes: $appointmentNotes.val(),
                is_unavailability: Number(false),
            };

            if ($appointmentId.val() !== '') {
                pendingAppointmentData.id = $appointmentId.val();
            }

            pendingCustomerData = {
                first_name: $firstName.val(),
                last_name: $lastName.val(),
                email: $email.val(),
                phone_number: $phoneNumber.val(),
                address: $address.val(),
                city: $city.val(),
                zip_code: $zipCode.val(),
                language: $language.val(),
                timezone: $timezone.val(),
                notes: $customerNotes.val(),
                custom_field_1: $customField1.val(),
                custom_field_2: $customField2.val(),
                custom_field_3: $customField3.val(),
                custom_field_4: $customField4.val(),
                custom_field_5: $customField5.val(),
            };

            if ($customerId.val() !== '') {
                pendingCustomerData.id = $customerId.val();
                pendingAppointmentData.id_users_customer = pendingCustomerData.id;
            }

            const isUpdate = Boolean(pendingAppointmentData.id);

            // Dynamic text configuration for custom modal based on update or create
            if (isUpdate) {
                $('#customNotifyModal .modal-title').text(lang('appointment_update'));
                $('#customNotifyModal .modal-body').text(lang('notify_users_on_update_question'));
            } else {
                $('#customNotifyModal .modal-title').text(lang('new_appointment_title'));
                $('#customNotifyModal .modal-body').text(lang('notify_users_on_create_question'));
            }

            // Hide main modal and show custom modal
            $appointmentsModal.modal('hide');
            $('#customNotifyModal').modal('show');
        });

        // Modal fully open hone par default time check karega
        $appointmentsModal.on('shown.bs.modal', () => {
            checkTimeAndAdjustType();
        });

        // Time change hone par turant check karega
        $startDatetime.on('change dp.change change.datetimepicker blur', () => {
            checkTimeAndAdjustType();
        });

        // Handle custom modal No button click
        $(document).on('click', '#btn-notify-no', () => {
            $('#customNotifyModal').modal('hide');
            App.Http.Calendar.saveAppointmentWithConflictHandling(
                pendingAppointmentData,
                pendingCustomerData,
                successCallback,
                errorCallback,
                false
            );
        });

        // Handle custom modal Yes button click
        $(document).on('click', '#btn-notify-yes', () => {
            $('#customNotifyModal').modal('hide');
            App.Http.Calendar.saveAppointmentWithConflictHandling(
                pendingAppointmentData,
                pendingCustomerData,
                successCallback,
                errorCallback,
                true
            );
        });

        $insertAppointment.on('click', () => {
            $('.popover').remove();
            App.Components.AppointmentsModal.resetModal();

            if ($selectFilterItem.find('option:selected').attr('type') === 'provider') {
                const providerId = $('#select-filter-item').val();
                const providers = vars('available_providers').filter(
                    (provider) => Number(provider.id) === Number(providerId),
                );

                if (providers.length) {
                    $selectService.val(providers[0].services[0]).trigger('change');
                    $selectProvider.val(providerId);
                }
            } else if ($selectFilterItem.find('option:selected').attr('type') === 'service') {
                $selectService.find('option[value="' + $selectFilterItem.val() + '"]').prop('selected', true);
            } else {
                $selectService.find('option:first').prop('selected', true).trigger('change');
            }

            $selectProvider.trigger('change');

            const serviceId = $selectService.val();
            const service = vars('available_services').find(
                (availableService) => Number(availableService.id) === Number(serviceId),
            );

            const duration = service ? service.duration : 60;
            const startMoment = moment();
            const currentMin = parseInt(startMoment.format('mm'));

            if (currentMin > 0 && currentMin < 15) {
                startMoment.set({minutes: 15});
            } else if (currentMin > 15 && currentMin < 30) {
                startMoment.set({minutes: 30});
            } else if (currentMin > 30 && currentMin < 45) {
                startMoment.set({minutes: 45});
            } else {
                startMoment.add(1, 'hour').set({minutes: 0});
            }

            App.Utils.UI.setDateTimePickerValue($startDatetime, startMoment.toDate());
            App.Utils.UI.setDateTimePickerValue($endDatetime, startMoment.add(duration, 'minutes').toDate());

            checkTimeAndAdjustType();

            $appointmentsModal.find('.modal-header h3').text(lang('new_appointment_title'));
            $appointmentsModal.modal('show');
        });

        $selectCustomer.on('click', (event) => {
            if (!$existingCustomersList.is(':visible')) {
                $(event.currentTarget).find('span').text(lang('hide'));
                $existingCustomersList.empty();
                $existingCustomersList.slideDown('slow');
                $filterExistingCustomers.fadeIn('slow').val('');
                
                vars('customers').forEach((customer) => {
                    let fullName = (customer.first_name || '[No First Name]') + ' ' + (customer.last_name || '[No Last Name]');
                    let phoneNum = customer.phone_number ? `<br><small style="color: #64748b; font-weight: normal;">${customer.phone_number}</small>` : '';

                    $('<div/>', {
                        'data-id': customer.id,
                        'html': `<span>${fullName}</span>${phoneNum}`
                    }).appendTo($existingCustomersList);
                });
            } else {
                $existingCustomersList.slideUp('slow');
                $filterExistingCustomers.fadeOut('slow');
                $(event.currentTarget).find('span').text(lang('select'));
            }
        });

        $appointmentsModal.on('click', '#existing-customers-list div', (event) => {
            const customerId = $(event.target).attr('data-id');
            const customer = vars('customers').find((customer) => Number(customer.id) === Number(customerId));

            if (customer) {
                $customerId.val(customer.id);
                $firstName.val(customer.first_name);
                $lastName.val(customer.last_name);
                $email.val(customer.email);
                $phoneNumber.val(customer.phone_number);
                $address.val(customer.address);
                $city.val(customer.city);
                $zipCode.val(customer.zip_code);
                $language.val(customer.language);
                $timezone.val(customer.timezone);
                $customerNotes.val(customer.notes);
                $customField1.val(customer.custom_field_1);
                $customField2.val(customer.custom_field_2);
                $customField3.val(customer.custom_field_3);
                $customField4.val(customer.custom_field_4);
                $customField5.val(customer.custom_field_5);
            }

            $selectCustomer.trigger('click');
        });

        let filterExistingCustomersTimeout = null;

        $filterExistingCustomers.on('keyup', (event) => {
    if (filterExistingCustomersTimeout) {
        clearTimeout(filterExistingCustomersTimeout);
    }

    const keyword = $(event.target).val().toLowerCase();

    filterExistingCustomersTimeout = setTimeout(() => {
        $('#loading').css('visibility', 'hidden');

        App.Http.Customers.search(keyword, 50)
            .done((response) => {
                $existingCustomersList.empty();

                response.forEach((customer) => {
                    let fullName = (customer.first_name || '[No First Name]') + ' ' + (customer.last_name || '[No Last Name]');
                    let phoneNum = customer.phone_number ? `<br><small style="color: #64748b; font-weight: normal;">${customer.phone_number}</small>` : '';

                    $('<div/>', {
                        'data-id': customer.id,
                        'html': `<strong>${fullName}</strong>${phoneNum}`
                    }).appendTo($existingCustomersList);

                    const result = vars('customers').filter((existingCustomer) => {
                        return Number(existingCustomer.id) === Number(customer.id);
                    });

                    if (!result.length) {
                        vars('customers').push(customer);
                    }
                });
            })
            .fail(() => {
                $existingCustomersList.empty();

                vars('customers').forEach((customer) => {
                    if (
                        customer.first_name.toLowerCase().indexOf(keyword) !== -1 ||
                        customer.last_name.toLowerCase().indexOf(keyword) !== -1 ||
                        customer.email.toLowerCase().indexOf(keyword) !== -1 ||
                        customer.phone_number.toLowerCase().indexOf(keyword) !== -1 ||
                        customer.address.toLowerCase().indexOf(keyword) !== -1 ||
                        customer.city.toLowerCase().indexOf(keyword) !== -1 ||
                        customer.zip_code.toLowerCase().indexOf(keyword) !== -1 ||
                        customer.notes.toLowerCase().indexOf(keyword) !== -1
                    ) {
                        let fullName = (customer.first_name || '[No First Name]') + ' ' + (customer.last_name || '[No Last Name]');
                        let phoneNum = customer.phone_number ? `<br><small style="color: #64748b; font-weight: normal;">${customer.phone_number}</small>` : '';

                        $('<div/>', {
                            'data-id': customer.id,
                            'html': `<strong>${fullName}</strong>${phoneNum}`
                        }).appendTo($existingCustomersList);
                    }
                });
            })
            .always(() => {
                $('#loading').css('visibility', '');
            });
    }, 1000);
});

        $selectService.on('change', () => {
            const serviceId = $selectService.val();
            const providerId = $selectProvider.val();
            $selectProvider.empty();

            const service = vars('available_services').find((availableService) => {
                return Number(availableService.id) === Number(serviceId);
            });

            if (service?.color) {
                App.Components.ColorSelection.setColor($appointmentColor, service.color);
            }

            const duration = service ? service.duration : 60;
            const startDateTimeObject = App.Utils.UI.getDateTimePickerValue($startDatetime);
            const endDateTimeObject = new Date(startDateTimeObject.getTime() + duration * 60000);
            App.Utils.UI.setDateTimePickerValue($endDatetime, endDateTimeObject);

            vars('available_providers').forEach((provider) => {
                provider.services.forEach((providerServiceId) => {
                    if (
                        vars('role_slug') === App.Layouts.Backend.DB_SLUG_PROVIDER &&
                        Number(provider.id) !== vars('user_id')
                    ) {
                        return;
                    }

                    if (
                        vars('role_slug') === App.Layouts.Backend.DB_SLUG_SECRETARY &&
                        vars('secretary_providers').indexOf(Number(provider.id)) === -1
                    ) {
                        return;
                    }

                    if (Number(providerServiceId) === Number(serviceId)) {
                        $selectProvider.append(new Option(provider.first_name + ' ' + provider.last_name, provider.id));
                    }
                });

                if ($selectProvider.find(`option[value="${providerId}"]`).length) {
                    $selectProvider.val(providerId);
                }
            });
        });

        $selectProvider.on('change', () => {
            updateTimezone();
        });

        $newCustomer.on('click', () => {
            $customerId.val('');
            $firstName.val('');
            $lastName.val('');
            $email.val('');
            $phoneNumber.val('');
            $address.val('');
            $city.val('');
            $zipCode.val('');
            $language.val(vars('default_language'));
            $timezone.val(vars('default_timezone'));
            $customerNotes.val('');
            $customField1.val('');
            $customField2.val('');
            $customField3.val('');
            $customField4.val('');
            $customField5.val('');
        });
    }

    // Define success callback.
    const successCallback = () => {
        App.Layouts.Backend.displayNotification(lang('appointment_saved'));

        $appointmentsModal.find('.alert').addClass('d-none');
        $appointmentsModal.modal('hide');
        $reloadAppointments.trigger('click');
    };

    // Define error callback.
    const errorCallback = () => {
        $appointmentsModal.find('.modal-message').text(lang('service_communication_error'));
        $appointmentsModal.find('.modal-message').addClass('alert-danger').removeClass('d-none');
        $appointmentsModal.find('.modal-body').scrollTop(0);
    };

    /**
     * Reset Appointment Dialog
     */
    function resetModal() {
        $appointmentsModal.find('input, textarea').val('');
        $appointmentsModal.find('.modal-message').addClass('.d-none');
        $appointmentsModal.find('.is-invalid').removeClass('is-invalid');

        const defaultStatusValue = $appointmentStatus.find('option:first').val();
        $appointmentStatus.val(defaultStatusValue);

        $appointmentType.val('in-clinic'); // Reset appointment type default

        $language.val(vars('default_language'));
        $timezone.val(vars('default_timezone'));

        $appointmentColor.find('.color-selection-option:first').trigger('click');
        $selectService.val($selectService.eq(0).attr('value'));

        $selectProvider.empty();
        vars('available_providers').forEach((provider) => {
            const serviceId = $selectService.val();
            const canProvideService =
                provider.services.filter((providerServiceId) => {
                    return Number(providerServiceId) === Number(serviceId);
                }).length > 0;

            if (canProvideService) {
                $selectProvider.append(new Option(provider.first_name + ' ' + provider.last_name, provider.id));
            }
        });

        $existingCustomersList.slideUp('slow');
        $filterExistingCustomers.fadeOut('slow');
        $selectCustomer.find('span').text(lang('select'));

        const serviceId = $selectService.val();
        const service = vars('available_services').find((s) => Number(s.id) === Number(serviceId));
        const duration = service ? service.duration : 0;

        const startDatetime = new Date();
        const endDatetime = moment().add(duration, 'minutes').toDate();

        App.Utils.UI.initializeDateTimePicker($startDatetime, {
            onChange: () => {
                checkTimeAndAdjustType();
            },
            onClose: () => {
                const serviceId = $selectService.val();
                const service = vars('available_services').find(
                    (availableService) => Number(availableService.id) === Number(serviceId),
                );

                const startDateTimeObject = App.Utils.UI.getDateTimePickerValue($startDatetime);
                const endDateTimeObject = new Date(startDateTimeObject.getTime() + service.duration * 60000);
                App.Utils.UI.setDateTimePickerValue($endDatetime, endDateTimeObject);

                checkTimeAndAdjustType();
            },
        });

        App.Utils.UI.setDateTimePickerValue($startDatetime, startDatetime);
        
        checkTimeAndAdjustType();

        App.Utils.UI.initializeDateTimePicker($endDatetime);
        App.Utils.UI.setDateTimePickerValue($endDatetime, endDatetime);
        $appointmentsModal.find('.modal-message').removeClass('alert-danger').text('').addClass('d-none');
    }

    function validateAppointmentForm() {
        $appointmentsModal.find('.is-invalid').removeClass('is-invalid');
        $appointmentsModal.find('.modal-message').addClass('d-none');

        try {
            let missingRequiredField = false;

            $appointmentsModal.find('.required').each((index, requiredField) => {
                if ($(requiredField).val() === '' || $(requiredField).val() === null) {
                    $(requiredField).addClass('is-invalid');
                    missingRequiredField = true;
                }
            });

            if (missingRequiredField) {
                throw new Error(lang('fields_are_required'));
            }

            if (
                $appointmentsModal.find('#email').val() &&
                !App.Utils.Validation.email($appointmentsModal.find('#email').val())
            ) {
                $appointmentsModal.find('#email').addClass('is-invalid');
                throw new Error(lang('invalid_email'));
            }

            const startDateTimeObject = App.Utils.UI.getDateTimePickerValue($startDatetime);
            const endDateTimeObject = App.Utils.UI.getDateTimePickerValue($endDatetime);

            if (startDateTimeObject > endDateTimeObject) {
                $startDatetime.addClass('is-invalid');
                $endDatetime.addClass('is-invalid');
                throw new Error(lang('start_date_before_end_error'));
            }

            return true;
        } catch (error) {
            $appointmentsModal
                .find('.modal-message')
                .addClass('alert-danger')
                .text(error.message)
                .removeClass('d-none');
            return false;
        }
    }

    function initialize() {
        addEventListeners();
    }

    document.addEventListener('DOMContentLoaded', initialize);

    return {
        resetModal,
        validateAppointmentForm,
    };
})();
</script>
<?php end_section('scripts'); ?>