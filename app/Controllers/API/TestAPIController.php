<?php

namespace App\Controllers\API;

use CodeIgniter\Controller;

class TestAPIController extends Controller
{
    protected $headerModel;

    public function __construct()
    {
        $this->headerModel = new \App\Models\VisitorRequestHeaderModel();
    
    }


    /*
    ==================================
    GET ALL VISITORS
    ==================================
    */
    public function visitorsList()
    {
        $data = $this->headerModel->findAll();

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }


    /*
    ==================================
    CREATE REQUEST (Single/Group)
    ==================================
    */
    public function createRequest()
    {
        $post = $this->request->getJSON(true);

        $id = $this->headerModel->insert($post);

        return $this->response->setJSON([
            'status' => true,
            'message'=> 'Request created',
            'id' => $id
        ]);
    }


    /*
    ==================================
    APPROVE REQUEST
    ==================================
    */
    public function approveRequest()
    {
        $id = $this->request->getPost('id');

        $this->headerModel->update($id, [
            'status' => 'Approved'
        ]);

        return $this->response->setJSON([
            'status' => true,
            'message'=> 'Approved successfully'
        ]);
    }


    /*
    ==================================
    SEND GATE PASS (reuse MailController)
    ==================================
    */
    public function sendGatePass()
    {
        $mail = new \App\Controllers\MailController();

        return $mail->sendMail(); // reuse existing
    }


    /*
    ==================================
    MEETING COMPLETE
    ==================================
    */
    public function completeMeeting()
    {
        $id = $this->request->getPost('id');

        $this->headerModel->update($id, [
            'meeting_status' => 'Completed'
        ]);

        return $this->response->setJSON([
            'status' => true,
            'message'=> 'Meeting completed. Exit enabled'
        ]);
    }
}
