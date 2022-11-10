<?php

namespace Modules\Customers\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testRequiredFieldsForLogin()
    {
        $this->json('POST', 'api/customers/login', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);
    }

    public function testSuccessfulLogin()
    {
        $userData = [
            "email" => "patel.ajay053@gmail.com",
            "password" => "Ajay@123"
        ];

        $this->json('POST', 'api/customers/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "data" => [
                    "name",
                    "email",
                    "token"
                ]
            ]);
    }
}
