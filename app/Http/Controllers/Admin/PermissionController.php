<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions= Permission::latest()->paginate();
        return view('admin.permissions.index',compact('permissions'));
    }
    public function create()
    {
        return view('admin.permissions.create');
    }
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit',compact('permission'));
    }
    public function store(Request $req)
    {
        $req->validate([
            'name'=>'required',
            'display_name'=>'required'
        ]);
        Permission::create($req->all());
        alert()->success(' مجوز مورد نظر ایجاد شد', 'باتشکر');
        return redirect()->route('admin.permissions.index');
    }
    public function update(Request $req,Permission $permission)
    {
        $req->validate([
            'name' => 'required',
            'display_name' => 'required'
        ]);
        $permission->update($req->all());
        alert()->success(' مجوز مورد نظر ویرایش شد', 'باتشکر');
        return redirect()->route('admin.permissions.index');
    }
}
