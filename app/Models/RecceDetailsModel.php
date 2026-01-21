<?php

namespace App\Models;

use CodeIgniter\Model;

class RecceDetailsModel extends Model
{
    protected $table = 'recce_details';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'header_id',
        'recce_type',
        'art_director',
        'company',
        'contact_person',
        'shooting_date',
        'mail_id',
        'mobile',
        'created_at',
        'created_by'
    ];

    protected $useTimestamps = false;
}
