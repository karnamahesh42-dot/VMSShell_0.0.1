<?php

namespace App\Models;
use CodeIgniter\Model;

class NotificationUserModel extends Model
{
    protected $table = 'notification_users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'notification_id',
        'user_id',
        'is_read',
        'read_at'
    ];


    public function getUnreadNotifications($userId)
    {
        return $this->select('notifications.*')
                    ->join('notifications', 'notifications.id = notification_users.notification_id')
                    ->where('notification_users.user_id', $userId)
                    ->where('notification_users.is_read', 0)
                    ->findAll();
    }
}