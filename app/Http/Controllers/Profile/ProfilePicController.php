<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilePicController extends Controller
{
    //
    public function edit()
    {
        return view('profile/update-picture');
    }

    public function updateProfilePic(Request $request)
    {
        $request->validate([
            'avatar' => 'mimes:jpeg,png,jpg,gif|max:2048'
        ]);


        $avatar = request()->file('avatar');
        $avatar_lama = Auth::user()->avatar;
        if ($avatar) {

            Storage::delete(Auth::user()->avatar);
            //$imgNameAsli = $request->avatar->getClientOriginalName();
            $imgNameNew = time() . Auth::user()->id . '.' . $request->avatar->extension();
            $uploadUrl = $request->file('avatar')->storeAs(('images/users'), $imgNameNew);

            $user = Auth::user();
            $user->avatar = $uploadUrl;
            $user->save();
        } else {
            if ($request['profile_avatar_remove'] == 1) {
                Storage::delete(Auth::user()->avatar);
                $user = Auth::user();
                $user->avatar = '';
                $user->save();
            } else {
                $user = Auth::user();
                $user->avatar = $avatar_lama;
                $user->save();
            }
        }
        return back()->with('status', 'User Profile Picture has been updated !');
        //dd($upload);
    }
}
