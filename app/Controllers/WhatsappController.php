<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class WhatsappController extends Controller
{
    private $username = "ramojipd";
    private $password = "Sinch@9154680260";

    private $tokenUrl   = "https://auth.aclwhatsapp.com/realms/ipmessaging/protocol/openid-connect/token";
    private $messageUrl = "https://api.aclwhatsapp.com/pull-platform-receiver/v2/wa/messages";
    private $optinUrl   = "https://optin.aclwhatsapp.com/api/v1/optin/bulk"; // NEW


    /*
    =====================================
    TOKEN
    =====================================
    */
    private function getToken()
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->tokenUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                "grant_type" => "password",
                "client_id"  => "ipmessaging-client",
                "username"   => $this->username,
                "password"   => $this->password
            ]),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/x-www-form-urlencoded"
            ]
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        return $data['access_token'] ?? false;
    }


    /*
    =====================================
    STEP 2 — OPT IN USER  ⭐ IMPORTANT
    =====================================
    */
    private function optInUser($token, $mobile)
    {
        $payload = [
            "msisdnList" => [$mobile]
        ];

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->optinUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $token",
                "Content-Type: application/json"
            ]
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }


    /*
    =====================================
    STEP 3 — SEND MESSAGE
    =====================================
    */
    public function send($mobile,$gatepassPath)
    {
        $token = $this->getToken();

        if (!$token) {
            return $this->response->setJSON([
                "status" => "error",
                "message" => "Token failed"
            ]);
        }

        // FIRST OPT-IN
        $optinResponse = $this->optInUser($token, $mobile);

        $pdfUrl = base_url('uploads/gate_pass_pdf/GatePass_V00000001.pdf');

        $payload = [
            "recipient_type" => "individual",
            "to" => $mobile,
            "type" => "template",
            "template" => [
                "name" => "rfcvisitorpass",
                "language" => [
                    "policy" => "deterministic",
                    "code" => "en"
                ],
                "components" => [
                    [
                        "type" => "header",
                        "parameters" => [
                            [
                                "type" => "document",
                                "document" => [
                                    "link" => $gatepassPath,
                                    "filename" => "GatePass.pdf"
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->messageUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $token",
                "Content-Type: application/json"
            ]
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

            return [
            "status" => "success",
             "optin" => $optinResponse,
            "api_response" => json_decode($response, true)
            ];

        // return $this->response->setJSON([
        //     "status" => "success",
        //     "optin" => $optinResponse,
        //     "message_response" => json_decode($response, true)
        // ]);
    }
}