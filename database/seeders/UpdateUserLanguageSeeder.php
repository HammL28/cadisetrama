<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateUserLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update all users who don't have a language set to default 'id'
        User::whereNull('language')->update(['language' => 'id']);
        
        $this->command->info('Updated user languages to default Indonesian (id)');
    }
}
