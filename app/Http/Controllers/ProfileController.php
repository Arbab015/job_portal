<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {

        $user = Auth::user();
        return view(
            'profile.edit',
            [
                'user' => $user,
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $user = User::findOrFail($id);
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed'
            ]);
            $password  = Hash::make($request->input('password'));
            $user->update([
                'password' =>  $password
            ]);
        }

        if ($request->hasFile('profile_picture')) {
            $old_file_path = 'profile_pictures/' . $user->profile_picture;

            if ($user->profile_picture && Storage::disk('public')->exists($old_file_path)) {
                Storage::disk('public')->delete($old_file_path);
            }

            $image = $request->file('profile_picture');
            $image_name = time() . '_' . $image->getClientOriginalName();

            // Save new image using Storage
            $image->storeAs('profile_pictures', $image_name, 'public');

            $validated_data['profile_picture'] = $image_name;
        }

        $user->update([
            'name' => $validated_data['name'],
            'email' => $validated_data['email'],
            'profile_picture' => $validated_data['profile_picture'] ?? $user->profile_picture,
        ]);

        return redirect()->back()->with('success', 'User updated successfully');
    }
}
