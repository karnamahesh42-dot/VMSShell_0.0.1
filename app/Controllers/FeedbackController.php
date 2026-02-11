<?php

namespace App\Controllers;

use App\Models\FeedbackModel;

class FeedbackController extends BaseController
{
    protected $feedbackModel;

    public function __construct()
    {
        $this->feedbackModel = new FeedbackModel();
    }


    /* =====================================
       MAIN PAGE  (List + Popup form)
       URL: /feedback
    ===================================== */
    public function index()
    {
        $data['feedbacks'] = $this->feedbackModel
                                    ->getFeedbackWithUserDetails(); // joined data
        return view('dashboard/feedback', $data);
    }

    /* =====================================
       SAVE FEEDBACK (AJAX)
       URL: /feedback/save
    ===================================== */
    public function save()
    {
        try {

            $filePath = null;

            /* ---------- FILE UPLOAD ---------- */
            $file = $this->request->getFile('attachment');

            if ($file && $file->isValid() && !$file->hasMoved()) {

                $newName = $file->getRandomName();

                $file->move(FCPATH . 'public/uploads/feedback', $newName);

                $filePath = 'public/uploads/feedback/' . $newName;
            }


            /* ---------- SAVE DATA ---------- */
            $this->feedbackModel->insert([
                'feedback_type'    => $this->request->getPost('feedback_type'),
                'module_name'      => $this->request->getPost('module_name'),
                'rating'           => $this->request->getPost('rating'),
                'comments'         => $this->request->getPost('comments'),
                'suggestion'       => $this->request->getPost('suggestion'),
                'attachment_path'  => $filePath,
                'contact_required' => $this->request->getPost('contact_required') ? 'Y' : 'N',
                'status'           => 'Open',
                'create_by'        => session()->get('user_id'),
                'updated_by'       => session()->get('user_id')
            ]);


            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Feedback submitted successfully'
            ]);

        } catch (\Exception $e) {

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }



    /* =====================================
       UPDATE STATUS (Admin)
       AJAX or normal
    ===================================== */
    public function updateStatus($id)
    {
        $this->feedbackModel->update($id, [
            'status'     => $this->request->getPost('status'),
            'updated_by' => session()->get('user_id')
        ]);

        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }

    /* =====================================
       OPTIONAL: DELETE (future ready)
    ===================================== */
    public function delete($id)
    {
        $this->feedbackModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }
}
