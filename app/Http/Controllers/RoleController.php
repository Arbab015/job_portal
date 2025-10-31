<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Exception;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Role::orderBy("id", "desc"))
                ->addColumn('serial_no', function () {
                    static $count = 0;
                    $count++;
                    return $count;
                })
                ->addColumn('permissions', function ($role) {
                    return $role->permissions->pluck('name')->implode(', ');
                })
                ->addColumn('actions', function ($role) {
                    $edit =  '<a href="' . route('roles.edit', $role->id) . '">
                        <i class="fa-solid fa-pen-to-square text-primary " role="button" title="Edit">
                        </i>
                        </a>';
                    $delete =  '<form action="' . route('roles.destroy', $role->id) . '" method="POST" style="display:inline;">'
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

        return view("backend.roles.index");
    }
    public function create()
    {
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view("backend.roles.create", [
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:50|unique:roles,name'
            ]);
            $role =  Role::Create(['name' => $request->name]);
            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
            }
            return redirect()->route('roles.index')->with('success', 'Role created Successfully ');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
    public function edit($id)
    {
        try {
            $role = Role::findOrFail($id);
            $has_permissions = $role->permissions->pluck('name');
            $permissions = Permission::orderBy('name', 'asc')->get();
            return view(
                'backend.roles.edit',
                [
                    'has_permissions' => $has_permissions,
                    'permissions' => $permissions,
                    'role' => $role
                ]
            );
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }



    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:50'
            ]);
            $role = Role::findOrFail($id);
            $role->update(['name' => $request->name]);
            if (!empty($request->permission)) {
                $role->syncPermissions($request->permission);
            }
            return redirect()->route('roles.index')->with('success', 'Role Updated Succesfully. ');
        }
         catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == '1062') {
                return redirect()->back()->withInput()->with('error',  'Duplicate name entry');
            }
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            return redirect()->route('roles.index')->with('success', 'Role deleted successfully. ');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
