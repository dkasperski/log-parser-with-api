<?php

declare(strict_types=1);

namespace App\LegalOne\LogApiBundle\Service;

use App\LegalOne\LogApiBundle\Model\CountLogQuery;
use Doctrine\DBAL\Connection;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class LogCounterHandler implements MessageHandlerInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function __invoke(CountLogQuery $countLogQuery): string
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->select('COUNT(*) AS log_counts')
            ->from('logs', 'l');

        if (!empty($countLogQuery->getServiceNames())) {
            $qb
                ->where('l.service IN (:services)')
                ->setParameter('services', $countLogQuery->getServiceNames(), Connection::PARAM_STR_ARRAY);
        }

        if ($countLogQuery->getStartDate()) {
            $qb
                ->andWhere('l.date >= :startDate')
                ->setParameter('startDate', $countLogQuery->getStartDate()->getDate()->format('Y-m-d H:i:s'));
        }

        if ($countLogQuery->getEndDate()) {
            $qb
                ->andWhere('l.date <= :endDate')
                ->setParameter('endDate', $countLogQuery->getEndDate()->getDate()->format('Y-m-d H:i:s'));
        }

        if ($countLogQuery->getStatusCode()) {
            $qb
                ->andWhere('l.code = :code')
                ->setParameter('code', $countLogQuery->getStatusCode()->getCode());
        }

        $result['counter'] = $qb->executeQuery()->fetchOne();

        return json_encode($result, JSON_THROW_ON_ERROR);
    }
}
