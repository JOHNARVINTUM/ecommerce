<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProviderProfile;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateUser($request);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            UserProfile::create([
                'user_id' => $user->id,
                'full_name' => $validated['name'],
                'phone' => $validated['phone'] ?? null,
                'location' => $validated['location'] ?? null,
                'bio' => $validated['bio'] ?? null,
            ]);

            UserSetting::create([
                'user_id' => $user->id,
                'language' => 'en',
                'theme' => 'light',
                'notifications_enabled' => true,
            ]);

            if ($user->role === User::ROLE_PROVIDER) {
                ProviderProfile::create([
                    'user_id' => $user->id,
                    'display_name' => $validated['name'],
                    'headline' => 'Service Provider',
                    'bio' => $validated['bio'] ?? null,
                    'country' => 'Philippines',
                    'languages' => 'English',
                    'response_time' => '1 hour',
                    'last_delivery_note' => 'New provider account.',
                    'member_since' => now()->toDateString(),
                ]);
            }
        });

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load(['profile']);

        $customerOrders = collect();
        $latestCustomerOrder = null;
        $orderStats = [
            'total' => 0,
            'completed' => 0,
            'ongoing' => 0,
            'cancelled' => 0,
        ];

        if ($user->role === User::ROLE_CUSTOMER) {
            $customerOrders = Order::with(['serviceListing', 'provider'])
                ->where('customer_user_id', $user->id)
                ->latest()
                ->paginate(10);

            $latestCustomerOrder = Order::where('customer_user_id', $user->id)
                ->latest()
                ->first();

            $orderStats = [
                'total' => Order::where('customer_user_id', $user->id)->count(),
                'completed' => Order::where('customer_user_id', $user->id)->where('status', Order::STATUS_COMPLETED)->count(),
                'ongoing' => Order::where('customer_user_id', $user->id)->whereIn('status', [Order::STATUS_PENDING, Order::STATUS_CONFIRMED, Order::STATUS_IN_PROGRESS])->count(),
                'cancelled' => Order::where('customer_user_id', $user->id)->where('status', Order::STATUS_CANCELLED)->count(),
            ];
        }

        return view('admin.users.show', compact('user', 'customerOrders', 'latestCustomerOrder', 'orderStats'));
    }

    public function edit(User $user)
    {
        $user->load('profile');

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $this->validateUser($request, $user);

        DB::transaction(function () use ($validated, $user) {
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
            ];

            if (! empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);

            UserProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $validated['name'],
                    'phone' => $validated['phone'] ?? null,
                    'location' => $validated['location'] ?? null,
                    'bio' => $validated['bio'] ?? null,
                ]
            );

            UserSetting::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'language' => 'en',
                    'theme' => 'light',
                    'notifications_enabled' => true,
                ]
            );

            if ($validated['role'] === User::ROLE_PROVIDER) {
                ProviderProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'display_name' => $user->name,
                        'headline' => optional($user->providerProfile)->headline ?? 'Service Provider',
                        'bio' => $validated['bio'] ?? optional($user->providerProfile)->bio,
                        'country' => optional($user->providerProfile)->country ?? 'Philippines',
                        'languages' => optional($user->providerProfile)->languages ?? 'English',
                        'response_time' => optional($user->providerProfile)->response_time ?? '1 hour',
                        'last_delivery_note' => optional($user->providerProfile)->last_delivery_note ?? 'Profile updated.',
                        'member_since' => optional($user->providerProfile)->member_since ?? now()->toDateString(),
                        'avatar_path' => optional($user->providerProfile)->avatar_path,
                        'github_url' => optional($user->providerProfile)->github_url,
                    ]
                );
            } else {
                $user->providerProfile()?->delete();
            }
        });

        return redirect()->route('admin.users.show', $user)->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account.');
        }

        if (
            $user->customerOrders()->exists()
            || $user->providerOrders()->exists()
            || $user->serviceListings()->exists()
            || $user->paymentsMade()->exists()
            || $user->paymentsReceived()->exists()
        ) {
            return redirect()->route('admin.users.index')->with('error', 'Cannot delete a user with linked records.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    protected function validateUser(Request $request, ?User $user = null): array
    {
        $passwordRules = $user
            ? ['nullable', 'string', 'min:8', 'confirmed']
            : ['required', 'string', 'min:8', 'confirmed'];

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'role' => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_PROVIDER, User::ROLE_CUSTOMER])],
            'password' => $passwordRules,
            'phone' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
        ]);
    }
}
