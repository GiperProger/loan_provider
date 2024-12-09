<?php

namespace App\Notificator;

use App\Entity\Notification;

interface INotification
{
    public static function sendNotification(Notification $notification);
}