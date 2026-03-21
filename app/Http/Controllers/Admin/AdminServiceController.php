<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceListing;
use Illuminate\Http\RedirectResponse;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = ServiceListing::with(['provider', 'category'])->latest()->paginate(10);

        return view('admin.services.index', compact('services'));
    }

    public function toggle(ServiceListing $service): RedirectResponse
    {
        $service->update([
            'is_active' => ! $service->is_active,
        ]);

        $state = $service->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.services.index')->with('success', "Service {$state} successfully.");
    }

    public function destroy(ServiceListing $service): RedirectResponse
    {
        if ($service->orders()->exists()) {
            return redirect()->route('admin.services.index')->with('error', 'Cannot delete a service with existing orders.');
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}