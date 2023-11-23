<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {



        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }
    public function edit(User $user)
    {
        $roles = Role::all();

        $permissions = Permission::all();
        $userRoles = $user->roles;

        $userPermissionsIDs = $user->permissions->pluck('id')->toArray();
        return view('admin.users.edit', compact('user', 'roles', 'userRoles', 'userPermissionsIDs', 'permissions'));
    }
    public function update(Request $req, User $user)
    {
        // dd($req->all());

        $user->update($req->only('name', 'cellphone'));
        $user->syncRoles($req->role);
        $user->syncPermissions($req->permissions);

        alert()->success('کاربر ویرایش شد!', 'باتشکر');
        return redirect()->route('admin.users');
    }
}
