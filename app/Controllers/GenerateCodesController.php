<?php

namespace App\Controllers;

use App\Models\ReferenceModel;
use App\Models\ReferenceVisitorRequestModel;

class GenerateCodesController extends BaseController
{
        public function generateRVRCode()
        {
            $model = new \App\Models\ReferenceVisitorRequestModel();

            // Get last inserted record
            $last = $model->orderBy('id', 'DESC')->first();

            if (!$last) {
            $nextNumber = 1;
            } else {
            // Extract last 4-digit number
            $lastCode = intval(substr($last['rvr_code'], -6));
            $nextNumber = $lastCode + 1;
            }
            // Format as 4-digit padded number
            $formatted = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
            return "RVR" . $formatted;
        }


            

        
        public function generateVisitorsCode()
        {
            $model = new \App\Models\VisitorRequestModel();
            // Get last inserted record
            $last = $model->orderBy('id', 'DESC')->first();

            if (!$last) {
            $nextNumber = 1;
            } else {
            // Extract last 4-digit number
            $lastCode = intval(substr($last['v_code'], -8));
            $nextNumber = $lastCode + 1;
            }
            // Format as 4-digit padded number
            $formatted = str_pad($nextNumber, 8, '0', STR_PAD_LEFT);
            return "V" . $formatted;
        }

 
        public function generateGroupVisitorsCode()
        {
            $model = new \App\Models\VisitorRequestModel();
            // Get last inserted record
            $last = $model->orderBy('id', 'DESC')->first();

            if (!$last) {
            $nextNumber = 1;
            } else {
            // Extract last 4-digit number
            $lastCode = intval(substr($last['group_code'], -8));
            $nextNumber = $lastCode + 1;
            }
            // Format as 4-digit padded number
            $formatted = str_pad($nextNumber, 8, '0', STR_PAD_LEFT);
            return "GV" . $formatted;
        }
        
}
