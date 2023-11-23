<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::latest()->paginate();
        return view('admin.roles.index', compact('roles'));
    }
    public function create()
    {
        $permissions = Permission::latest()->get();
        return view('admin.roles.create', compact('permissions'));
    }
    public function edit(Role $role)
    {
        $rolePermissions = $role->permissions;
        $rolePermissions =  $rolePermissions->pluck('name')->toArray();
       // dd($rolePermissions);
        $permissions = Permission::latest()->get();
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }
    public function store(Request $req)
    {
        //  dd($req->all());
        $req->validate([
            'name' => 'required',
            'display_name' => 'required'
        ]);
        $data = $req->only(['name', 'display_name']);

        $role = Role::create($data);
        $role->givePermissionTo($req->permissions);
        alert()->success(' نقش مورد نظر ایجاد شد', 'باتشکر');
        return redirect()->route('admin.roles.index');
    }


    public function update(Request $req, Role $role)
    {
        $req->validate([
            'name' => 'required',
            'display_name' => 'required'
        ]);
        $data=$req->only('name','display_name');
        $role->update($data);
        $role->syncPermissions($req->permissions);
        alert()->success(' نقش مورد نظر ویرایش شد', 'باتشکر');
        return redirect()->route('admin.roles.index');
    }
}
