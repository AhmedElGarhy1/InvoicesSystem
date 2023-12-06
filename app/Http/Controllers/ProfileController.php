<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;

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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $image = $request->image;
        $user = User::find(Auth::User()->id);
        if(isset($image)){
            $lastimage = Auth::User()->image;
            File::delete("image/$lastimage");
            $imaName = time().'.'.$image->extension();
            $imageName = "image/$imaName";
            $image->move(public_path('image'), $imageName);
        }else{
            if(isset(Auth::User()->image)){
                $imageName = Auth::User()->image;
            }else{
                $imageName = 'image/defultimage.png';
            }
        }

        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'image'=>$imageName
        ]);
        return Redirect::route('dashboard')->with('status', 'profile-updated');
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
