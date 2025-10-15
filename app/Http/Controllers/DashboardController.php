<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\JobType;
class DashboardController extends Controller
{   
     public function index()
    {
        $total_jobs = JobPost::count();
        $total_job_types = JobType::count();
          $total_designations= Designation::count();
        return view('dashboard', compact('total_jobs', 'total_job_types', 'total_designations'));
    }
}