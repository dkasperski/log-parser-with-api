<?php

declare(strict_types=1);

namespace App\LegalOne\LogParserBundle\Service;

use App\LegalOne\LogParserBundle\Entity\Log;
use App\LegalOne\LogParserBundle\Entity\LogId;
use App\LegalOne\LogParserBundle\Model\CreateLogCommand;
use App\LegalOne\LogParserBundle\Repository\LogRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateLogHandler implements MessageHandlerInterface
{
    private LogRepositoryInterface $logRepository;

    public function __construct(LogRepositoryInterface $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    public function __invoke(CreateLogCommand $createLogCommand): void
    {
        $log = Log::create(
            new LogId(Uuid::uuid4()->toString()),
            $createLogCommand->getService(),
            $createLogCommand->getDate(),
            $createLogCommand->getMethod(),
            $createLogCommand->getPath(),
            $createLogCommand->getCode(),
            $createLogCommand->getCurrentLineNumber(),
        );

        $this->logRepository->save($log);
    }
}
