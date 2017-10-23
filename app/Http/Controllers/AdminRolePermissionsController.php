<?php

use \Redirect as Redirect;
use \HelloVideo\Role;
use \HelloVideo\Permission;

class AdminRolePermissionsController extends \BaseController
{

    public function index()
    {
        $search_value = Input::get('s');
        if (!empty($search_value)) {
            $roles = Role::where('name', 'LIKE', '%' . $search_value . '%')->orWhere('description', 'LIKE', '%' . $search_value . '%')->orderBy('created_at', 'desc')->get();
        } else {
            $roles = Role::all();
        }
        $user = Auth::user();

        $data = array(
            'role_post_route' => URL::to('admin/role/store'),
            'roles' => $roles,
            'user' => $user,
            'admin_user' => Auth::user()
        );

        return View::make('admin.roles.index', $data);
    }

    public function permission()
    {
        $search_value = Input::get('s');
        if (!empty($search_value)) {
            $perms = Permission::where('name', 'LIKE', '%' . $search_value . '%')->orWhere('description', 'LIKE', '%' . $search_value . '%')->orderBy('created_at', 'desc')->get();
        } else {
            $perms = Permission::orderBy('category')->get();
        }
        $user = Auth::user();

        $data = array(
            'perm_post_route' => URL::to('admin/permission/store'),
            'permissions' => $perms,
            'user' => $user,
            'category' => null,
            'admin_user' => Auth::user()
        );

        return View::make('admin.roles.permission.index', $data);
    }

    public function storeRole()
    {
        $validator = Validator::make($data = Input::all(), Role::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $role = Role::create($data);

        return Redirect::to('admin/roles')->with(array('note' => 'New Role Successfully Added!', 'note_type' => 'success'));
    }

    public function storePermission()
    {
        $validator = Validator::make($data = Input::all(), Permission::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $permission = Permission::create($data);

        return Redirect::to('admin/permissions')->with(array('note' => 'New Permission Successfully Added!', 'note_type' => 'success'));
    }

    public function permission_role()
    {

        $perms = Permission::orderBy('category')->get();
        $roles = Role::all();
        $permission_role = DB::table('permission_role')
                ->select(DB::raw('CONCAT(role_id,"-",permission_id) AS detail'))
                ->lists('detail');
        $user = Auth::user();

        $data = array(
            'perm_post_route' => URL::to('admin/permission/role/store'),
            'permissions' => $perms,
            'permission_role' => $permission_role,
            'roles' => $roles,
            'user' => $user,
            'category' => null,
            'admin_user' => Auth::user()
        );

        return View::make('admin.roles.permission.permission_role', $data);
    }

    public function savePermission()
    {

        $input = Input::all();
        $permissions = array_get($input, 'permission');

//        if (!Entrust::hasRole('admin'))
//            return redirect('/admin/permission/role')->with(array('note' => config('constants.NA'), 'note_type' => 'error'));

        DB::table('permission_role')->truncate();

        if ($permissions != '') {
            foreach ($permissions as $r_key => $permission) {
                foreach ($permission as $p_key => $per) {
                    $values[] = $p_key;
                }
                $role = Role::find($r_key);
                if (count($values))
                    $role->attachPermissions($values);
                unset($values);
            }
        }


        return redirect('/admin/permission/role')->withSuccess(config('constants.UPDATED'));
    }

    public function editRole($id)
    {
        return View::make('admin.roles.edit', array('role' => Role::find($id)));
    }

    public function editPermission($id)
    {
        return View::make('admin.roles.permission.edit', array('permission' => Permission::find($id)));
    }

    public function destroyRole($id)
    {
        // we can't just delete a role, get users with the role, get the permission with the role, delete them
        //Role::destroy($id);
        return Redirect::to('admin/roles')->with(array('note' => 'Cannot delete a Role until you delete all corresponding Users and permission', 'note_type' => 'error'));
    }

    public function destroyPermission($id)
    {
        // we can't just delete a role, get users with the role, get the permission with the role, delete them
        //Role::destroy($id);
        return Redirect::to('admin/permissions')->with(array('note' => 'Cannot delete Permission until you delete all corresponding Roles', 'note_type' => 'error'));
    }

    public function updateRole()
    {
        $input = Input::all();
        $role = Role::find($input['id'])->update($input);
        if (isset($role)) {
            return Redirect::to('admin/roles')->with(array('note' => 'Successfully Updated Role', 'note_type' => 'success'));
        }
    }

    public function updatePermission()
    {
        $input = Input::all();
        $permission = Permission::find($input['id'])->update($input);
        if (isset($permission)) {
            return Redirect::to('admin/permissions')->with(array('note' => 'Successfully Updated Permission', 'note_type' => 'success'));
        }
    }

}
