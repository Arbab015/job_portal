<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\JobType;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index()
  {
    # Jobs per year
    $jobs_per_year = JobPost::select(
      DB::raw('YEAR(created_at) as year'),
      DB::raw('COUNT(*) as total_jobs')
    )
      ->groupBy('year')
      ->get();
    $jobsperyear = $jobs_per_year->pluck('total_jobs');

    # jobtypes per year
    $jobtypes_per_year = JobType::select(
      DB::raw('YEAR(created_at) as year'),
      DB::raw('COUNT(*) as total_jobtypes')
    )
      ->groupBy('year')
      ->get();
    $jobtypesperyear = $jobtypes_per_year->pluck('total_jobtypes');

    # Designations per year
    $designations_per_year = Designation::select(
      DB::raw('YEAR(created_at) as year'),
      DB::raw('COUNT(*) as total_designations')
    )
      ->groupBy('year')
      ->get();

      
    $designationsperyear = $designations_per_year->pluck( 'total_designations', 'year' );
    $total_jobs = JobPost::count();
    $total_job_types = JobType::count();
    $total_designations = Designation::count();
    return view('backend.dashboard', compact('total_jobs', 'total_job_types', 'total_designations', 'jobsperyear', 'jobtypesperyear', 'designationsperyear'));
  }
}
