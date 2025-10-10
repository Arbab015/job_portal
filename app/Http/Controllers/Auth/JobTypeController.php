<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobType;
use Yajra\DataTables\Facades\DataTables;


class JobTypeController extends Controller
{
     Public function index(Request $request)
     {
               if($request->ajax()){
                    
                   $jobtypes = JobType::query();
                   
                   return DataTables::of($jobtypes)
                   
               ->addColumn('actions', function($JobType){
                  $edit = '<button class="btn btn-primary btn-sm edit-btn" 
                                 data-id="'.$JobType->id.'" 
                                 data-title="'.$JobType->title.'">Edit</button>';
                          
                    $delete = '<form action="'. route('job_types.distroy', $JobType->id ) .'" method="POST" style="display:inline;">'
                            . csrf_field()
                            . method_field('DELETE')
                            . '<button type="submit" class="btn btn-danger btn-sm" id="deleteBtn">Delete</button>'
                            . '</form>';
                    return $edit . ' ' . $delete;
               })
               
          ->rawColumns(['actions'])
                ->make(true);
          }   
           return view('job_types.index');
     }


     public function store(Request $request){
             
          $request->validate([
               'title' => 'required|string|max:255|unique:job_types,title'
          ]);

        

          JobType::Create(['title'=> $request->title]);
          
          return redirect()->route('job_types.store')->with('success', 'Job Title Added Successfully. ');

     }

     public function update(Request $request, $id)
     {
         $request->validate([
           'title' => 'required|string|max:255|unique:job_types,title'
         ]);

         $jobtype = JobType::findorfail($id);
         $jobtype -> update(['title' => $request->title]);

         return redirect()->route('job_types.index')->with('success', 'Job Title Updated Successfully.');

     }




     public function distroy($id)
     {
          $jobtype = JobType::findorfail($id);
          $jobtype->delete();

          return redirect()->route('job_types.index')->with('success', 'Job Type deleted successfully. ');
     }


     
}