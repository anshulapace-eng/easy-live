<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Databasebackup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        $this->load->database();
        $this->load->helper(array('download', 'file')); // File helper load kiya
    }

    public function index() {
        // echo "anshul"; die();
        $this->load->dbutil();

        // 1. Backup generate karein
        $prefs = array(
            'format'      => 'zip',
            'filename'    => 'db_backup_' . date('Y-m-d_H-i-s') . '.sql',
            'newline'     => "\n"
        );

        $backup = $this->dbutil->backup($prefs);
        $db_name = 'db-backup-' . date('Y-m-d_H-i-s') . '.zip';

        $save_path = FCPATH . 'backups/'; 
        

        if (!is_dir($save_path)) {
            mkdir($save_path, 0777, true);
        }
        

        write_file($save_path . $db_name, $backup);

 
        $data = array(
            'backup_name' => $db_name,
            // 'backup_data' column aap chahein toh database se hata sakte hain
            'created_at'  => date('Y-m-d H:i:s')
        );
        $this->db->insert('ea_db_backups', $data);

 
        $three_days_ago = date('Y-m-d H:i:s', strtotime('-3 days'));
        
        
        $this->db->where('created_at <', $three_days_ago);
        $old_backups = $this->db->get('ea_db_backups')->result();

        foreach ($old_backups as $old) {
            // Server folder se file delete karein
            if (file_exists($save_path . $old->backup_name)) {
                unlink($save_path . $old->backup_name); 
            }
        }

        $this->db->where('created_at <', $three_days_ago);
        $this->db->delete('ea_db_backups');

        // 5. Direct Download
        force_download($db_name, $backup);
        
        echo "backup successfully created";
    }
}