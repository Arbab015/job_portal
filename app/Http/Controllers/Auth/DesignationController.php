<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;
use Yajra\DataTables\Facades\DataTables;

class DesignationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Designation::query();

            return DataTables::of($query)
                ->addColumn('actions', function ($designation) {
                    
                    $edit = '<button class="btn btn-primary btn-sm edit-btn" 
                                 data-id="'.$designation->id.'" 
                                 data-name="'.$designation->name.'">Edit</button>';
                          
                    $delete = '<form action="'.route('designations.destroy', $designation->id).'" method="POST" style="display:inline;">'
                            . csrf_field()
                            . method_field('DELETE')
                            . '<button type="submit" class="btn btn-danger btn-sm" id="deleteBtn">Delete</button>'
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
        $request->validate([
            'name' => 'required|string|max:255|unique:designations,name',
        ]);

        Designation::create(['name' => $request->name]);

        return redirect()->route('designations.index')->with('success', 'Designation added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:designations,name,' . $id,
        ]);

        $designation = Designation::findOrFail($id);
        $designation->update(['name' => $request->name]);
        return redirect()->route('designations.index')->with('success', 'Designation updated successfully.');
    }

    public function destroy($id)
    {
        $designation = Designation::findOrFail($id);
        $designation->delete();

        return redirect()->route('designations.index')->with('success', 'Designation deleted successfully.');
    }
}
