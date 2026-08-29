<?php defined('BASEPATH') or exit('No direct script access allowed');

/* ----------------------------------------------------------------------------
 * Easy!Appointments - Online Appointment Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://easyappointments.org
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

/**
 * Customers controller.
 *
 * Handles the customers related operations.
 *
 * @package Controllers
 */
class Customers extends EA_Controller
{
    public array $allowed_customer_fields = [
        'id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'address',
        'city',
        'state',
        'zip_code',
        'notes',
        'timezone',
        'language',
        'custom_field_1',
        'custom_field_2',
        'custom_field_3',
        'custom_field_4',
        'custom_field_5',
        'ldap_dn',
    ];

    public array $optional_customer_fields = [
        //
    ];

    /**
     * Customers constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('appointments_model');
        $this->load->model('customers_model');
        $this->load->model('secretaries_model');
        $this->load->model('roles_model');

        $this->load->library('accounts');
        $this->load->library('permissions');
        $this->load->library('timezones');
        $this->load->library('webhooks_client');
    }

    /**
     * Render the backend customers page.
     */
    public function index(): void
    {
        method('get');

        // Handle AJAX request for dynamic time slots based on the selected date
        $input_date = $this->input->get('date');
        if (!empty($input_date)) {
            $target_date = $input_date;
            $current_day = strtolower(date('l', strtotime($target_date)));

            $working_plan_json = setting('company_working_plan');
            $working_plan = json_decode($working_plan_json, true);

            $time_slots = [];

            $this->db->where('DATE(start_datetime)', $target_date);
            $this->db->where_not_in('status', ['Canceled', 'canceled', 'CANCELED']);
            $existing_appointments = $this->db->get('ea_appointments')->result_array();

            $is_today = ($target_date === date('Y-m-d'));
            $current_time_hhmm = date('H:i');

            if (isset($working_plan[$current_day]) && is_array($working_plan[$current_day])) {
                $start_time = '09:00';
                $end_time = $working_plan[$current_day]['end'];
                $breaks = $working_plan[$current_day]['breaks'] ?? [];

                $current_time = strtotime($start_time);
                $last_time = strtotime($end_time);

                while ($current_time < $last_time) {
                    if ($current_time >= strtotime('10:00') && $current_time < strtotime('10:30')) {
                        $current_time = strtotime('10:30');
                        if ($current_time >= $last_time) break;
                        continue;
                    }

                    $active_break = null;
                    foreach ($breaks as $break) {
                        $break_start = strtotime($break['start']);
                        $break_end = strtotime($break['end']);

                        if ($current_time >= $break_start && $current_time < $break_end) {
                            $active_break = $break;
                            break;
                        }
                    }

                    if ($active_break) {
                        $next_time = strtotime($active_break['end']);
                        $slot_start = date('H:i', strtotime($active_break['start']));
                        $slot_end = date('H:i', strtotime($active_break['end']));

                        $time_slots[] = [
                            'start'     => $slot_start,
                            'end'       => $slot_end,
                            'label'     => $slot_start . ' - ' . $slot_end,
                            'available' => false,
                            'status'    => 'break',
                            'type'      => 'none'
                        ];
                    } else {
                        $next_time = strtotime('+15 minutes', $current_time);

                        if ($next_time > $last_time) {
                            $next_time = $last_time;
                        }

                        foreach ($breaks as $break) {
                            $break_start = strtotime($break['start']);
                            if ($current_time < $break_start && $next_time > $break_start) {
                                $next_time = $break_start;
                                break;
                            }
                        }

                        $slot_start = date('H:i', $current_time);
                        $slot_end = date('H:i', $next_time);

                        if ($slot_start === $slot_end) {
                            $current_time = $next_time;
                            continue;
                        }

                        $is_past = false;
                        if ($is_today && $slot_start <= $current_time_hhmm) {
                            $is_past = true;
                        }

                        $slot_start_dt = $target_date . ' ' . $slot_start . ':00';
                        $slot_end_dt   = $target_date . ' ' . $slot_end . ':00';
                        $is_booked = false;

                        foreach ($existing_appointments as $appt) {
                            if ($slot_start_dt < $appt['end_datetime'] && $slot_end_dt > $appt['start_datetime']) {
                                $is_booked = true;
                                break;
                            }
                        }

                        $is_available = (!$is_booked && !$is_past);
                        $status = 'available';

                        if ($is_past) {
                            $status = 'past';
                        } elseif ($is_booked) {
                            $status = 'booked';
                        }

                        $slot_type = ($current_time < strtotime('10:00')) ? 'video' : 'in-clinic';

                        $time_slots[] = [
                            'start'     => $slot_start,
                            'end'       => $slot_end,
                            'label'     => $slot_start . ' - ' . $slot_end,
                            'available' => $is_available,
                            'status'    => $status,
                            'type'      => $slot_type
                        ];
                    }

                    $current_time = $next_time;
                }
            }

            echo json_encode($time_slots);
            exit;
        }

        session(['dest_url' => site_url('customers')]);

        $user_id = session('user_id');

        if (cannot('view', PRIV_CUSTOMERS)) {
            if ($user_id) {
                abort(403, 'Forbidden');
            }
            redirect('login');
            return;
        }

        $role_slug = session('role_slug');
        $date_format = setting('date_format');
        $time_format = setting('time_format');

        $secretary_providers = [];
        if ($role_slug === DB_SLUG_SECRETARY) {
            $secretary = $this->secretaries_model->find($user_id);
            $secretary_providers = $secretary['providers'] ?? [];
        }

        $this->db->select('
            ea_users.*, 
            ea_appointments.id as appointment_id,
            ea_appointments.start_datetime,
            ea_appointments.end_datetime,
            ea_appointments.id_users_provider,
            ea_appointments.status as appointment_status,
            provider.first_name as provider_first_name,
            provider.last_name as provider_last_name,
            ea_services.name as service_name
        ');
        $this->db->from('ea_users');
        $this->db->join('ea_appointments', 'ea_appointments.id_users_customer = ea_users.id', 'left');
        $this->db->join('ea_users as provider', 'provider.id = ea_appointments.id_users_provider', 'left');
        $this->db->join('ea_services', 'ea_services.id = ea_appointments.id_services', 'left');

        if ($role_slug === DB_SLUG_PROVIDER) {
            $this->db->where('ea_appointments.id_users_provider', $user_id);
        } elseif ($role_slug === DB_SLUG_SECRETARY) {
            if (!empty($secretary_providers)) {
                $this->db->where_in('ea_appointments.id_users_provider', $secretary_providers);
            } else {
                $this->db->where('1 = 0', null, false);
            }
        }

        $this->db->order_by('ea_users.id', 'DESC');
        $query = $this->db->get();
        $raw_results = $query->result_array();

        // echo "<pre>";
        // print_r($raw_results);
        // die();

        $this->load->view('pages/customers', [
            'customers'   => $raw_results,
            'date_format' => $date_format,
            'time_format' => $time_format
        ]);
    }

    /**
     * Find a customer.
     */
    public function find(): void
    {
        try {
            method('get');

            if (cannot('view', PRIV_CUSTOMERS)) {
                abort(403, 'Forbidden');
            }

            $user_id = session('user_id');

            check('customer_id', 'numeric');

            $customer_id = request('customer_id');

            // Validate customer_id is a positive integer
            if (empty($customer_id) || !filter_var($customer_id, FILTER_VALIDATE_INT) || $customer_id <= 0) {
                throw new InvalidArgumentException('Invalid customer ID provided.');
            }

            if (!$this->permissions->has_customer_access($user_id, $customer_id)) {
                abort(403, 'Forbidden');
            }

            $customer = $this->customers_model->find($customer_id);

            json_response($customer);
        } catch (Throwable $e) {
            json_exception($e);
        }
    }

    /**
     * Filter customers by the provided keyword.
     */
    public function search(): void
    {
        try {
            method('post');

            if (cannot('view', PRIV_CUSTOMERS)) {
                abort(403, 'Forbidden');
            }

            check('keyword', 'string|null');
            check('order_by', 'string|null');
            check('limit', 'numeric|null');
            check('offset', 'numeric|null');

            $keyword = request('keyword', '');

            $order_by = request('order_by', 'update_datetime DESC');

            $limit = request('limit', 1000);

            $offset = (int) request('offset', '0');

            $customers = $this->customers_model->search($keyword, $limit, $offset, $order_by);

            $user_id = session('user_id');
            $role_slug = session('role_slug');

            $secretary_provider_ids = [];

            if ($role_slug === DB_SLUG_SECRETARY) {
                $secretary_provider_ids = $this->secretaries_model->find($user_id)['providers'];
            }

            foreach ($customers as $index => &$customer) {
                if (!$this->permissions->has_customer_access($user_id, $customer['id'])) {
                    unset($customers[$index]);

                    continue;
                }

                $appointments = $this->appointments_model->get(['id_users_customer' => $customer['id']]);

                // If the current user is a provider, only include their own appointments.
                if ($role_slug === DB_SLUG_PROVIDER) {
                    $appointments = array_filter($appointments, function ($appointment) use ($user_id) {
                        return (int) $appointment['id_users_provider'] === (int) $user_id;
                    });

                    $appointments = array_values($appointments);
                }

                // If the current user is a secretary, only include appointments of their providers.
                if ($role_slug === DB_SLUG_SECRETARY) {
                    $appointments = array_filter($appointments, function ($appointment) use ($secretary_provider_ids) {
                        return in_array((int) $appointment['id_users_provider'], $secretary_provider_ids);
                    });

                    $appointments = array_values($appointments);
                }

                foreach ($appointments as &$appointment) {
                    $this->appointments_model->load($appointment, ['service', 'provider']);
                }

                $customer['appointments'] = $appointments;
            }

            json_response(array_values($customers));
        } catch (Throwable $e) {
            json_exception($e);
        }
    }


    /**
     * Store a new customer.
     */
    // public function store(): void
    // {
    //     try {
    //         method('post');

    //         if (cannot('add', PRIV_CUSTOMERS)) {
    //             abort(403, 'Forbidden');
    //         }

    //         if (session('role_slug') !== DB_SLUG_ADMIN && setting('limit_customer_visibility')) {
    //             abort(403);
    //         }

    //         check('customer', 'array');

    //         $customer = request('customer');

    //         $this->customers_model->only($customer, $this->allowed_customer_fields);

    //         $this->customers_model->optional($customer, $this->optional_customer_fields);

    //         $customer_id = $this->customers_model->save($customer);

    //         $customer = $this->customers_model->find($customer_id);

    //         $this->webhooks_client->trigger(WEBHOOK_CUSTOMER_SAVE, $customer);

    //         json_response([
    //             'success' => true,
    //             'id' => $customer_id,
    //         ]);
    //     } catch (Throwable $e) {
    //         json_exception($e);
    //     }
    // }


    public function store(): void
{
    try {
        method('post');

        if (cannot('add', PRIV_CUSTOMERS)) {
            abort(403, 'Forbidden');
        }

        if (session('role_slug') !== DB_SLUG_ADMIN && setting('limit_customer_visibility')) {
            abort(403);
        }

        check('customer', 'array');

        $customer = request('customer');

        $this->customers_model->only($customer, $this->allowed_customer_fields);
        $this->customers_model->optional($customer, $this->optional_customer_fields);

        $customer_id = $this->customers_model->save($customer);

        $customer = $this->customers_model->find($customer_id);

        $this->webhooks_client->trigger(WEBHOOK_CUSTOMER_SAVE, $customer);

        if ($this->input->is_ajax_request()) {
            $this->session->set_flashdata('success', 'Customer added successfully.');
            echo json_encode(['success' => true, 'id' => $customer_id]);
            return;
        }

        $this->session->set_flashdata('success', 'Customer added successfully.');
        redirect('customers');
    } catch (Throwable $e) {
        if ($this->input->is_ajax_request()) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            return;
        }
        json_exception($e);
    }
}



