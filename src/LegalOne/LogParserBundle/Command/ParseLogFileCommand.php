<?php

declare(strict_types=1);

namespace App\LegalOne\LogParserBundle\Command;

use App\LegalOne\LogParserBundle\Entity\Log;
use App\LegalOne\LogParserBundle\Event\SingleLineParsedEvent;
use App\LegalOne\LogParserBundle\LogParser\LogIterator;
use App\LegalOne\LogParserBundle\LogParser\SingleLineParser;
use Doctrine\Persistence\ManagerRegistry;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class ParseLogFileCommand extends Command
{
    public static $defaultName = 'app:parse-log-file';

    protected static $defaultDescription = 'Parse log file and persist to db.';

    private ContainerBagInterface $containerBag;

    private ManagerRegistry $doctrine;

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        ContainerBagInterface $containerBag,
        ManagerRegistry $doctrine,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->containerBag = $containerBag;
        $this->doctrine = $doctrine;
        $this->eventDispatcher = $eventDispatcher;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $singleLineLogFileFormat = $this->containerBag->get('app.single_line_log_file_format');
        $parser = new SingleLineParser($singleLineLogFileFormat);

        $startFromLineNumber = $this->doctrine->getRepository(Log::class)->findingLastLineParsedLogFile();
        $logIterator = new LogIterator($this->containerBag->get('app.log_file_path'), $parser, $startFromLineNumber);

        $output->writeln([
            'Start of log parsing',
            '============',
            '',
        ]);

        foreach ($logIterator as $data) {
            if (is_array($data)) {
                $this->eventDispatcher->dispatch(new SingleLineParsedEvent(
                    $data['service'],
                    $data['date'],
                    $data['method'],
                    $data['path'],
                    $data['code'],
                    $data['current_line_number'],
                ));
            }
        }

        $output->writeln([
            'Finish of log parsing',
            '============',
            '',
        ]);
        return Command::SUCCESS;
    }
}
