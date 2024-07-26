<?php
namespace Test\Main;

use Tests\TestCase;

class TransactionTest extends TestCase
{
    public function test_transaction_endpoint_returns_a_successful_response()
    {
        $response = $this->json('GET', '/api/v1/transactions/queue?token=' . $this->actingAsUser()->token)
        ->seeJson([
            'total' => 0
        ]);

        $response->assertResponseStatus(200);
    }

    public function test_transaction_cancel_endpoint_returns_a_successful_response()
    {
        $user = $this->actingAsUser();
        $resident = \App\Models\Resident::class::factory()->create();
        $transaction = \App\Models\Transactions\TransactionRecord::class::factory([
            'resident_id' => $resident->id,
            'barangay_id' => $user->barangay_id,
        ])->create();

        $response = $this->json('POST', '/api/v1/transactions/'.$transaction->id .  '/cancel?token=' . $user->token)
        ->seeJson([
            'status' => 'success'
        ]);

        $response->assertResponseStatus(200);
    }

    public function test_transaction_complete_endpoint_returns_a_successful_response()
    {
        $user = $this->actingAsUser();
        $resident = \App\Models\Resident::class::factory()->create([
            'barangay_id' => $user->barangay_id
        ]);
        $transaction = \App\Models\Transactions\TransactionRecord::class::factory([
            'resident_id' => $resident->id
        ])->create();

        $response = $this->json('POST', '/api/v1/transactions/'.$transaction->id .  '/complete?token=' . $user->token)
        ->seeJson([
            'status' => 'success'
        ]);

        $response->assertResponseStatus(200);
    }
}
