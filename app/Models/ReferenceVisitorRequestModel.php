<?php

namespace App\Models;

use CodeIgniter\Model;

class ReferenceVisitorRequestModel extends Model
{
    protected $table = 'reference_visitor_requests';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'rvr_code',
        'reference_id',
        'purpose',
        'visit_date',
        'visitor_count',
        'description',
        'status',
        'created_by'
    ];

    public function getWithJoin()
    {
        return $this->select('reference_visitor_requests.*, reference.name, reference.phone, reference.email')
                    ->join('reference', 'reference.id = reference_visitor_requests.reference_id', 'left')
                    ->orderBy('reference_visitor_requests.id', 'DESC')
                    ->findAll();
    }

    public function getWithJoinById($id)
    {
        return $this->select('reference_visitor_requests.*, reference.name, reference.phone, reference.email')
                    ->join('reference', 'reference.id = reference_visitor_requests.reference_id', 'left')
                    ->where('reference_visitor_requests.id', $id)
                    ->first();   // single row
    }

    
    public function getWithJoinByRVRCode($id)
    {
        return $this->select('reference_visitor_requests.*, reference.name, reference.phone, reference.email')
                    ->join('reference', 'reference.id = reference_visitor_requests.reference_id', 'left')
                    ->where('reference_visitor_requests.rvr_code', $id)
                    ->first();   // single row
    }

}
