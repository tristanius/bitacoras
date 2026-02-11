<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {   
        $user = $request->user(); 
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'doc_number' => 'required|unique:users,doc_number,' . $user->id,
            'doc_type' => 'required|string|max:25',
            'license_number' => 'required|unique:users,license_number,' . $user->id,
            'medical_certificate_expiry' => 'required|date',
            'phone' => 'nullable|string',
            #'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Borrar foto anterior si existe (opcional)
            if($user->profile_photo != null) {
                Storage::delete($user->profile_photo);
            }         
            $path = $request->file('photo')->store('profiles', 'public');
            $user->profile_photo = $path;
        }
        $user->fill([
            'name'  => $validated['name'],
            'doc_number'  => $validated['doc_number'],
            'doc_type'  => $validated['doc_type'],
            'license_number'  => $validated['license_number'],
            'medical_certificate_expiry'  => $validated['medical_certificate_expiry'],
            'phone'  => $validated['phone'],
            #'email' => $validated['email'],
        ]);
        $user->save();
        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function show()
    {
        $user = auth()->user();
        // Calculamos sus horas totales para mostrar en el perfil
        $totalHours = \App\Models\LogEntry::where('pilot_id', $user->id)->where('is_active', true)->sum('total_time');
        
        return view('user-profile', compact('user', 'totalHours'));
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Contraseña actualizada con éxito.');
    }
}
