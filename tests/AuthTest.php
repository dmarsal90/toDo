<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;

class AuthTest extends WebTestCase
{
    public function test_home_can_be_displayed(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }

    public function test_user_should_be_able_to_construct(): void
    {
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
    }

    public function test_a_user_should_have_an_email(): void
    {
        $user = new User();
        $user->setEmail('user@test.dev');
        $email = $user->getEmail();
        $this->assertEquals('user@test.dev', $email);
    }

    public function test_register_can_be_displayed(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
    }

    public function test_a_user_can_register(): void
    {
        $client = static::createClient();
        $client->request('GET', '/register');
        $client->request('POST', '/register', [
            'email' => 'user@test.dev',
            'password' => 'password'
        ]);
        $client->submitForm('Register');
        $this->assertResponseIsSuccessful();
    }
}
