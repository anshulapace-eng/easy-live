<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends EA_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Login check ya permissions verify karne ke liye
    }

    public function index(): void
    {
        method('get');

        $user_id = session('user_id');

        if (!$user_id) {
            redirect('login');
            return;
        }

        // View load karne ke liye
        $this->load->view('pages/dashboard');
    }
}