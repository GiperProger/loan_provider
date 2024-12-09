<?php

namespace App\Notificator;

use App\Entity\Notification;

class EmailNotificator implements INotification
{

    public static function sendNotification(Notification $notification): void
    {
        //Логика отправки email сообщения
        dump('Email  notification has been sent to ' . $notification->getClient()->getFirstName());
    }
}