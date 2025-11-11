<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\AuditLogService;
use Illuminate\Validation\Rule;
use DB;

class RoleController extends Controller
{
    protected $auditLog;

    public function __construct(AuditLogService $auditLog)
    {
        $this->auditLog = $auditLog;
    }

    public function index(Request $request)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        DB::beginTransaction();

        try {
            $role = Role::create([
                'name' => strtolower($validated['name']),
            ]);

            if (!empty($validated['permissions'])) {
                $role->permissions()->sync($validated['permissions']);
            }

            DB::commit();

            $this->auditLog->log(
                'create_role',
                $role,
                [
                    'new' => $role->toArray(),
                ],
                'Created a new role: ' . $role->name
            );

            

            return redirect()
                ->route('admin.roles.index')
                ->with('success', 'Role created successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Failed to create role. ' . $e->getMessage());
        }
    }

    public function update(Request $request, $roleId)
    {
        // Prevent modification of the super admin role
        if ($roleId == 1) {
            return redirect()
                ->route('admin.roles.index')
                ->with('error', 'You cannot modify the Super Admin role.');
        }

        $role = Role::find($roleId);

        if (! $role) {
            return redirect()
                ->route('admin.roles.index')
                ->with('error', 'Role not found.');
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|unique:roles,name,' . $roleId,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        DB::beginTransaction();

        try {
            if (isset($validated['name'])) {
                $role->update([
                    'name' => strtolower($validated['name']),
                ]);
            }

            if (isset($validated['permissions'])) {
                $role->permissions()->sync($validated['permissions']);
            }

            $oldData = $role->toArray();

            DB::commit();

            $this->auditLog->log(
                'update_role',
                $role,
                [
                    'old' => $oldData,
                    'new' => $role->fresh()->toArray(),
                ],
                'Updated role: ' . $role->name
            );


            return redirect()
                ->route('admin.roles.index')
                ->with('success', 'Role updated successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Failed to update role. ' . $e->getMessage());
        }
    }




    public function adminList(Request $request)
    {
        $search = $request->input('search');
        $roles = Role::all();

        $admins = Admin::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                // Basic text fields
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.admin', compact('admins', 'roles'));
    }

    public function storeAdmin(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:255', 'unique:admins,email'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'gender'     => ['nullable', Rule::in(['male', 'female', 'other'])],
            'password'   => ['required', 'string', 'min:8'],
            'bio'        => ['nullable', 'string', 'max:500'],
            'location'   => ['nullable', 'string', 'max:255'],
            'birthday'   => ['nullable', 'date'],
            'role_id'    => ['required', 'exists:roles,id'],
        ]);

        // Create admin
        $admin = Admin::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'] ?? null,
            'gender'     => $validated['gender'] ?? null,
            'password'   => Hash::make($validated['password']),
            'bio'        => $validated['bio'] ?? null,
            'location'   => $validated['location'] ?? null,
            'birthday'   => $validated['birthday'] ?? null,
            'role_id'    => $validated['role_id'],
        ]);

        $this->auditLog->log(
            'create_admin',
            $admin,
            [
                'new' => $admin->toArray(),
            ],
            'Created new admin: ' . $admin->email
        );

        // Return success feedback
        return redirect()
            ->route('admin.list.index')
            ->with('success', "Admin {$admin->first_name} {$admin->last_name} created successfully.");
    }

    public function showAdmin($id)
    {
        $admin = Admin::find($id);
        return view('admin.profile-admin', compact('admin'));
    }
}
