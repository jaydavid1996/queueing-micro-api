<?php
namespace Database\Factories\Transactions;

use App\Models\Transactions\TransactionComplaint;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionComplaintFactory extends Factory
{
    protected $model = TransactionComplaint::class;

    public function definition()
    {
        return [
            'meta' => [
                'complaint' => $this->faker->sentence,
                'description' => $this->faker->text,
            ],
            'status' => 'onqueue',
            'is_priority' => false,
        ];
    }
}
