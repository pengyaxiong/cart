<?php

use Illuminate\Database\Seeder;
use App\Models\System\Role;
use App\Models\System\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create([
            'name' => '超级管理员',
            'slug' => 'admin',
            'description' => '超级管理员',
        ]);
        $userRole = Role::create([
            'name' => '普通用户',
            'slug' => 'user',
            'description' => '普通用户',
        ]);
        /*管理员初始化所有权限*/
        $all_permissions = Permission::all();
        $role_permissions = $all_permissions->pluck('id');
        $adminRole->permissions()->sync($role_permissions);
        /*普通用户赋予一般权限*/
        $dashBackendPer = Permission::where('name', 'admin')->first();

        $userRole->permissions()->sync($dashBackendPer->id);
    }
}
