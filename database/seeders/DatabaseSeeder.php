<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear Usuario Administrador
        User::create([
            'name' => 'Admin Natural Go',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // 2. Crear Almacenes (Sucursales)
        $sucursal1 = Almacen::create([
            'nombre' => 'Parque Industrial',
            'ubicacion' => 'Av. 4to anillo, Santa Cruz'
        ]);

        $sucursal2 = Almacen::create([
            'nombre' => 'Zona Norte',
            'ubicacion' => 'Av. 8vo anillo, Santa Cruz'
        ]);

        // 3. Crear Categorías
        $cat1 = Categoria::create(['nombre' => 'Suplementos']);
        $cat2 = Categoria::create(['nombre' => 'Cuidado Personal']);

        // 4. Crear Productos
        Producto::create([
            'nombre' => 'Colágeno Hidrolizado',
            'descripcion' => 'Frasco de 500g',
            'precio' => 150.00,
            'stock' => 0, // El stock se manejará por inventarios
            'categoria_id' => $cat1->id
        ]);

        Producto::create([
            'nombre' => 'Aceite de Coco',
            'descripcion' => 'Envase de 250ml',
            'precio' => 45.50,
            'stock' => 0,
            'categoria_id' => $cat2->id
        ]);

        // 5. Crear un Cliente de prueba
        Cliente::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'ci' => '1234567',
            'telefono' => '70012345',
            'email' => 'juan@gmail.com'
        ]);
    }
}