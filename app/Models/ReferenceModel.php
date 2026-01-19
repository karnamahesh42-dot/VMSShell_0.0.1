<?php

namespace App\Models;

use CodeIgniter\Model;

class ReferenceModel extends Model
{
    protected $table = 'reference';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'email',
        'phone',
        'address',        // NEW
        'description',    // NEW
        'reference_person_role',
        'status',
        'created_by',
    ];
}
