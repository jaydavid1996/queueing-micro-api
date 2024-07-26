<?php
namespace Database\Factories;

use App\Models\Barangay;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangayFactory extends Factory
{
    protected $model = Barangay::class;

    public function definition()
    {
        
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
        ];
    }
}