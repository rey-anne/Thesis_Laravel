<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['adminProfile', 'firefighterProfile'])
            ->orderBy('full_name')
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'role' => 'required|in:admin,bfp_firefighter,superadmin',
            'full_name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'contact_number' => 'required|string|max:30',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            ...$data,
            'password' => Hash::make($data['password']),
            'account_status' => 'active',
            'date_registered' => now(),
            'created_by' => auth()->id(),
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        ActivityLog::record('user_created', "Created user {$user->full_name} ({$user->role})");

        return redirect()->route('admin.users')->with('status', 'User created.');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'contact_number' => 'required|string|max:30',
            'account_status' => 'required|in:pending,active,suspended,revoked',
        ]);

        $wasPending = $user->account_status === 'pending';

        $user->update($data);

        if ($wasPending && $data['account_status'] === 'active') {
            $user->update(['approved_by' => auth()->id(), 'approved_at' => now()]);
        }

        if ($user->role === 'admin') {
            $profileData = $request->validate([
                'id_number' => 'nullable|string|max:100',
                'rank' => 'nullable|string|max:100',
                'assigned_fire_station_id' => 'nullable|integer',
                'command_level' => 'nullable|string|max:100',
                'unit_division_handled' => 'nullable|string|max:150',
                'managed_units' => 'nullable|string',
                'area_of_jurisdiction' => 'nullable|string|max:150',
                'official_email' => 'nullable|email|max:150',
                'official_contact_number' => 'nullable|string|max:30',
            ]);

            $user->adminProfile()->updateOrCreate([], $profileData);
        } elseif ($user->role === 'bfp_firefighter') {
            $profileData = $request->validate([
                'bfp_id_number' => 'nullable|string|max:100',
                'rank' => 'nullable|string|max:100',
                'assigned_fire_station_id' => 'nullable|integer',
                'duty_status' => 'nullable|string|max:50',
                'unit_division' => 'nullable|string|max:150',
                'official_email' => 'nullable|email|max:150',
                'official_contact_number' => 'nullable|string|max:30',
            ]);

            $user->firefighterProfile()->updateOrCreate([], $profileData);
        }

        ActivityLog::record('user_updated', "Updated user {$user->full_name}");

        return redirect()->route('admin.users')->with('status', 'User updated.');
    }

    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => 'required|in:admin,bfp_firefighter,superadmin',
        ]);

        $previousRole = $user->role;
        $user->update($data);

        ActivityLog::record('user_role_updated', "Changed role for {$user->full_name} from {$previousRole} to {$data['role']}");

        return redirect()->route('admin.users')->with('status', "Role updated for {$user->full_name}.");
    }

    public function destroy(User $user)
    {
        $name = $user->full_name;
        $user->delete();

        ActivityLog::record('user_deleted', "Deleted user {$name}");

        return redirect()->route('admin.users')->with('status', 'User deleted.');
    }

    public function resetPassword(User $user)
    {
        $newPassword = Str::random(10);
        $user->update(['password' => Hash::make($newPassword)]);

        ActivityLog::record('user_password_reset', "Reset password for {$user->full_name}");

        return redirect()->route('admin.users')->with('status', "New password for {$user->full_name}: {$newPassword}");
    }
}
