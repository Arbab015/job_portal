<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\JobType;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class JobTypeController extends Controller
{
     public function index(Request $request)
     {
           $user = Auth::user();
          if ($request->ajax()) {
               return DataTables::of(JobType::orderBy('id', 'desc'))
                    ->addColumn('serial_no', function () {
                         static $count = 0;
                         $count++;
                         return $count;
                    })
                    ->addColumn('actions', function ($JobType) use ($user) {
                    $edit =  "";
                    $delete = "";
                    if ($user->can('edit_jobtype')) {
                         $edit = '<i class="fa-solid  fa-pen-to-square text-primary edit-btn"
                         role= "button"
                         title="Edit"
                         data-id="' . $JobType->id . '" 
                                 data-title="' . $JobType->title . '">
                        </i>';

                    }
                     if ($user->can('delete_jobtype')) {
                         $delete =  '<form action="' . route('job_types.destroy', $JobType->id) . '" method="POST" style="display:inline;">'
                              . csrf_field()
                              . method_field('DELETE')
                              . '<i class="fa-solid fa-trash-can text-danger" role="button" title="Delete" onclick="confirmDelete(event)">
                                </i>'
                              . '</form>';

                     }
                         return $edit . ' ' . $delete;
                    })

                    ->rawColumns(['actions'])
                    ->make(true);
          }
            $can_edit = $user->can('edit_jobtype');
        $can_delete = $user->can('delete_jobtype');
        $show_actions = $can_edit || $can_delete;

          return view('backend.job_types.index', compact('show_actions'));
     }


     public function store(Request $request)
     {
          try {

               $request->validate([
                    'title' => 'required|string|max:255|unique:job_types,title'
               ]);

               JobType::Create(['title' => $request->title]);
               return redirect()->route('job_types.store')->with('success', 'Job Title Added Successfully. ');
          } catch (Exception $e) {
               return redirect()->back()->withInput()->with('error', $e->getMessage());
          }
     }

     public function update(Request $request, $id)
     {
          try {
               $request->validate([
                    'title' => 'required|string|max:50|unique:job_types,title,',
               ]);

               $jobtype = JobType::findorfail($id);
               $jobtype->update(['title' => $request->title]);

               return redirect()->route('job_types.index')->with('success', 'Job Title Updated Successfully.');
          } catch (Exception $e) {
               return redirect()->back()->withInput()->with('error', $e->getMessage());
          }
     }


     public function destroy($id)
     {
          try {
               $jobtype = JobType::findorfail($id);
               $jobtype->delete();
               return redirect()->route('job_types.index')->with('success', 'Job Type deleted successfully. ');
          } 
          catch (QueryException $e) {
               if ($e->getCode() == 23000) {
                    return redirect()->back()->with('error', 'Cannot delete user as there are related records.');
               }
               throw $e;
          } catch (Exception $e) {
               return redirect()->back()->withInput()->with('error', $e->getMessage());
          }
     }
}
