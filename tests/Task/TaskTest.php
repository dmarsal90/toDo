<?php

namespace App\Tests\Task;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTest extends WebTestCase
{
    public function test_to_do_list_can_be_displayed(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/to/do/list');

        $this->assertResponseIsSuccessful();
    }
}
