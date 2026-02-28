<?php

namespace App\Models;

use CodeIgniter\Model;

class SecurityGateLogMDModel extends Model
{
    protected $table            = 'security_gate_logs_md';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'visitor_request_id',
        'v_code',
        'visit_date',
        'check_in_time',
        'check_out_time',
        'verified_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];

    protected $useTimestamps = false; 
    // We are manually handling created_at and updated_at
}