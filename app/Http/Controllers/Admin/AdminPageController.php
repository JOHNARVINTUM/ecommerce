<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminPageController extends Controller
{
    public function index()
    {
        $pages = collect([
            ['title' => 'Home Page', 'slug' => '/'],
            ['title' => 'About Page', 'slug' => '/about'],
            ['title' => 'Services Page', 'slug' => '/services'],
        ]);

        return view('admin.pages.index', compact('pages'));
    }
}