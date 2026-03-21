<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProviderProfile;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTeamMemberController extends Controller
{
    public function index()
    {
        $teamMembers = User::whereIn('role', ['admin', 'provider'])->latest()->paginate(10);

        return view('admin.team-members.index', compact('teamMembers'));
    }

    public function create()
    {
        return view('admin.team-members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'display_name' => ['nullable', 'string', 'max:255'],
            'headline' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'languages' => ['nullable', 'string', 'max:255'],
            'response_time' => ['nullable', 'string', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => User::ROLE_PROVIDER,
            ]);

            UserProfile::create([
                'user_id' => $user->id,
                'full_name' => $validated['name'],
                'phone' => $validated['phone'] ?? null,
                'location' => $validated['location'] ?? null,
                'bio' => $validated['bio'] ?? 'Provider account created by admin.',
            ]);

            UserSetting::create([
                'user_id' => $user->id,
                'language' => 'en',
                'theme' => 'light',
                'notifications_enabled' => true,
            ]);

            ProviderProfile::create([
                'user_id' => $user->id,
                'display_name' => $validated['display_name'] ?? $validated['name'],
                'headline' => $validated['headline'] ?? 'Service Provider',
                'bio' => $validated['bio'] ?? 'Provider account created by admin.',
                'country' => $validated['country'] ?? 'Philippines',
                'languages' => $validated['languages'] ?? 'English',
                'response_time' => $validated['response_time'] ?? '1 hour',
                'last_delivery_note' => 'New provider account.',
                'member_since' => now()->toDateString(),
                'avatar_path' => null,
                'github_url' => $validated['github_url'] ?? null,
            ]);
        });

        return redirect()
            ->route('admin.team-members.index')
            ->with('success', 'Provider account created successfully.');
    }
}
