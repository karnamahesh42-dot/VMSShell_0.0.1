<?php

namespace App\Controllers;

class ReferenceControllere extends BaseController
{
    public function index()
    {
        return view('dashboard/reference');
    }


    public function create()
    {
     
        $visitorModel = new \App\Models\ReferenceModel();

        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),          // NEW
            'description' => $this->request->getPost('description'),  // NEW

            'reference_person_role' => $this->request->getPost('reference_person_role'),
            'status' => $this->request->getPost('status') ?? 1,

            'created_by' => session()->get('user_id')
        ];
        $visitorModel->insert($data);

        return redirect()->back()->with('success', 'Reference Person Created Successfully');
    }


    public function getReferencePersons()
    {
        $visitorModel = new \App\Models\ReferenceModel();

        $data = $visitorModel->orderBy('id', 'DESC')->findAll();

        return $this->response->setJSON($data);
    }
}
