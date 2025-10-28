<?php

namespace App\Http\Controllers;

use App\Jobs\ImportUsersCsvJob;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(User::orderBy('id', 'desc'))

                ->addcolumn('serial_no', function () {
                    static $count = 0;
                    $count++;
                    return $count;
                })
                ->addColumn('roles', function ($user) {
                    return $user->roles->pluck('name')->implode(', ');
                })
                ->addColumn('actions', function ($user) {
                    $edit =  '<a href="' .  route('users.edit', $user->id) . '">
                        <i class="fa-solid fa-pen-to-square text-primary " role="button" title="Edit">
                        </i>
                        </a>';
                    $delete =  '<form action="' . route('users.destroy', $user->id) . '}}" method="POST" style="display:inline;">'
                        . csrf_field()
                        . method_field('DELETE')
                        . '<i class="fa-solid fa-trash-can text-danger" role="button" title="Delete" onclick="confirmDelete(event)">
                                </i>'
                        . '</form>';
                    return $edit . ' ' . $delete;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        $user = Auth::user();
        $percentage = $user->percentage;
        return view('users.index', compact('percentage'));
    }


    public function import(Request $request)
    {
        try {
            $request->validate([
                'csv_file' => 'required|file|mimetypes:text/csv,text/plain',
            ]);
            $user = Auth::user();
            $user_id = $user->id;
            $user_email = User::pluck('email')->toArray();
            $file = $request->file('csv_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('imports', $filename, 'public');
            ImportUsersCsvJob::dispatch(Storage::disk('public')->path($path), $user_id, $user_email );
            return back();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function getPercentage(Request $request)
    {
        $user = Auth::user();
        $import_progress = $user->percentage;
        if ($import_progress) {
            return response()->json(['percentage' => $import_progress]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('name', '!=', 'Super Admin')->orderBy('name', 'desc')->get();
        return view('users.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|max:16|confirmed',
                'role' => 'exists:roles,name',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->syncRoles($request->role);
            return redirect()->route('users.index')->with('success', 'User created successfully');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }



    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::where('name', '!=', 'Super Admin')->orderBy('name', 'desc')->get();
        $hasroles = $user->roles->pluck('name');
        return view('users.edit', [
            'roles' => $roles,
            'user' => $user,
            'hasroles' => $hasroles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated_data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'role' => 'exists:roles,name',
            ]);
            $user = User::findOrFail($id);
            $user->update([
                'name' => $validated_data['name'],
                'email' => $validated_data['email'],
            ]);
            $user->syncRoles($request->role);
            return redirect()->route('users.index')->with('success', 'User updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
