<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminTeamMemberController extends Controller
{
    public function index()
    {
        $teamMembers = User::whereIn('role', ['admin', 'provider'])->latest()->paginate(10);

        return view('admin.team-members.index', compact('teamMembers'));
    }
}