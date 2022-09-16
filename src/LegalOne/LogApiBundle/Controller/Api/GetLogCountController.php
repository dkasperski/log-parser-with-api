<?php

declare(strict_types=1);

namespace App\LegalOne\LogApiBundle\Controller\Api;

use App\LegalOne\LogApiBundle\Model\CountLogQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class GetLogCountController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    #[Route('/api/log', name: "api_log_count", methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $logsCount = $this->handle(
            CountLogQuery::create(
                $request->get('serviceNames'),
                $request->get('startDate'),
                $request->get('endDate'),
                $request->get('statusCode'),
            )
        );

        return JsonResponse::fromJsonString($logsCount);
    }
}
