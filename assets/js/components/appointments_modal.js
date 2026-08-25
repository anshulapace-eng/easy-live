/* ----------------------------------------------------------------------------
 * Easy!Appointments - Online Appointment Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://easyappointments.org
 * @since       v1.5.0
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

              console.log("1. Raw Element Value:", $('#appointment-type').val());
            console.log("2. Variable Value ($appointmentType):", $appointmentType.val());

            const startDateTimeObject = App.Utils.UI.getDateTimePickerValue($startDatetime);
            const startDatetime = moment(startDateTimeObject).format('YYYY-MM-DD HH:mm:ss');

            const endDateTimeObject = App.Utils.UI.getDateTimePickerValue($endDatetime);
            const endDatetime = moment(endDateTimeObject).format('YYYY-MM-DD HH:mm:ss');

            const appointment = {
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
                // Set the id value, only if we are editing an appointment.
                appointment.id = $appointmentId.val();
            }

            const customer = {
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
                customer.id = $customerId.val();
                appointment.id_users_customer = customer.id;
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

            const isUpdate = Boolean(appointment.id);

            if (isUpdate) {
                App.Utils.Message.show(lang('appointment_update'), lang('notify_users_on_update_question'), [
                    {
                        text: lang('no'),
                        click: (event, messageModal) => {
                            messageModal.hide();
                            App.Http.Calendar.saveAppointmentWithConflictHandling(
                                appointment,
                                customer,
                                successCallback,
                                errorCallback,
                                false,
                            );
                        },
                    },
                    {
                        text: lang('yes'),
                        click: (event, messageModal) => {
                            messageModal.hide();
                            App.Http.Calendar.saveAppointmentWithConflictHandling(
                                appointment,
                                customer,
                                successCallback,
                                errorCallback,
                                true,
                            );
                        },
                    },
                ]);
            } else {
                App.Utils.Message.show(
                    lang('new_appointment_title'),
                    lang('notify_users_on_create_question'),
                    [
                        {
                            text: lang('no'),
                            click: (event, messageModal) => {
                                messageModal.hide();
                                App.Http.Calendar.saveAppointmentWithConflictHandling(
                                    appointment,
                                    customer,
                                    successCallback,
                                    errorCallback,
                                    false,
                                );
                            },
                        },
                        {
                            text: lang('yes'),
                            click: (event, messageModal) => {
                                messageModal.hide();
                                App.Http.Calendar.saveAppointmentWithConflictHandling(
                                    appointment,
                                    customer,
                                    successCallback,
                                    errorCallback,
                                    true,
                                );
                            },
                        },
                    ],
                );
            }
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
                    $('<div/>', {
                        'data-id': customer.id,
                        'text':
                            (customer.first_name || '[No First Name]') + ' ' + (customer.last_name || '[No Last Name]'),
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
                            $('<div/>', {
                                'data-id': customer.id,
                                'text':
                                    (customer.first_name || '[No First Name]') +
                                    ' ' +
                                    (customer.last_name || '[No Last Name]'),
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
                                $('<div/>', {
                                    'data-id': customer.id,
                                    'text':
                                        (customer.first_name || '[No First Name]') +
                                        ' ' +
                                        (customer.last_name || '[No Last Name]'),
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
        const service = vars('available_services').forEach((service) => Number(service.id) === Number(serviceId));
        const duration = service ? service.duration : 0;

        const startDatetime = new Date();
        const endDatetime = moment().add(duration, 'minutes').toDate();

        App.Utils.UI.initializeDateTimePicker($startDatetime, {
            onClose: () => {
                const serviceId = $selectService.val();
                const service = vars('available_services').find(
                    (availableService) => Number(availableService.id) === Number(serviceId),
                );

                const startDateTimeObject = App.Utils.UI.getDateTimePickerValue($startDatetime);
                const endDateTimeObject = new Date(startDateTimeObject.getTime() + service.duration * 60000);
                App.Utils.UI.setDateTimePickerValue($endDatetime, endDateTimeObject);
            },
        });

        App.Utils.UI.setDateTimePickerValue($startDatetime, startDatetime);
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