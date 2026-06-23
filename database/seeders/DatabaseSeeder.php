<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = [
            'manage_users' => 'Manage Users',
            'manage_roles_permissions' => 'Manage Roles & Permissions',
            'manage_reports' => 'View & Manage Fire Reports',
            'validate_metadata' => 'Validate Report Metadata',
            'view_heatmap' => 'View Heatmap Monitoring',
            'manage_post_operations' => 'Manage Post-Operation Records',
            'view_audit_logs' => 'View Audit Logs',
            'manage_settings' => 'Manage System Settings',
        ];

        $permissionModels = [];
        foreach ($permissions as $key => $label) {
            $permissionModels[$key] = Permission::firstOrCreate(['key' => $key], ['label' => $label]);
        }

        // Superadmin gets every permission by default.
        foreach ($permissionModels as $permission) {
            RolePermission::firstOrCreate(['role' => 'superadmin', 'permission_id' => $permission->id]);
        }

        // Admin starts with none assigned - the superadmin grants access via
        // the Roles & Permissions page.

        User::firstOrCreate(
            ['email' => 'reyanneramosrey@gmail.com'],
            [
                'role' => 'superadmin',
                'full_name' => 'Reyanne Ramos',
                'contact_number' => '0000000000',
                'password' => Hash::make('Password123!'),
                'account_status' => 'active',
                'date_registered' => now(),
            ]
        );
    }
}
