<?php

namespace App\EventSubscriber;

use App\Event\CreditApprovedEvent;
use App\Service\NotificationService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class CreditApprovedEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private NotificationService $notificationService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CreditApprovedEvent::class => 'onCreditApproved',
        ];
    }

    public function onCreditApproved(CreditApprovedEvent $event): void
    {
        $credit = $event->getCredit();

        $client = $credit->getClient();
        $productName = $credit->getProductName();

        $this->notificationService->createNotification(
            $client,
            'Вам одобрен кредит по продукту ' . $productName);
    }
}