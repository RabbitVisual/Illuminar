---
name: User Module 100%
overview: "Implementar o Módulo User completo do Illuminar: autenticação (login/logout), migrations e seeders Spatie, CRUD de usuários com máscaras, e interface de roles/permissões."
todos: []
isProject: false
---

# Plano: Módulo User - 100% Conclusão

## Contexto

O Módulo User gerencia usuários e permissões via Spatie. O Model [App\Models\User](app/Models/User.php) já possui `HasRoles`, `SoftDeletes`, e campos como `document`, `phone` no fillable. A tabela `users` em [0001_01_01_000000_create_users_table.php](database/migrations/0001_01_01_000000_create_users_table.php) já tem `phone` e `document` (CPF/CNPJ). Será criada uma migration para adicionar `cpf` (coluna dedicada para formulários) caso não exista; `phone` já existe.

---

## 1. Autenticação (Login e Logout)

### AuthController

- **Arquivo:** `Modules/User/app/Http/Controllers/AuthController.php`
- **Métodos:**
  - `showLoginForm()`: retorna `view('user::auth.login')`
  - `login(Request $request)`: valida email/password, usa `Auth::attempt()`, redireciona para `/core` ou rota `user.index` em sucesso; em falha, `back()->withErrors()`
  - `logout(Request $request)`: `Auth::logout()`, invalida sessão, regenera token, redireciona para `route('login')`

### View login.blade.php

- **Arquivo:** `Modules/User/resources/views/auth/login.blade.php`
- Extende `<x-core::layouts.auth title="Login Illuminar">`
- Formulário: email (type="email"), password (type="password"), checkbox "Lembrar-me", botão "Entrar"
- Formulário sem `data-no-loading` para disparar loading-overlay automaticamente no submit
- CSRF, validação de erros (`@error`), classes Tailwind e dark mode

### Rotas

- **Arquivo:** [Modules/User/routes/web.php](Modules/User/routes/web.php)
- Adicionar antes do grupo auth:
  - `GET /login` -> `AuthController@showLoginForm` (name: login) — substituir rota do app principal
  - `POST /login` -> `AuthController@login` (name: login.store ou manter login via POST)
  - `POST /logout` -> `AuthController@logout` (name: logout)
- **Ajuste no app:** Remover ou sobrescrever as rotas de login/register em [routes/web.php](routes/web.php) para que o módulo User controle `/login`.

---

## 2. Base de Dados e Permissões (Spatie)

### Migration add_cpf_to_users

- **Arquivo:** `Modules/User/database/migrations/YYYY_MM_DD_HHMMSS_add_cpf_to_users_table.php`
- Adicionar coluna `cpf` (string, 14, nullable) na tabela `users` se não existir. O campo `phone` já existe na migration original.

### RolesAndPermissionsSeeder

- **Arquivo:** `Modules/User/database/seeders/RolesAndPermissionsSeeder.php`
- `app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions()`
- Criar roles: `SuperAdmin`, `Owner`, `Manager`, `Cashier`, `Customer`
- Criar usuário: email `admin@illuminar.com.br`, password `password`, `first_name` Admin, `last_name` Illuminar
- Atribuir role `SuperAdmin` ao usuário criado

### User Model

- **Arquivo:** [app/Models/User.php](app/Models/User.php)
- Já possui `HasRoles` e `phone` no fillable. Adicionar `cpf` ao `$fillable` (e `document` se ainda não estiver para compatibilidade com formulários de CPF).

---

## 3. CRUD de Usuários

### UserController

- **Arquivo:** [Modules/User/app/Http/Controllers/UserController.php](Modules/User/app/Http/Controllers/UserController.php)
- **index:** `User::with('roles')->paginate(15)`, view `user::users.index`
- **create:** listar roles para select, view `user::users.create`
- **store:** validar (first_name, last_name, email, password, cpf, phone, role_id), usar `UtilsHelper::onlyDigits()` para cpf e phone, criar usuário, `$user->syncRoles([$role])`, redirect com mensagem
- **edit:** `User::findOrFail($id)`, roles, view `user::users.edit`
- **update:** validar (sem password obrigatório), limpar cpf/phone com onlyDigits, atualizar, syncRoles, redirect
- **destroy:** soft delete, redirect

