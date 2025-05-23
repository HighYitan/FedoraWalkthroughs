<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = file_get_contents(resource_path('json/users.json')); //Obtiene el contenido del archivo JSON
        $users = json_decode($jsonData, true); //Convierte el JSON en un array

        foreach($users as $user){
            User::create([
                "name"      => $user["name"],
                "email"     => $user["email"],
                "password"  => $user["password"],
                "role_id"   => $user["role_id"]
            ]);
        }
    }
}
