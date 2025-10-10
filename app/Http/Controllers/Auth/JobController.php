<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobType;
use App\Models\Designation;
class JobController extends Controller
{
    public function index(){
        return view('jobs.index');
    }




    public function add(){
         $jobtype = JobType::pluck('title', 'id'); 
          $designation = Designation::pluck('name', 'id'); 
 
        return view('jobs.add', compact('jobtype', 'designation'));
    }
}
