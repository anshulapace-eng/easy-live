<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends EA_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // यहाँ मॉडल को लोड किया गया है ताकि यह null न रहे
        $this->load->model('appointments_model', 'appointment_model');
    }

    public function index(): void
    {
        method('get');

        $user_id = session('user_id');

        if (!$user_id) {
            redirect('login');
            return;
        }

        $today = date('Y-m-d');

        // 1. Today's Total Appointments Count
        $data['today_appointments'] = $this->db->where('DATE(start_datetime)', $today)
            ->count_all_results('ea_appointments');

    
        $data['today_done'] = $this->db->where('DATE(start_datetime)', $today)
            ->where_in('status', ['confirmed', 'Confirmed'])
            ->count_all_results('ea_appointments');

        
        $data['today_cancel'] = $this->db->where('DATE(start_datetime)', $today)
            ->where_in('status', ['canceled', 'Canceled', 'Cancelled'])
            ->count_all_results('ea_appointments');

        
        $data['today_queue'] = $this->db->where('DATE(start_datetime)', $today)
            ->where_in('status', ['Booked', 'booked', 'pending'])
            ->count_all_results('ea_appointments');

        
        $data['total_appointments'] = $this->db->count_all('ea_appointments');

      
        $data['total_staffs'] = $this->db->where_in('id_roles', [2, 4])
            ->count_all_results('ea_users');


        $data['total_patients'] = $this->db->where('id_roles', 3)
            ->count_all_results('ea_users');

        $data['upcoming_appointments'] = $this->appointment_model->get_today_upcoming_appointments();

       

        
        $this->load->view('pages/dashboard', $data);
    }
}