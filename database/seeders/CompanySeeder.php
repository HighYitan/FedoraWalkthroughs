<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = file_get_contents(resource_path('json/companies.json')); //Obtiene el contenido del archivo JSON
        $companies = json_decode($jsonData, true); //Convierte el JSON en un array

        foreach($companies as $company){
            Company::create([
                "name"              => $company["name"],
                "foundation_year"   => $company["foundation_year"],
                "country_id"        => $company["country_id"],
                "website"           => $company["website"],
                "image"             => $company["image"]
            ]);
        }
    }
}
