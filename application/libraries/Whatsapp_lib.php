<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Whatsapp_lib 
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function send_appointment_template(array $appointment, array $customer, array $provider, array $service): bool
    {
        // $phone = $customer['phone_number'] ?? '';
        $phone = "9810826144";
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (strlen($phone) == 10) {
            $phone = '91' . $phone;
        }

        if (empty($phone)) {
            return false;
        }

        $customerName = trim(($customer['first_name'] ?? '') . ' ' . ($customer['last_name'] ?? '')) ?: 'Customer';
        $doctorName   = trim(($provider['first_name'] ?? '') . ' ' . ($provider['last_name'] ?? '')) ?: 'Doctor';
        $fee          = $service['price'] ?? '0';

        $startDate = new DateTime($appointment['start_datetime']);
        $formattedDate = $startDate->format('M j, Y'); 
        $formattedTime = $startDate->format('g:i A'); 

        // Config se secure tarike se credentials fetch karna
        $accessToken   = $this->CI->config->item('whatsapp_access_token');
        $phoneNumberId = $this->CI->config->item('whatsapp_phone_number_id');

        // Fallback check agar config load na ho toh
        if (empty($accessToken) || empty($phoneNumberId)) {
            log_message('error', 'WhatsApp API credentials are missing in config.');
            return false;
        }

        $payload = [
            "messaging_product" => "whatsapp",
            "to" => $phone,
            "type" => "template",
            "template" => [
                "name" => "appointment_confirmation",
                "language" => ["code" => "en"],
                "components" => [
                    [
                        "type" => "body",
                        "parameters" => [
                            ["type" => "text", "text" => (string)$customerName],
                            ["type" => "text", "text" => (string)$doctorName],
                            ["type" => "text", "text" => (string)$fee],
                            ["type" => "text", "text" => (string)$formattedDate],
                            ["type" => "text", "text" => (string)$formattedTime]
                        ]
                    ]
                ]
            ]
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://graph.facebook.com/v23.0/{$phoneNumberId}/messages",
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$accessToken}",
                "Content-Type: application/json"
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 5
        ]);

        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if (!$curlError) {
            $result = json_decode($response, true);
            if (isset($result['messages'][0]['id'])) {
                // Update database flag
                $this->CI->db->where('id', $appointment['id']);
                $this->CI->db->update('ea_appointments', ['is_whatsapp_sent' => 1]);
                return true;
            }
        }

        return false;
    }
}