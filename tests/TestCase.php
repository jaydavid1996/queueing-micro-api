<?php

namespace Tests;

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */

    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function loginAsAdmin()
    {
        $user = \App\Models\User::factory()->create();
        $user->assignRole('admin');
        return $user;
    }

    public function actingAsUser()
    {
        $password = 'some-password';
        $barangay = \App\Models\Barangay::factory()->create();

        // every generated e-mail will be accepted
        $user = \App\Models\User::factory()->create([
            'password' => app('hash')->make($password),
            'barangay_id' => $barangay->id
        ]);
        $user->assignRole('admin');

        $token = auth('api')->attempt([
            'email' => $user->email,
            'password' => $password
        ]);

        // $this->withHeaders(
        //     array_merge([
        //         $this->defaultHeaders,
        //         ['Authorization' => 'Bearer ' . $token]
        //     ])
        // );

        return (object)[ 'token' => $token, 'barangay_id' => $user->barangay_id];
    }
}
