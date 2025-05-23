<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\BoardSeeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\GameSeeder;
use Database\Seeders\GenreSeeder;
use Database\Seeders\GuideSeeder;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\NewsSeeder;
use Database\Seeders\PlatformSeeder;
use Database\Seeders\RegionSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserInterfaceSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(UserInterfaceSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(PlatformSeeder::class);
        $this->call(RegionSeeder::class);
        $this->call(GameSeeder::class);
        $this->call(GuideSeeder::class);
        $this->call(BoardSeeder::class);
    }
}
