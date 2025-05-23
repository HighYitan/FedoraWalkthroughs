<?php

namespace Database\Seeders;

use App\Models\UserInterface;
use App\Models\UserInterfaceTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserInterfaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = file_get_contents(resource_path('json/user_interfaces.json')); //Obtiene el contenido del archivo JSON
        $userInterfaces = json_decode($jsonData, true); //Convierte el JSON en un array

        foreach($userInterfaces as $userInterface){
            if($userInterface["language_id"] == 1){
                UserInterface::create([
                    "slug" => $userInterface["name"]
                ]);
            }
            UserInterfaceTranslation::create([
                "name" => $userInterface["name"],
                "user_interface_id" => $userInterface["user_interface_id"],
                "language_id" => $userInterface["language_id"]
            ]);
        }
    }
}
