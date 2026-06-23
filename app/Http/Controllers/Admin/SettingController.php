<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private array $keys = ['system_name', 'location_coverage', 'otp_enabled', 'support_email'];

    public function index()
    {
        $settings = [];
        foreach ($this->keys as $key) {
            $settings[$key] = SystemSetting::get($key);
        }

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'system_name' => 'nullable|string|max:150',
            'location_coverage' => 'nullable|string|max:255',
            'otp_enabled' => 'nullable|boolean',
            'support_email' => 'nullable|email|max:150',
        ]);

        $data['otp_enabled'] = $request->boolean('otp_enabled') ? '1' : '0';

        foreach ($this->keys as $key) {
            SystemSetting::set($key, $data[$key] ?? null, auth()->id());
        }

        ActivityLog::record('settings_updated', 'Updated system settings');

        return redirect()->route('admin.settings')->with('status', 'Settings saved.');
    }
}
