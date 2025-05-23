<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\RegionTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = file_get_contents(resource_path('json/regions.json')); //Obtiene el contenido del archivo JSON
        $regions = json_decode($jsonData, true); //Convierte el JSON en un array

        foreach($regions as $region){
            if($region["language_id"] == 1){
                Region::create([
                    "slug" => $region["name"]
                ]);
            }
            RegionTranslation::create([
                "name"          => $region["name"],
                "region_id"     => $region["region_id"],
                "language_id"   => $region["language_id"]
            ]);
        }
    }
}
