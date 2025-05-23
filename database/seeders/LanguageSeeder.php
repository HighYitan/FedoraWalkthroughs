<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = file_get_contents(resource_path('json/languages.json')); //Obtiene el contenido del archivo JSON
        $languages = json_decode($jsonData, true); //Convierte el JSON en un array

        foreach($languages as $language){
            Language::create([
                "locale" => $language["locale"],
                "name" => $language["name"],
                "flag" => $language["flag"] ?? null
            ]);
        }
    }
}
