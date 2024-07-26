<?php
namespace Database\Factories;

use App\Models\Resident;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResidentFactory extends Factory
{
    protected $model = Resident::class;

    public function definition()
    {
        $barangay = \App\Models\Barangay::first();
        if($barangay == null) {
            $barangay = \App\Models\Barangay::factory(1)->create();
        }
        return [
            'barangay_id' => $barangay->id,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'middle_name' => $this->faker->lastName,
            'contact_number' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
