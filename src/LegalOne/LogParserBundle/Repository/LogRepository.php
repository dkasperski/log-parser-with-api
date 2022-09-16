<?php

declare(strict_types=1);

namespace App\LegalOne\LogParserBundle\Repository;

use App\LegalOne\LogParserBundle\Entity\Log;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;
use \Doctrine\Persistence\ObjectManager as EntityManager;

class LogRepository extends ServiceEntityRepository implements LogRepositoryInterface
{
    private EntityManager $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        $this->entityManager = $registry->getManager();
        parent::__construct($registry, Log::class);
    }

    public function save(Log $log): void
    {
        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }

    public function findingLastLineParsedLogFile(): ?int
    {
        $qb = $this->createQueryBuilder('l')
            ->select('MAX(l.currentLineNumber) AS current_line_number');

        return $qb->getQuery()->getResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }
}
