<?php
namespace Tests\Main;

use Tests\TestCase;

class BarangayTest extends TestCase
{

    public function test_that_barangay_endpoint_returns_a_successful_response()
    {
        $response = $this->json('GET', '/api/v1/barangays?token=' . $this->actingAsUser()->token)
        ->seeJson([
            'current_page' => 1,
        ]);

        $response->assertResponseStatus(200);

    }

    public function test_that_barangay_getone_endpoint_returns_a_successful_response()
    {
        $user = $this->actingAsUser();
        $barangay = \App\Models\Barangay::class::factory()->create();

        $response = $this->json('GET', '/api/v1/barangays/'.$barangay->id . '?token=' . $user->token)
        ->seeJson([
            'status' => 'success'
        ]);

        $response->assertResponseStatus(200);
    }

    public function test_that_barangay_create_endpoint_returns_a_successful_response()
    {

        $response = $this->json('POST', '/api/v1/barangays?token=' . $this->actingAsUser()->token, [
            'name' => 'Barangay 1',
            'address' => 'Address 1'
        ])
        ->seeJson([
            'status' => 'success'
        ]);

        $this->seeInDatabase('barangays', [
            'name' => 'Barangay 1',
            'address' => 'Address 1',
        ]);

        $response->assertResponseStatus(200);

    }

    public function test_that_barangay_update_endpoint_returns_a_successful_response()
    {
        $user = $this->actingAsUser();
        $barangay = \App\Models\Barangay::class::factory()->create();

        $response = $this->json('PUT', '/api/v1/barangays/'.$barangay->id . '?token=' . $user->token, [
            'name' => 'Barangay 2',
            'address' => 'Address 2'
        ])
        ->seeJson([
            'status' => 'success'
        ]);
     
        $this->seeInDatabase('barangays', [
            'name' => 'Barangay 2',
            'address' => 'Address 2',
        ]);

        $response->assertResponseStatus(200);
    }

}