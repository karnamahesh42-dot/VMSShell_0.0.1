<?php

namespace App\Models;
use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'title',
        'message',
        'type',
        'attachment',
        'status',
        'created_at'
    ];

}