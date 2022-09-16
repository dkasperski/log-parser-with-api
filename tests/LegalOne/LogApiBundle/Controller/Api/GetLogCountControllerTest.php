<?php

declare(strict_types=1);

namespace Tests\LegalOne\LogApiBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetLogCountControllerTest extends WebTestCase
{
    public function testGetLogCountEndpoint(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/log');

        $this->assertResponseIsSuccessful();
    }
}
