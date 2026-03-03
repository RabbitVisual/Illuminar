<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Core\Helpers\UtilsHelper;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Lista todos os usuários.
     */
    public function index(): View
    {
        $users = User::with('roles')->orderBy('first_name')->paginate(15);

        return view('user::users.index', compact('users'));
    }

    /**
     * Exibe o formulário de criação.
     */
    public function create(): View
    {
        $roles = Role::where('guard_name', 'web')->orderBy('name')->get();

        return view('user::users.create', compact('roles'));
    }

    /**
     * Armazena um novo usuário.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'cpf' => ['nullable', 'string', 'max:14'],
            'phone' => ['nullable', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'cpf' => UtilsHelper::onlyDigits($validated['cpf'] ?? '') ?: null,
            'document' => UtilsHelper::onlyDigits($validated['cpf'] ?? '') ?: null,
            'document_type' => 'cpf',
            'phone' => UtilsHelper::onlyDigits($validated['phone'] ?? '') ?: null,
            'status' => 'active',
        ]);

        $role = Role::findById($validated['role_id'], 'web');
        $user->syncRoles([$role]);

        return redirect()->route('user.index')->with('success', 'Usuário criado com sucesso.');
    }

    /**
     * Exibe o formulário de edição.
     */
    public function edit(int $id): View
    {
        $user = User::findOrFail($id);
        $roles = Role::where('guard_name', 'web')->orderBy('name')->get();

        return view('user::users.edit', compact('user', 'roles'));
    }

    /**
     * Atualiza o usuário.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'cpf' => ['nullable', 'string', 'max:14'],
            'phone' => ['nullable', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $data = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'cpf' => UtilsHelper::onlyDigits($validated['cpf'] ?? '') ?: null,
            'document' => UtilsHelper::onlyDigits($validated['cpf'] ?? '') ?: null,
            'phone' => UtilsHelper::onlyDigits($validated['phone'] ?? '') ?: null,
        ];

        if (! empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $user->update($data);

        $role = Role::findById($validated['role_id'], 'web');
        $user->syncRoles([$role]);

        return redirect()->route('user.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    /**
     * Remove o usuário (soft delete).
     */
    public function destroy(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Usuário excluído com sucesso.');
    }
}
