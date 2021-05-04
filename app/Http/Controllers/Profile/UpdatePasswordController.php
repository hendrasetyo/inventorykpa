<?php

namespace App\Http\Controllers\Profile;

use App\Actions\Fortify\UpdateUserPassword;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdatePasswordController extends UpdateUserPassword
{
    //
    public function edit()
    {
        return view('profile.update-password');
    }

    public function updatePassword()
    {
        $this->update(request()->user(), request()->all());
        return back()->with('status', 'Your Password has been updated !');
    }
}
