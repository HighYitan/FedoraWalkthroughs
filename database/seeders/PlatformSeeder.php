<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = file_get_contents(resource_path('json/platforms.json')); //Obtiene el contenido del archivo JSON
        $platforms = json_decode($jsonData, true); //Convierte el JSON en un array

        foreach($platforms as $platform){
            Platform::create([
                "name"          => $platform["name"],
                "release_year"  => $platform["release_year"],
                "image"         => $platform["image"],
                "company_id"    => $platform["company_id"]
            ]);
        }
    }
}
