<?php

namespace App\Http\Controllers;
use App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\JobType;
use App\Models\Designation;
class JobController extends Controller
{
    public function index(){
        return view('jobs.index');
    }




    public function create(){
         $jobtypes = JobType::pluck('title', 'id'); 
          $designations = Designation::pluck('name', 'id'); 
 
        return view('jobs.create', compact('jobtypes', 'designations'));
    }
}
