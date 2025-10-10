<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->take(6)->get();
        $services = Service::latest()->take(6)->get();
        return view('home', compact('projects', 'services'));
    }
}
