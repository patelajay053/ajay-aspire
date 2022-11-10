<?php

namespace Modules\Loans\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class LoanTest extends TestCase
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

    public function testRequiredFieldsForLoanRequestWithoutAuth()
    {
        $this->json('POST', 'api/loan/create', ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "message" => "Require authentication."
            ]);
    }

    public function testRequiredFieldsForLoanRequest()
    {
        $user = User::where('type', 'Customer')->first();
        $this->actingAs($user, 'customer');
        
        $this->json('POST', 'api/loan/create', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "amount" => ["The amount field is required."],
                    "terms" => ["The terms field is required."],
                ]
            ]);
    }
}
