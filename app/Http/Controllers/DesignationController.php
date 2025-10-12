<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Designation;
use Yajra\DataTables\Facades\DataTables;

class DesignationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
           
            return DataTables::of(Designation::query())
             ->order(function ($query){
                $query->orderBy('created_at', 'desc');
             })
                ->addColumn('actions', function ($designation) {
                    
                    $edit = '<button class="btn btn-primary btn-sm edit-btn" 
                                 data-id="'.$designation->id.'" 
                                 data-name="'.$designation->name.'"><i class="fa-solid fa-pen-to-square"></i></button>';
                          
                    $delete = '<form action="'.route('designations.destroy', $designation->id).'" method="POST" style="display:inline;">'
                            . csrf_field()
                            . method_field('DELETE')
                            . '<button type="submit" class="btn btn-danger btn-sm" id="deleteBtn" onclick="confirmDelete(event)" ><i class="fa-solid fa-trash-can"></i></button>'
                            . '</form>';
                    return $edit . ' ' . $delete;
            
                })
                ->rawColumns(['actions'])
                ->make(true);
        }   
        return view('designations.index');
    }

    public function store(Request $request)
    {

        try{
        $request->validate([
            'name' => 'required|string|max:255|unique:designations',
        ]);

        Designation::create(['name' => $request->name]);

        return redirect()->route('designations.index')->with('success', 'Designation added successfully.');
    }
    catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $e->errors(),
            ], 422); 

        } catch (QueryException $e) {
            \Log::error('Database error during product creation: ' . $e->getMessage());
            return response()->json([
                'error' => 'Could not create product due to a database error.',
            ], 500); 

        } catch (Exception $e) {
            \Log::error('Unexpected error during product creation: ' . $e->getMessage());
            return response()->json([
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:255|unique:designations' . $id,
            ]);
            
            $designation = Designation::findOrFail($id);
            $designation->update(['name' => $request->name]);
            return redirect()->route('designations.index')->with('success', 'Designation updated successfully.');
        }


        catch (ValidationException $e) {
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

            $designation = Designation::findOrFail($id);
            $designation->delete();
           
            return redirect()->route('designations.index')->with('success', 'Designation deleted successfully.');
        }
          catch (ModelNotFoundException $e) {
            return redirect()->route('designation.index')->with('error', 'Record not found.');

        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { 
                return redirect()->route('designation.index')->with('error', 'Cannot delete record due to related data.');
            }
            \Log::error('Database error during deletion: ' . $e->getMessage());
            return redirect()->route('designation.index')->with('error', 'An unexpected database error occurred.');

        } catch (\Exception $e) {
            \Log::error('Unexpected error during deletion: ' . $e->getMessage());
            return redirect()->route('designation.index')->with('error', 'An unexpected error occurred.');
        }
        

    }
}