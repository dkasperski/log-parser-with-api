<?php

declare(strict_types=1);

namespace App\LegalOne\LogParserBundle\EventSubscriber;

use App\LegalOne\LogParserBundle\Event\SingleLineParsedEvent;
use App\LegalOne\LogParserBundle\Event\SingleLineVerifiedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class SingleLineParsedEventSubscriber implements EventSubscriberInterface
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SingleLineParsedEvent::class => 'validateSingleLine',
        ];
    }

    public function validateSingleLine(SingleLineParsedEvent $event): void
    {
        //validation single log could be added here

        $this->eventDispatcher->dispatch(new SingleLineVerifiedEvent(
            $event->getService(),
            $event->getDate(),
            $event->getMethod(),
            $event->getPath(),
            $event->getCode(),
            $event->getCurrentLineNumber(),
        ));
    }
}
