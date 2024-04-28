<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

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
    
     public function update(ProfileUpdateRequest $request)
     {
         $user = $request->user();
 
         // Kullanıcı bilgilerini güncelle
         $user->fill($request->validated());
 
         // Eğer e-posta güncellenmişse ve yeni e-posta farklı ise
         if ($request->filled('email') && $user->email != $request->email) {
             $user->email_verified_at = null; // E-posta doğrulama işlemi devre dışı bırakılır
         }
 
         // Eğer şifre güncellenmişse
         if ($request->filled('password')) {
             $request->validate([
                 'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
             ]);
 
             $user->password = Hash::make($request->password);
         }
 
         // Kullanıcıyı kaydet
         $user->save();
 
         // Profil düzenleme sayfasına yönlendir ve başarı mesajı göster
         return back()->withSuccess('Profile updated successfully');
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
