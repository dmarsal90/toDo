<?php

namespace App\Tests\Task;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Task;

class TaskTest extends WebTestCase
{
    public function test_to_do_list_can_be_displayed(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/to/do/list');

        $this->assertResponseIsSuccessful();
    }

    public function test_task_should_be_able_to_construct(): void
    {
        $task = new Task();
        $this->assertInstanceOf(Task::class, $task);
    }
}
