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
    public function test_a_task_should_have_a_title(): void
    {
        $task = new Task();
        $task->setTitle('test');
        $title = $task->getTitle();
        $this->assertEquals('test', $title);
    }

    private function generateRandomString(int $length): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return mb_substr(str_shuffle(str_repeat($chars, ceil($length / mb_strlen($chars)))), 1, $length);
    }

    public function test_a_task_can_be_created(): void
    {
        $taskTitle = $this->generateRandomString(255);
        $client = static::createClient();
        $client->request('GET', '/to/do/list');
        $client->request('POST', '/create', [
            $taskTitle
        ]);
        $client->submitForm('Ok');
        $this->assertResponseRedirects('/to/do/list');
    }

    public function test_to_do_list_contain_title(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/to/do/list');

        $this->assertSelectorTextContains('h2', 'Tasks');
    }

      public function test_a_task_can_be_deleted(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/to/do/list');
        $client->submit($crawler->filter('#delete-form')->form());
        $this->assertNull($client);
        $this->assertResponseRedirects('/to/do/list');
    }
}
