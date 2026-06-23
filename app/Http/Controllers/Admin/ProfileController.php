<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->adminProfile ?? $user->adminProfile()->make();

        return view('admin.profile', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'full_name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'contact_number' => 'required|string|max:30',
            'password' => 'nullable|min:8',
            'rank' => 'nullable|string|max:100',
            'command_level' => 'nullable|string|max:100',
            'unit_division_handled' => 'nullable|string|max:255',
            'area_of_jurisdiction' => 'nullable|string|max:255',
            'official_email' => 'nullable|email|max:150',
            'official_contact_number' => 'nullable|string|max:30',
        ]);

        $user->update([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'contact_number' => $data['contact_number'],
            ...($data['password'] ? ['password' => Hash::make($data['password'])] : []),
        ]);

        $user->adminProfile()->updateOrCreate(['user_id' => $user->id], [
            'rank' => $data['rank'] ?? null,
            'command_level' => $data['command_level'] ?? null,
            'unit_division_handled' => $data['unit_division_handled'] ?? null,
            'area_of_jurisdiction' => $data['area_of_jurisdiction'] ?? null,
            'official_email' => $data['official_email'] ?? null,
            'official_contact_number' => $data['official_contact_number'] ?? null,
        ]);

        ActivityLog::record('profile_updated', "{$user->full_name} updated their profile");

        return redirect()->route('admin.profile')->with('status', 'Profile updated.');
    }
}
