<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Whatsapp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); 
    }

    public function send()
    {
        $appointmentId = $this->input->post('id'); 
        $customerName  = $this->input->post('customer_name') ?? 'Customer';
        $doctorName    = $this->input->post('doctor_name') ?? 'Doctor';
        $fee           = $this->input->post('fee') ?? '0';
        $date          = $this->input->post('date') ?? '';
        $time          = $this->input->post('time') ?? '';
        $phone         = '9810826144';

        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($phone) == 10) {
            $phone = '91' . $phone; 
        }

        if (empty($phone)) {
            echo json_encode([
                'status' => false,
                'message' => 'Valid Phone Number is required.'
            ]);
            exit;
        }

        // Config se credentials securely load karein
        $accessToken = $this->config->item('whatsapp_access_token');
        $phoneNumberId = $this->config->item('whatsapp_phone_number_id');

        if (empty($accessToken) || empty($phoneNumberId)) {
            echo json_encode([
                'status' => false,
                'message' => 'WhatsApp API credentials are not configured properly in config file.'
            ]);
            exit;
        }

        // Payload Prepare
        $data = [
            "messaging_product" => "whatsapp",
            "to" => $phone,
            "type" => "template",
            "template" => [
                "name" => "appointment_confirmation",
                "language" => [
                    "code" => "en"
                ],
                "components" => [
                    [
                        "type" => "body",
                        "parameters" => [
                            ["type" => "text", "text" => (string)$customerName],
                            ["type" => "text", "text" => (string)$doctorName],
                            ["type" => "text", "text" => (string)$fee],
                            ["type" => "text", "text" => (string)$date],
                            ["type" => "text", "text" => (string)$time]
                        ]
                    ]
                ]
            ]
        ];

        // cURL Execute
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => "https://graph.facebook.com/v23.0/{$phoneNumberId}/messages",
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$accessToken}",
                "Content-Type: application/json"
            ],
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            echo json_encode([
                'status' => false,
                'message' => 'cURL Error: ' . $curlError
            ]);
        } else {
            $result = json_decode($response, true);

            if (isset($result['messages'][0]['id'])) {
                if (!empty($appointmentId)) {
                    $this->db->where('id', $appointmentId);
                    $this->db->update('ea_appointments', ['is_whatsapp_sent' => 1]);
                }
                
                echo json_encode([
                    'status' => true,
                    'message' => 'Message Sent Successfully',
                    'meta_response' => $result
                ]);
            } else {
                $errorMessage = $result['error']['message'] ?? 'Meta API Error';
                echo json_encode([
                    'status' => false,
                    'message' => $errorMessage,
                    'meta_response' => $result
                ]);
            }
        }
        exit;
    }
}