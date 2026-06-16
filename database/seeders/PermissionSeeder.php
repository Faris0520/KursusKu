<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Seed roles and permissions.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissionsByRole = [
            'admin' => [
                'manage-users',
                'verify-mentor',
                'manage-categories',
            ],
            'mentor' => [
                'create-course',
                'edit-own-course',
                'delete-own-course',
                'manage-lessons',
                'manage-quizzes',
                'view-student-list',
            ],
            'siswa' => [
                'enroll-course',
                'access-learning',
                'take-quiz',
                'write-review',
            ],
        ];

        foreach ($permissionsByRole as $roleName => $permissions) {
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }

            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($permissions);
        }
    }
}
