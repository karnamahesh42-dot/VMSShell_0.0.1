<?php namespace App\Models;

use CodeIgniter\Model;

class ExpiredVisitorPassModel extends Model
{
    protected $table = 'expired_visitor_passes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'visitor_request_id',
        'visitor_code',
        'header_code',
        'expired_at'
    ];
}