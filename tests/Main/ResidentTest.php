<?php
namespace Tests\Main;

use Tests\TestCase;

class ResidentTest extends TestCase
{

    public function test_that_resident_endpoint_returns_a_successful_response()
    {
        $response = $this->json('GET', '/api/v1/residents?token=' . $this->actingAsUser()->token)
        ->seeJson([
            'current_page' => 1,
        ]);

        $response->assertResponseStatus(200);

    }

    public function test_that_resident_getone_endpoint_returns_a_successful_response()
    {
        $user = $this->actingAsUser();
        $resident = \App\Models\Resident::class::factory()->create([
            'barangay_id' => $user->barangay_id
        ]);

        $response = $this->json('GET', '/api/v1/residents/'.$resident->id . '?token=' . $user->token)
        ->seeJson([
            'status' => 'success'
        ]);

        $response->assertResponseStatus(200);

    }

    public function test_that_resident_add_endpoint_returns_a_successful_response()
    {

        $response = $this->json('POST', '/api/v1/residents?token=' . $this->actingAsUser()->token, [
           'first_name' => 'John',
            'last_name' => 'Doe',
            'middle_name' => '',
            'contact_number' => '09090909090',
            'email' => 'test@email.com'

        ])
        ->seeJson([
            'status' => 'success'
        ]);

        $this->seeInDatabase('residents', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'middle_name' => '',
        ]);

        $response->assertResponseStatus(200);

    }

    public function test_that_resident_update_endpoint_returns_a_successful_response()
    {
        $user = $this->actingAsUser();

        $resident = \App\Models\Resident::class::factory()->create([
            'barangay_id' => $user->barangay_id
        ]);

        $response = $this->json('PUT', '/api/v1/residents/'.$resident->id . '?token=' . $user->token, [
           'first_name' => 'John2'
        ]);

        $this->seeInDatabase('residents', [
            'first_name' => 'John2'
        ]);

        $response->assertResponseStatus(200);
    }

}
