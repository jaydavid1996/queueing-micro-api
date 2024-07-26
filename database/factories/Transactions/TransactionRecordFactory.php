<?php
namespace Database\Factories\Transactions;

use App\Models\Transactions\TransactionRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionRecordFactory extends Factory
{
    protected $model = TransactionRecord::class;

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
