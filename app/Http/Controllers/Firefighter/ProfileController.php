<?php

namespace App\Http\Controllers\Firefighter;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->firefighterProfile ?? $user->firefighterProfile()->make();

        return view('firefighter.profile', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'full_name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'contact_number' => 'required|string|max:30',
            'password' => 'nullable|min:8',
            'profile_photo' => 'nullable|image|max:4096',
            'bfp_id_number' => 'nullable|string|max:100',
            'official_email' => 'nullable|email|max:150',
            'official_contact_number' => 'nullable|string|max:30',
            'duty_status' => 'nullable|string|max:50',
        ]);

        $photoPath = $user->profile_photo_path;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $user->update([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'contact_number' => $data['contact_number'],
            'profile_photo_path' => $photoPath,
            ...($data['password'] ? ['password' => Hash::make($data['password'])] : []),
        ]);

        $user->firefighterProfile()->updateOrCreate(['user_id' => $user->id], [
            'bfp_id_number' => $data['bfp_id_number'] ?? null,
            'official_email' => $data['official_email'] ?? null,
            'official_contact_number' => $data['official_contact_number'] ?? null,
            'duty_status' => $data['duty_status'] ?? null,
        ]);

        ActivityLog::record('profile_updated', "{$user->full_name} updated their profile");

        return redirect()->route('firefighter.profile')->with('status', 'Profile updated.');
    }
}
