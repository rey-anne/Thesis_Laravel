<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('label')->get();
        $adminPermissionIds = RolePermission::where('role', 'admin')->pluck('permission_id')->all();

        return view('admin.roles.index', compact('permissions', 'adminPermissionIds'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        $selected = $data['permissions'] ?? [];

        RolePermission::where('role', 'admin')->delete();
        foreach ($selected as $permissionId) {
            RolePermission::create(['role' => 'admin', 'permission_id' => $permissionId]);
        }

        ActivityLog::record('roles_updated', 'Updated permissions assigned to the Admin role');

        return redirect()->route('admin.roles')->with('status', 'Permissions updated.');
    }
}
