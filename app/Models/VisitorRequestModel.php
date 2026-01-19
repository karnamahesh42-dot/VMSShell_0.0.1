<?php namespace App\Models;

use CodeIgniter\Model;

class VisitorRequestModel extends Model
{
    protected $table = 'visitors';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'request_header_id',
        'v_code',
        'group_code',
        'visitor_name',
        'visitor_email',
        'visitor_phone',
        'purpose',
        'visit_date',
        'host_user_id',
        'status',
        'validity',
        'created_by',
        'proof_id_type',
        'proof_id_number',
        'description',
        'qr_code',
        // New fields
        'vehicle_no',
        'meeting_status',
        'meeting_completed_at',
        'vehicle_type',
        'vehicle_id_proof',
        'visitor_id_proof',
        'visit_time',
        'securityCheckStatus',
        'spendTime',
        'v_phopto_path'
    ];



}
