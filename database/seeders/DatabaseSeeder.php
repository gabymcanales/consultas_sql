<?php

namespace Database\Seeders;

use App\Models\Usuarios;
use App\Models\Pedidos;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //NOTA: Primero ejecutar los usuarios para poder ejecutar pedidos
       //Usuarios::factory(5)->create();
       //Pedidos::factory(20)->create();
    }
}
