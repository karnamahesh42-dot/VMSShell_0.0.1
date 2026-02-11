<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class WhatsappController extends Controller
{
    /*=====================================
    CONFIG (put your real credentials)
    =====================================*/

    private $username   = "ramojipd";   // Sinch username
    private $password   = "Sinch@9154680260";   // Sinch password
    // Production URLs
    private $tokenUrl   = "https://auth.aclwhatsapp.com/realms/ipmessaging/protocol/openid-connect/token";
    private $messageUrl = "https://api.aclwhatsapp.com/pull-platform-receiver/v2/wa/messages";


    /*=====================================
    GENERATE TOKEN
    ===================================== */
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

        if (!isset($data['access_token'])) {
            return false;
        }
        return $data['access_token'];
    }

    /*=====================================
    SEND MESSAGE
    http://localhost/project/public/whatsapp/send
    =====================================*/

    public function send($mobile,$gatepassPath)
    {
        $token = $this->getToken();

        if (!$token) {
            return $this->response->setJSON([
                "status" => "error",
                "message" => "Token generation failed (check username/password)"
            ]);
        }

        // // change mobile + pdf dynamically if needed
        //  $mobile = "8919146333";
        // // $pdfUrl = "https://access360.ramojifilmcity.com/public/uploads/gate_pass_pdf/GatePass_V00000092.pdf";
        // $pdfUrl = "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf";
        //  $gatepassPath = "https://access360.ramojifilmcity.com/public/uploads/gate_pass_pdf/GatePass_V00000092.pdf";

        $payload = [
            "recipient_type" => "individual",
            "to" => $mobile,
            "type" => "template",
            "template" => [
                "name" => "rfcvisitorpass", // exact match
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
                                    "filename" => "GatePass_V00000002.pdf"
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "metadata" => [
                "messageId" => uniqid("GatePass_"),
                "callbackDlrUrl" => "Visiting"
            ]
        ];


        /*=====================================
        SEND REQUEST
        =====================================*/
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
        // return $this->response->setJSON([
        //     "status" => "success",
        //     "token_used" => $token,
        //     "api_response" => json_decode($response, true)
        // ]);
            return [
            "status" => "success",
            "token_used" => $token,
            "api_response" => json_decode($response, true)
            ];
    }
}
