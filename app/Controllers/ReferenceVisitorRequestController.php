<?php

namespace App\Controllers;

use App\Models\ReferenceModel;
use App\Models\ReferenceVisitorRequestModel;

class ReferenceVisitorRequestController extends BaseController
{
    public function index()
    {
        $refModel = new ReferenceModel();
        // $data['reference_persons'] = $refModel->findAll();

        return view('dashboard/reference_visitor_request');
    }

    public function getAllReferenceVisitorRequest()
    {
        $model = new ReferenceVisitorRequestModel();
        $data = $model->getWithJoin();
        return $this->response->setJSON($data);
    }

    public function create()
    {
        $model = new ReferenceVisitorRequestModel();
        $codeGen = new GenerateCodesController();
        // Generate new RVR code
        $rvrCode = $codeGen->generateRVRCode();

        $data = [
            'rvr_code' => $rvrCode,
            'reference_id' => $this->request->getPost('reference_person_id'),
            'purpose'             => $this->request->getPost('purpose'),
            'visit_date'          => $this->request->getPost('visit_date'),
            'visitor_count'       => $this->request->getPost('visitor_count'),
            'description'         => $this->request->getPost('description'),
            'created_by'          =>  session()->get('user_id'),
        ];

        if ($model->save($data)) {
            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setJSON(['status' => 'error']);
    }


    public function getAllReference(){
        $refModel = new ReferenceModel();
        $referencePersonsData = $refModel->findAll();
        return $this->response->setJSON($referencePersonsData);
    }
    

    public function getReferenceVisitorRequestById($id)
    {
        $model = new ReferenceVisitorRequestModel();
        $data = $model->getWithJoinById($id);

        return $this->response->setJSON($data);
    }


}
