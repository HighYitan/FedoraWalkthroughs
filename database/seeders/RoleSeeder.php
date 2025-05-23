<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = file_get_contents(resource_path('json/roles.json')); //Obtiene el contenido del archivo JSON
        $roles = json_decode($jsonData, true); //Convierte el JSON en un array

        foreach($roles as $role){ //Recorre cada rol
            Role::create([
                "name" => $role["name"]
            ]);
        }
    }
}
