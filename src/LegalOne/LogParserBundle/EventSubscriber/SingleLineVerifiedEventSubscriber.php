<?php

declare(strict_types=1);

namespace App\LegalOne\LogParserBundle\EventSubscriber;

use App\LegalOne\LogParserBundle\Event\SingleLineVerifiedEvent;
use App\LegalOne\LogParserBundle\Model\CreateLogCommand;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class SingleLineVerifiedEventSubscriber implements EventSubscriberInterface
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SingleLineVerifiedEvent::class => 'createLog',
        ];
    }

    public function createLog(SingleLineVerifiedEvent $event): void
    {
        $createLogCommand = new CreateLogCommand();
        $createLogCommand->setService($event->getService());
        $createLogCommand->setDate($event->getDate());
        $createLogCommand->setMethod($event->getMethod());
        $createLogCommand->setPath($event->getPath());
        $createLogCommand->setCode($event->getCode());
        $createLogCommand->setCurrentLineNumber($event->getCurrentLineNumber());

        $this->messageBus->dispatch($createLogCommand);
    }
}
