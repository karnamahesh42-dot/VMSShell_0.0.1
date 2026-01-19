<?php

namespace App\Controllers;

use App\Models\ReferenceVisitorRequestModel;

class RVRDetailsController extends BaseController
{
    // Step 1: Redirect using RVR code (alphanumeric)
    public function rvr_redirect($rvr_code)
    {
        $model = new ReferenceVisitorRequestModel();

        // Fetch the record using rvr_code column
         $data = $model->getWithJoinByRVRCode($rvr_code);
        if (!$data) {
            return "Reference request not found!";
        }

        // Redirect to visitor form page with rvr_code as query param
        return redirect()->to(base_url('rvr_details_sheet') . '?rvr_code=' . $data['rvr_code']);
    }

    // Step 2: Load the visitor form page
    public function rvr_details_sheet()
    {
        $rvr_code = $this->request->getGet('rvr_code');

        if (!$rvr_code) {
            return "Invalid RVR Code!";
        }
        
        $model = new ReferenceVisitorRequestModel();
        $data = $model->getWithJoinByRVRCode($rvr_code);

        if (!$data) {
            return "Invalid RVR Code!";
        }

        return view('rvr_details_sheet', ['data' => $data]);
    }
}
