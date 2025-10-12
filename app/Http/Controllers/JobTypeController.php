<?php

namespace App\Http\Controllers;
use App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\JobType;
use Yajra\DataTables\Facades\DataTables;


class JobTypeController extends Controller
{
     Public function index(Request $request)
     {
               if($request->ajax()){
                   return DataTables::of(JobType::query())
             ->order(function ($query){
                $query->orderBy('created_at', 'desc');
             })
               ->addColumn('actions', function($JobType){
                  $edit = '<button class="btn btn-primary btn-sm edit-btn" 
                                 data-id="'.$JobType->id.'" 
                                 data-title="'.$JobType->title.'"><i class="fa-solid fa-pen-to-square"></i></button>';
                          
                    $delete = '<form action="'. route('job_types.destroy', $JobType->id ) .'" method="POST" style="display:inline;">'
                            . csrf_field()
                            . method_field('DELETE')
                            . '<button type="submit" class="btn btn-danger btn-sm" id="deleteBtn" onclick="confirmDelete(event)"><i class="fa-solid fa-trash-can"></i></button>'
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
          try{
                        $request->validate([
           'title' => 'required|string|max:255|unique:job_types,title'
         ]);

         $jobtype = JobType::findorfail($id);
         $jobtype -> update(['title' => $request->title]);

         return redirect()->route('job_types.index')->with('success', 'Job Title Updated Successfully.');
     }    catch (ValidationException $e) {
        return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);

    } catch (QueryException $e) {
        \Log::error('Database error during update: ' . $e->getMessage());

        return response()->json(['error' => 'Database error during update'], 500);

    } catch (\Exception $e) {
        \Log::error('Unexpected error during update: ' . $e->getMessage());

        return response()->json(['error' => 'An unexpected error occurred'], 500);
    }

     }


     public function destroy($id)
     {
          try{
               $jobtype = JobType::findorfail($id);
               $jobtype->delete();
               return redirect()->route('job_types.index')->with('success', 'Job Type deleted successfully. ');
          }
          catch (ModelNotFoundException $e) {
            return redirect()->route('job_types.index')->with('error', 'Record not found.');

        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { 
                return redirect()->route('job_types.index')->with('error', 'Cannot delete record due to related data.');
            }
            \Log::error('Database error during deletion: ' . $e->getMessage());
            return redirect()->route('job_types.index')->with('error', 'An unexpected database error occurred.');

        } catch (\Exception $e) {
            \Log::error('Unexpected error during deletion: ' . $e->getMessage());
            return redirect()->route('job_types.index')->with('error', 'An unexpected error occurred.');
        }

     }


     
}