<?php

namespace App\Command;

use App\Service\NotificationService;
use LogicException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:send-notifications',
    description: 'Вызывает метод сервиса для рассылки уведомлений',
)]
class SendNotificationsCommand extends Command
{
    public function __construct(private readonly NotificationService $notificationService)
    {
        parent::__construct();
    }

    /**
     * Функция отправки уведомлений пользователям. По идее должна запускаться по крону.
     * Для проверки можно выполнить команду "make send-notifications"
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->notificationService->sendUserNotification();
        } catch (LogicException $e) {
            //тут можно писать в логи, отправлять ответственному человеку на почту и т.д
            dump($e->getMessage());
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
