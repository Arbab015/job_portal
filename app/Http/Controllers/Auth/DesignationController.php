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
                    $edit = '<a href="#" class="btn btn-warning btn-sm">Edit</a>';
                    $delete = '<form action="#" method="POST" style="display:inline;">'
                            . csrf_field()
                            . method_field('DELETE')
                            . '<button type="submit" class="btn btn-danger btn-sm">Delete</button>'
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

        return redirect()->route('designations.index')
            ->with('success', 'Designation added successfully.');
    }
}
