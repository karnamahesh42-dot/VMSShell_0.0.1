<?php

namespace App\Controllers;

class MobileOTPController extends BaseController
{
    
    public function sendOtp()
{
    $mobile = $this->request->getPost('mobile');
    $otp = rand(100000, 999999);

    $apiKey = "c6XtH7C2OjeS8DuGwlaqyxZvFJQNnh3IA5dWPkMzgE0brp4mfRLug58TW2NclG4YsVRxSjrpfQBIo9ZP";
    $route = "dlt";
    $senderId = "YOUR_SENDER_ID"; // Must be approved in Fast2SMS
    $templateId = "YOUR_DLT_TEMPLATE_ID"; // REQUIRED for DLT route

    // The message must match your DLT template exactly!
    $message = urlencode("Your OTP is $otp");

    $url = "https://www.fast2sms.com/dev/bulkV2?"
        . "authorization=$apiKey"
        . "&route=$route"
        . "&sender_id=$senderId"
        . "&message=$message"
        . "&variables_values=$otp"
        . "&flash=0"
        . "&numbers=$mobile"
        . "&schedule_time=";

    // Initialize CURL
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false
    ]);

    $response = curl_exec($curl);

    $error = curl_error($curl);
    curl_close($curl);

    if ($error) {
        return $this->response->setJSON([
            "status" => "error",
            "message" => $error
        ]);
    }

    return $this->response->setJSON([
        "status" => "success",
        "otp" => $otp,
        "api_response" => $response
    ]);
}


}
