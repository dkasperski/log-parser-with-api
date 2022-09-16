<?php

declare(strict_types=1);

namespace App\LegalOne\LogParserBundle\Repository;

use App\LegalOne\LogParserBundle\Entity\Log;

interface LogRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);

    public function save(Log $log): void;
}
