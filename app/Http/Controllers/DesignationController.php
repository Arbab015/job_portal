<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Designation;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class DesignationController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {

            return DataTables::of(Designation::orderBy('id', 'desc'))
                ->addColumn('serial_no', function(){
                          static $count= 0;
                          $count++;
                          return $count;
                    })

                ->addColumn('actions', function ($designation) {

                    $edit = '<i class="fa-solid fa-pen-to-square text-primary edit-btn"
                         role= "button"
                         title="Edit"
                         data-id="' . $designation->id . '" 
                           data-name="' . $designation->name . '">
                        </i>';

                    $delete =  '<form action="' . route('designations.destroy', $designation->id) . '" method="POST" style="display:inline;">'
                        . csrf_field()
                        . method_field('DELETE')
                        . '<i class="fa-solid fa-trash-can text-danger" role="button" title="delete" onclick="confirmDelete(event)">
                                </i>'
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
        try {
            $request->validate([
                'name' => 'required|string|max:50|unique:designations',
            ]);

            Designation::create(['name' => $request->name]);

            return redirect()->route('designations.index')->with('success', 'Designation added successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:50|unique:designations',
            ]);

            $designation = Designation::findOrFail($id);
            $designation->update(['name' => $request->name]);
            return redirect()->route('designations.index')->with('success', 'Designation updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            $designation = Designation::findOrFail($id);
            $designation->delete();

            return redirect()->route('designations.index')->with('success', 'Designation deleted successfully.');
        } 
        catch (QueryException $e) {
            if ($e->getCode() == 23000) { 
                return back()->with('error', 'Cannot delete record as it is referenced by other records.');
            }
            throw $e; 
        
        }
         catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
      }
    }