<?php

namespace Modules\Admin\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
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

    public function testRequiredFieldsForAdminLogin()
    {
        $this->json('POST', 'api/admin/login', ['Accept' => 'application/json'])
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
            "email" => "admin@localhost.com",
            "password" => "Ajay@123"
        ];

        $this->json('POST', 'api/admin/login', $userData, ['Accept' => 'application/json'])
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

    public function testRequiredFieldsForAdminLoan()
    {
        $this->json('GET', 'api/admin/loans', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "status" => ["The status field is invalid."]
                ]
            ]);
    }

    public function testRequiredFieldsForAdminLoanApprove()
    {
        $this->json('GET', 'api/admin/loan/approved', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "id" => ["The id field is required."]
                ]
            ]);
    }
}
