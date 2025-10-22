<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'dashboard',
            'designations_listing',
            'add_designation',
            'edit_designation',
            'delete_designation',
            'jobtypes_listing',
            'add_jobtype',
            'edit_jobtype',
            'delete_jobtype',
            'jobs_listing',
            'add_job',
            'edit_job',
            'delete_job',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        Role::firstOrCreate(['name' => 'Super Admin']);
        $user = User::first(); 
        if ($user) {
            $user->assignRole(roles: 'Super Admin');
        }
    }
}
