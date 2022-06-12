<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'package-list',
            'package-create',
            'package-edit',
            'package-delete',
            'slider-list',
            'slider-create',
            'slider-edit',
            'slider-delete'
         ];
      
         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
         }
    }
}
