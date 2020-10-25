<?php

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


            'upload-list',

            'upload-create',

            'upload-edit',

            'upload-delete'

        ];



        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);

        }
    }
}
