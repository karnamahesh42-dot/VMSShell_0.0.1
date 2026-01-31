<?php

namespace App\Models;
use CodeIgniter\Model;

class GatepassMailLogModel extends Model
{
    protected $table = 'gatepass_mail_logs';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'request_id',
        'v_code',
        'mail_type',
        'email_to',
        'subject',
        'status',
        'error_message',
        'response',
        'sent_by',
        'sent_at'
    ];

    protected $useTimestamps = false;
}
