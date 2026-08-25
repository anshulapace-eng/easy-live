<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends EA_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('providers_model');
    }

    public function index()
    {
        $input_date = $this->input->get('date');
        $target_date = !empty($input_date) ? $input_date : date('Y-m-d');
        $current_day = strtolower(date('l', strtotime($target_date)));

        $working_plan_json = setting('company_working_plan');
        $working_plan = json_decode($working_plan_json, true);

        $time_slots = [];

        $this->db->where('DATE(start_datetime)', $target_date);
        $this->db->where_not_in('status', ['Canceled', 'canceled', 'CANCELED']);
        $existing_appointments = $this->db->get('ea_appointments')->result_array();

        $is_today = ($target_date === date('Y-m-d'));
        $current_time_hhmm = date('H:i');

        if (
            isset($working_plan[$current_day]) &&
            is_array($working_plan[$current_day])
        ) {
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

                    // Define Slot Type ('video' or 'clinic')
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

        if (!empty($input_date)) {
            echo json_encode($time_slots);
            exit;
        }

        $data['time_slots'] = $time_slots;
        $data['available_providers'] = $this->providers_model->get_available_providers();

        $this->load->view('pages/appointment_form', $data);
    }

    public function search_customer_ajax()
    {
        $phone = $this->input->get('phone');
        if (!empty($phone)) {
            $this->db->like('phone_number', $phone);
            $customers = $this->db->get('users')->result_array();
            echo json_encode($customers);
        } else {
            echo json_encode([]);
        }
    }

    public function submit_appointment()
    {
        $customer_type      = request('customer_type');
        $existing_customer_id = request('existing_customer_id');
        $patient_name       = request('first_name');
        $contact_name       = request('last_name');  
        $email              = request('email');
        $phone              = request('phone');
        $provider_id        = request('id_users_provider');
        $appointment_date   = request('appointment_date');
        $appointment_time   = request('appointment_time');
        $appointment_type   = request('appointment_type'); // Get Appointment Type
        $note               = request('note');

        if (empty($provider_id) || empty($appointment_date) || empty($appointment_time) || empty($phone) || empty($appointment_type)) {
            throw new RuntimeException('Please fill in all required fields.');
        }

        $phonenumbercheck = date('Y-m-d');
        $after15days = date('Y-m-d', strtotime($phonenumbercheck . ' +15 days'));

        $this->load->database(); 
    
        $this->db->from('ea_appointments');
        $this->db->join('users', 'users.id = ea_appointments.id_users_customer');
        $this->db->where('users.phone_number', $phone);
        $this->db->where('ea_appointments.start_datetime >=', $phonenumbercheck . ' 00:00:00');
        $this->db->where('ea_appointments.start_datetime <=', $after15days . ' 23:59:59');
        $this->db->where('ea_appointments.is_canceled !=', 1);
    
        $existing_bookings_count = $this->db->count_all_results();

        if ($existing_bookings_count >= 2) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false, 
                    'message' => 'Maximum 2 appointments allowed per 15-day period for this phone number.'
                ]));
        }

        $this->load->model('customers_model');
        $this->load->model('appointments_model');
        $this->load->model('services_model');

        $services = $this->services_model->get_available_services();
        $service_id = !empty($services) ? $services[0]['id'] : 5;

        $customer_data = [
            'first_name'   => $patient_name,
            'last_name'    => !empty($contact_name) ? $contact_name : $patient_name,
            'email'        => $email,
            'phone_number' => $phone,
            'notes'        => $note
        ];

        $customer_id = $this->customers_model->save($customer_data);

        if (empty($customer_id)) {
            throw new RuntimeException('Could not process customer data.');
        }

        $start_datetime = $appointment_date . ' ' . $appointment_time . ':00';
        $end_datetime   = date('Y-m-d H:i:s', strtotime('+15 minutes', strtotime($start_datetime)));

        $has_conflict = $this->appointments_model->has_provider_conflict(
            (int) $provider_id,
            $start_datetime,
            $end_datetime
        );

        if ($has_conflict) {
            throw new RuntimeException('The selected time slot is already booked. Please choose another slot.');
        }

        $appointment_data = [
            'start_datetime'    => $start_datetime,
            'end_datetime'      => $end_datetime,
            'is_unavailability' => 0,
            'id_users_provider' => $provider_id,
            'id_users_customer' => $customer_id,
            'id_services'       => $service_id,
            'notes'             => $note,
            'status'            => 'Booked',
            'appointment_type'  => $appointment_type // Add to array for DB Insert
        ];

        $appointment_id = $this->appointments_model->save($appointment_data);

        if (!empty($appointment_id)) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true, 
                    'message' => 'Your appointment has been successfully booked!'
                ]));
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false, 
                    'message' => 'Failed to save the appointment.'
                ]));
        }
    }
}