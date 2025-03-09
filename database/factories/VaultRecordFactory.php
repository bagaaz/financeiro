<?php

namespace Database\Factories;

use App\Enums\VaultRecordType;
use App\Models\Vault;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VaultRecord>
 */
class VaultRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vault_id' => Vault::factory(),
            'type' => $this->faker->randomElement([VaultRecordType::Deposit, VaultRecordType::Exit, VaultRecordType::Income]),
            'amount' => $this->faker->randomFloat(2, 5, 1000),
        ];
    }
}
