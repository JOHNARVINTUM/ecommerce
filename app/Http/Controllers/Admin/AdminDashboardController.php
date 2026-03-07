<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $successfulProjects = Order::where('status', 'completed')->count();
        $inProgressProjects = Order::whereIn('status', ['pending', 'confirmed', 'in_progress'])->count();
        $cancelledProjects = Order::where('status', 'cancelled')->count();
        $totalUsers = User::count();

        return view('admin.dashboard', compact(
            'successfulProjects',
            'inProgressProjects',
            'cancelledProjects',
            'totalUsers'
        ));
    }
}