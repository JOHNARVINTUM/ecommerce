<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceListing;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = ServiceListing::with(['provider', 'category'])->latest()->paginate(10);

        return view('admin.services.index', compact('services'));
    }
}