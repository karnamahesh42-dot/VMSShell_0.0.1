<?php

namespace App\Models;
use CodeIgniter\Model;

class VisitorLogModel extends Model
{
    protected $table = 'visitor_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'visitor_request_id',
        'action_type',
        'old_status',
        'new_status',
        'remarks',
        'performed_by',
        'performed_at'
    ];
}
