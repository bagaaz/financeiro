<?php

namespace Database\Factories;

use App\Enums\PaymentType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'total_amount' => $this->faker->randomFloat(2, 10, 1000),
            'transaction_date' => $this->faker->date(),
            'transaction_type' => $this->faker->randomElement([TransactionType::Expense, TransactionType::Income]),
            'payment_type' => $this->faker->randomElement([PaymentType::Unique, PaymentType::Installment, PaymentType::Recurring]),
            'installments' => $this->faker->numberBetween(1, 12),
            'status' => $this->faker->randomElement([TransactionStatus::Pending, TransactionStatus::Completed]),
        ];
    }
}
