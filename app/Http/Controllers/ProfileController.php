<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'email'      => "required|email|unique:users,email,{$user->id}",
            'birth_date' => 'nullable|date',
            'address'    => 'nullable|string|max:255',
            'password'   => 'nullable|min:6',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $validated['photo'] =
                $request->file('photo')->store('photos/users', 'public');
        }

        $user->update($validated);

        return back()->with('success', '✅ Profil berhasil diperbarui!');
    }
}
