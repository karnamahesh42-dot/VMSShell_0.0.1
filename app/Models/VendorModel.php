<?php

namespace App\Models;

use CodeIgniter\Model;

class VendorModel extends Model
{
    protected $table      = 'vendors';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'header_id',
        'category',
        'status',
        'company',
        'location',
        'contact_person',
        'email',
        'mobile',
        'created_by',
        'created_at',
    ];

    protected $useTimestamps = false;
 
}
