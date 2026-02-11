<?php

namespace App\Models;

use CodeIgniter\Model;

class FeedbackModel extends Model
{
    protected $table = 'feedback';
    protected $primaryKey = 'feedback_id';

    protected $allowedFields = [
        'feedback_type',
        'module_name',
        'rating',
        'comments',
        'suggestion',
        'attachment_path',
        'contact_required',
        'status',
        'create_by',
        'updated_by'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getFeedbackWithUserDetails()
    {
        $session = session();

        $roleId   = $session->get('role_id');
        $userId   = $session->get('user_id');
        $deptId   = $session->get('dep_id');

        $builder = $this->select('
                        feedback.*,
                        u.name as user_name,
                        u.email as user_email,
                        d.department_name,
                        u.company_name
                    ')
                    ->join('users u', 'u.id = feedback.create_by', 'left')
                    ->join('departments d', 'd.id = u.department_id', 'left');


        /* ===========================
        ROLE BASED FILTERING
        =========================== */

        // Role 1 & 5 → show ALL
        if (in_array($roleId, [1,5])) {

            // no filter

        }
        // Role 2 → department only
        elseif ($roleId == 2) {

            $builder->where('u.department_id', $deptId);

        }
        // Role 3 & 4 → only self created
        else {

            $builder->where('feedback.create_by', $userId);

        }


        return $builder
                ->orderBy('feedback.feedback_id', 'DESC')
                ->findAll();
    }

}
