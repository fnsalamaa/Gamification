<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $users = User::with('roles')
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })
        ->orderBy('name')
        ->paginate(10); // tampilkan 10 data per halaman

    return view('admin.users.show-users', compact('users'));
}


    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'profile_photo' => 'nullable|image|max:2048',
        'password' => 'required|confirmed|min:6',
        'role' => 'required|in:admin,teacher,user',
        'class' => 'nullable|string|max:255',
    ]);

    // Simpan foto profil jika ada
    if ($request->hasFile('profile_photo')) {
        $validated['profile_photo_path'] = $request->file('profile_photo')->store('profile-photos', 'public');
    }

    // Simpan user
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'class' => $validated['class'] ?? null, // jika student
        'profile_photo_path' => $validated['profile_photo_path'] ?? null,
    ]);

    // Assign role
    $user->assignRole($validated['role']);

    return redirect()->back()->with('success', 'User created successfully!');
}


public function edit($id)
{
    $user = User::findOrFail($id);
    return view('admin.users.edit-user', compact('user'));
}

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'profile_photo' => 'nullable|image|max:2048',
        'role' => 'required|in:admin,teacher,user',
        'class' => 'nullable|string|max:255',
    ]);

    if ($request->hasFile('profile_photo')) {
        $validated['profile_photo_path'] = $request->file('profile_photo')->store('profile-photos', 'public');
    }

    $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'class' => $validated['class'] ?? null,
        'profile_photo_path' => $validated['profile_photo_path'] ?? $user->profile_photo_path,
    ]);

    // Sync role
    $user->syncRoles([$validated['role']]);

    return redirect()->route('admin.users.show-users')->with('success', 'User updated successfully!');

}


public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->back()->with('success', 'User deleted successfully!');
}




}