### Views

- **users/index.blade.php:** Layout master, tabela Tailwind com Nome, E-mail, Papel (badge colorida por role), ações (editar, excluir) com `<x-icon>`
- **users/create.blade.php:** Formulário com first_name, last_name, email, password, cpf (`x-mask="'cpf'"`), phone (`x-mask="'phone'"`), select de role
- **users/edit.blade.php:** Igual ao create, sem campo password obrigatório, preenchido com dados do usuário

---

## 4. Interface de Permissões (Roles)

### RoleController

- **Arquivo:** `Modules/User/app/Http/Controllers/RoleController.php`
- **index:** `Role::withCount('users')->get()`, view `user::roles.index`
- **edit($id):** `Role::findOrFail($id)`, `Permission::all()`, view `user::roles.edit` (form para sync de permissões)
- **update(Request $request, $id):** `$role->syncPermissions($request->permissions)`, redirect

### View roles/index.blade.php

- Layout master, tabela com Nome da Role, Quantidade de usuários, link para editar permissões

### Rotas adicionais

- `Route::resource('roles', RoleController::class)->except(['create', 'store', 'show', 'destroy'])->names('role');` ou rotas manuais para index, edit, update.

---

## 5. Integração com App Principal

- Em [routes/web.php](routes/web.php) da aplicação: remover ou comentar as rotas de login/register que retornam views estáticas, para que o módulo User registre `/login` e `/logout`.
- O RouteServiceProvider do User carrega suas rotas com middleware `web`; as rotas de login devem ser públicas (fora do grupo `auth`).

---

## 6. Arquivos a Criar/Modificar


| Arquivo                                                         | Ação                                         |
| --------------------------------------------------------------- | -------------------------------------------- |
| `Modules/User/app/Http/Controllers/AuthController.php`          | Criar                                        |
| `Modules/User/resources/views/auth/login.blade.php`             | Criar                                        |
| `Modules/User/routes/web.php`                                   | Modificar (auth + users + roles)             |
| `routes/web.php` (app)                                          | Modificar (remover login/register estáticos) |
| `Modules/User/database/migrations/*_add_cpf_to_users_table.php` | Criar                                        |
| `Modules/User/database/seeders/RolesAndPermissionsSeeder.php`   | Criar                                        |
| `Modules/User/database/seeders/UserDatabaseSeeder.php`          | Modificar (chamar RolesAndPermissionsSeeder) |
| `app/Models/User.php`                                           | Modificar (adicionar cpf ao fillable)        |
| `Modules/User/app/Http/Controllers/UserController.php`          | Reescrever completo                          |
| `Modules/User/resources/views/users/index.blade.php`            | Criar                                        |
| `Modules/User/resources/views/users/create.blade.php`           | Criar                                        |
| `Modules/User/resources/views/users/edit.blade.php`             | Criar                                        |
| `Modules/User/app/Http/Controllers/RoleController.php`          | Criar                                        |
| `Modules/User/resources/views/roles/index.blade.php`            | Criar                                        |
| `Modules/User/resources/views/roles/edit.blade.php`             | Criar (para sync de permissões)              |


---

## 7. Fluxo de Autenticação

```mermaid
flowchart LR
    A[GET /login] --> B[AuthController@showLoginForm]
    B --> C[login.blade.php]
    C --> D[POST /login]
    D --> E[AuthController@login]
    E --> F{Valid?}
    F -->|Yes| G[Redirect /core]
    F -->|No| H[Back with errors]
    I[POST /logout] --> J[AuthController@logout]
    J --> K[Redirect /login]
```



---

## 8. Observações

- O campo `document` na tabela users pode armazenar CPF; o novo campo `cpf` será usado para formulários simplificados. No store/update, salvar o valor limpo em `document` (ou `cpf` se a migration adicionar coluna dedicada) para manter consistência.
- Badges de roles: cores distintas (SuperAdmin=purple, Owner=blue, Manager=green, Cashier=yellow, Customer=gray).
- Garantir que `DatabaseSeeder` ou `UserDatabaseSeeder` chame `RolesAndPermissionsSeeder` para popular roles e admin inicial.