    public function update($customer_id = null): void
    {
        $post_customer_id = $this->input->post('customer_id');
        $appointment_id   = $this->input->post('appointment_id');

        $patient_name     = $this->input->post('first-name');
        $contact_name     = $this->input->post('last-name');
        $phone_number     = $this->input->post('phone-number');

        $customer_data = [
            'first_name'   => $patient_name,
            'last_name'    => $contact_name,
            'phone_number' => $phone_number
        ];

        $target_customer_id = !empty($post_customer_id) ? $post_customer_id : $customer_id;


        $customer_data['id'] = $target_customer_id;
        $this->customers_model->save($customer_data);

        if (!empty($appointment_id)) {
            $provider_id      = $this->input->post('provider_id');
            $start_date       = $this->input->post('start_date');
            $time_slot_input  = $this->input->post('start_time');
            $status           = $this->input->post('status');
            $appointment_type = $this->input->post('appointment_type');

            if (!empty($start_date) && !empty($time_slot_input)) {

               
                if (strpos($time_slot_input, '-') !== false) {
                    $times = explode('-', $time_slot_input);
                    $start_time_val = trim($times[0]); 
                    $end_time_val   = trim($times[1]);

                    $start_datetime = $start_date . ' ' . $start_time_val . ':00';
                    $end_datetime   = $start_date . ' ' . $end_time_val . ':00';
                } else {
                   
                    $start_time_val = trim($time_slot_input);
                    $start_datetime = $start_date . ' ' . $start_time_val . ':00';
                    $end_datetime   = date('Y-m-d H:i:s', strtotime($start_datetime . ' +30 minutes'));
                }

                $existing_appointment = $this->appointments_model->find($appointment_id);

                
                $appointment_data = array_merge($existing_appointment, [
                    'id'                => $appointment_id,
                    'id_users_provider' => $provider_id,
                    'start_datetime'    => $start_datetime,
                    'end_datetime'      => $end_datetime,
                    'status'            => $status,
                    'appointment_type'  => $appointment_type,
                    'is_unavailability' => 0
                ]);

                $this->appointments_model->save($appointment_data);
            }
        }
        if ($this->input->is_ajax_request()) {
            $this->session->set_flashdata('success', 'Details updated successfully.');
            echo json_encode(['success' => true]);
            return;
        }

        $this->session->set_flashdata('success', 'Details updated successfully.');
        redirect('customers');
    }

    /**
     * Remove a customer.
     */
    public function destroy(): void
    {
        try {
            method('post');

            if (cannot('delete', PRIV_CUSTOMERS)) {
                abort(403, 'Forbidden');
            }

            $user_id = session('user_id');

            check('customer_id', 'numeric');

            $customer_id = request('customer_id');

            // Validate customer_id is a positive integer
            if (empty($customer_id) || !filter_var($customer_id, FILTER_VALIDATE_INT) || $customer_id <= 0) {
                throw new InvalidArgumentException('Invalid customer ID provided.');
            }

            if (!$this->permissions->has_customer_access($user_id, $customer_id)) {
                abort(403, 'Forbidden');
            }

            $customer = $this->customers_model->find($customer_id);

            $this->customers_model->delete($customer_id);

            $this->webhooks_client->trigger(WEBHOOK_CUSTOMER_DELETE, $customer);

            json_response([
                'success' => true,
            ]);
        } catch (Throwable $e) {
            json_exception($e);
        }
    }
}
