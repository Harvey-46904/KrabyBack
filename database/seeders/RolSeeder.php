<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol1=Role::create(['name' => 'Admin']);
        $rol2=Role::create(['name' => 'Cliente']);


        Permission::create(['name' => 'Acceso Login'])->syncRoles([$rol1,$rol2]);
    }
}
