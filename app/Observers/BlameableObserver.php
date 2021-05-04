<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class BlameableObserver
{
    public function creating(Model $model)
    {
        if (Auth::check()) {
            $model->created_by = Auth::user()->id;
            $model->updated_by = Auth::user()->id;
        }
    }

    public function updating(Model $model)
    {
        if (Auth::check()) {
            $model->updated_by = Auth::user()->id;
        }
    }

    public function deleting(Model $model)
    {
        if (Auth::check()) {
            $model->deleted_by = Auth::user()->id;
        }
    }
}
