<?php

namespace Database\Seeders;

use App\Models\TransactionCategory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Gabriel Oliveira',
            'email' => 'gabriel.acz.br@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $categories = [
            'Alimentação',
            'Educação',
            'Lazer',
            'Moradia',
            'Outros',
            'Saúde',
            'Serviços',
            'Taxas',
            'Transporte',
            'Vestuários'
        ];

        foreach ($categories as $category) {
            TransactionCategory::create([
                'name' => $category,
            ]);
        }

    }
}
