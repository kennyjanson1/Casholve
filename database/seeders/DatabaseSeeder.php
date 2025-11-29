<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');
        $this->command->newLine();
        
        // ALWAYS RUN: Required categories
        $this->call([
            CategorySeeder::class,
        ]);

        // OPTIONAL: Uncomment ONLY for testing/presentation
        // Comment these out before deploying to production
        
        $this->call([
        //     UserSeeder::class,
            TransactionSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('✅ Database seeding completed!');
        $this->command->newLine();
    }
}