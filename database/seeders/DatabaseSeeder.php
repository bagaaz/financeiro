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
            ['name' => 'Alimentação', 'color' => '#FF5733'],
            ['name' => 'Beleza', 'color' => '#33FF57'],
            ['name' => 'Educação', 'color' => '#3357FF'],
            ['name' => 'Lazer', 'color' => '#FF33A1'],
            ['name' => 'Moradia', 'color' => '#FF8C33'],
            ['name' => 'Outros', 'color' => '#33FFF5'],
            ['name' => 'Saúde', 'color' => '#F533FF'],
            ['name' => 'Serviços', 'color' => '#FFC733'],
            ['name' => 'Taxas', 'color' => '#33FF8C'],
            ['name' => 'Transporte', 'color' => '#8C33FF'],
            ['name' => 'Vestuários', 'color' => '#FF3333']
        ];

        foreach ($categories as $category) {
            TransactionCategory::create([
                'name' => $category['name'],
                'color' => $category['color'],
            ]);
        }

    }
}
