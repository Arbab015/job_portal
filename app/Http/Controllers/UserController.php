<?php

namespace App\Http\Controllers;

use App\Jobs\ImportUsersCsvJob;
use App\Models\User;
use App\Notifications\ProfileUpdateNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
                ->addColumn('checkbox', function ($user) {
                    return '<input type="checkbox" class="checkbox" data_type="user" title="Select Record" value="' . $user->id . '">';
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
                ->rawColumns(['actions', 'checkbox'])
                ->make(true);
        }
        $user = Auth::user();
        $roles = Role::where('name', '!=', 'Super Admin')->orderBy('name', 'desc')->get();
        $percentage = $user->percentage;
        return view('backend.users.index', compact('percentage', 'roles'));
    }


    public function import(Request $request)
    {
        try {
            $request->validate([
                'csv_file' => 'required|file|mimetypes:text/csv,text/plain',
                'role' => 'required|exists:roles,name'
            ]);
            $user = Auth::user();
            $role = $request->input('role');
            $user_id = $user->id;
            $user_email = User::pluck('email')->toArray();
            $file = $request->file('csv_file');
            logger($file);
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('imports', $filename, 'public');
            ImportUsersCsvJob::dispatch(Storage::disk('public')->path($path), $user_id, $user_email, $role);
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
        return view('backend.users.create', [
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
        return view('backend.users.edit', [
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
                'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
            $user = User::findOrFail($id);
            $change_type = [];
            if ($request->hasFile('profile_picture')) {
                $old_file_path = 'profile_pictures/' . $user->profile_picture;
                if ($user->profile_picture && Storage::disk('public')->exists($old_file_path)) {
                    Storage::disk('public')->delete($old_file_path);
                }
                $image = $request->file('profile_picture');
                $image_name = time() . '_' . $image->getClientOriginalName();

                // Save new image using Storage
                $image->storeAs('profile_pictures', $image_name, 'public');
                $validated_data['profile_picture'] = $image_name;
                $change_type[] = 'profile picture';
                $user->update([
                    'profile_picture' => $validated_data['profile_picture']
                ]);
            }
            if ($request->filled('name') && $validated_data['name'] !== $user->name) {
                $change_type[] = 'name';
            }
            $user->update([
                'name' => $validated_data['name'],
                'email' => $validated_data['email'],
            ]);

            if (!empty($change_type)) {
                $user->notify(new ProfileUpdateNotification($user,  $change_type));
            }
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


    public function bulkDelete(Request $request)
    {
        try {
            User::whereIn('id', $request->ids)->delete();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
