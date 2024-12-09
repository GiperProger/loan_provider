<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\Notification;
use App\Notificator\EmailNotificator;
use App\Notificator\INotification;
use App\Notificator\SmsNotificator;
use App\Repository\NotificationRepository;
use LogicException;

class NotificationService
{
    public function __construct(private NotificationRepository $notificationRepository)
    {
    }

    //Конечно хранить таким образом классы не самое лучшее решение, но для примера работы интерфейсов сойдет
    private const NOTIFICATORS = [
        EmailNotificator::class,
        SmsNotificator::class
    ];

    /**
     * @throws LogicException
     * @return void
     */
    public function sendUserNotification(): void
    {
        //Берем из базы уведомления порциями и отсылаем пользователям.
        //Альтернативный вариант - использовать очереди
        $notifications = $this->notificationRepository->findNotificationsToSend();

        foreach ($notifications as $notification) {
            /** @var INotification $notificator */
            foreach (self::NOTIFICATORS as $notificator) {
                if (!is_subclass_of($notificator, INotification::class)) {
                    throw new LogicException("Класс {$notificator} должен реализовать интерфейс INotification");
                }

                $notificator::sendNotification();
            }

            $notification->setSent(true);
            $this->notificationRepository->save($notification);
        }
    }
    public function createNotification(Client $client, string $notificationText): void
    {
        $notification = new Notification();
        $notification->setClient($client);
        $notification->setText($notificationText);

        $this->notificationRepository->save($notification);
    }
}
