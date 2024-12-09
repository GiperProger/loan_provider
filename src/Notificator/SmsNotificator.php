<?php

namespace App\Notificator;

use App\Entity\Notification;

class SmsNotificator implements INotification
{

    public static function sendNotification(Notification $notification): void
    {
        //Логика отправки sms сообщения
        dump('SMS  notification has been sent to ' . $notification->getClient()->getFirstName());

    }
}