<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Lista todos os papéis.
     */
    public function index(): View
    {
        $roles = Role::where('guard_name', 'web')
            ->withCount('users')
            ->orderBy('name')
            ->get();

        return view('user::roles.index', compact('roles'));
    }

    /**
     * Exibe o formulário de edição de permissões do papel.
     */
    public function edit(int $id): View
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::where('guard_name', 'web')->orderBy('name')->get();

        return view('user::roles.edit', compact('role', 'permissions'));
    }

    /**
     * Atualiza as permissões do papel.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $role = Role::findOrFail($id);

        $permissions = $request->input('permissions', []);
        $permissions = is_array($permissions) ? $permissions : [];

        $role->syncPermissions($permissions);

        return redirect()->route('role.index')->with('success', 'Permissões atualizadas com sucesso.');
    }
}
