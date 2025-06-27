<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereDoesntHave('roles', function($query) {
            $query->where('name', 'super-admin');
        })->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::whereNot('name','super-admin')->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|exists:roles,name',
            'profile_image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'tenant_id' => auth()->user()->tenant_id,
        ]);

        // Assign role
        $user->assignRole($validated['role']);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $path = Storage::disk('website')->put('profile_images', $request->profile_image);
            $user->update(['profile_image' => $path]);
        }

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::whereNot('name','super-admin')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|exists:roles,name',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->update($validated);

        // Sync roles
        $user->syncRoles([$validated['role']]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $path = Storage::disk('website')->put('profile_images', $request->profile_image);
            $user->update(['profile_image' => $path]);
        }

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
