<?php

namespace App\Models;

use CodeIgniter\Model;

class PurposeModel extends Model
{
    protected $table = 'purposes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['purpose_name', 'status'];
}