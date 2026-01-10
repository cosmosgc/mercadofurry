<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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
        // Handle avatar upload using move()
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            // Create output directory inside public/
            $outputDirPath = 'uploads/avatar';
            $outputDir = public_path($outputDirPath);

            if (!file_exists($outputDir)) {
                mkdir($outputDir, 0777, true);
            }

            // Generate a filename
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Move file to /public/avatars/
            $file->move($outputDir, $filename);

            // Delete old avatar if present
            if ($request->user()->avatar && file_exists(public_path($request->user()->avatar))) {
                unlink(public_path($request->user()->avatar));
            }
            
            // Save filename to DB
            $request->user()->avatar = $outputDirPath.'/'.$filename;
        }

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
}
