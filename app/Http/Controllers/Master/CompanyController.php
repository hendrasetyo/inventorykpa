<?php

namespace App\Http\Controllers\Master;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:company-list');
        $this->middleware('permission:company-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:company-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:company-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = "COMPANY";
        $company = new Company;
        $company = Company::where('id', '1')->first();
        //dd($company);
        return view('master.company.index', compact('title', 'company'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'max:255'],
            'alamat' => ['required', 'max:255'],
            'logo' => 'mimes:png|max:2048',
        ]);

        $datas = $request->except(['_token', '_method', 'profile_logo_remove']);
        Company::where('id', '1')->update($datas);

        $logo = request()->file('logo');
        $logo_lama = Company::find('1')->logo;
        if ($logo) {

            Storage::delete(Auth::user()->logo);
            //$imgNameAsli = $request->avatar->getClientOriginalName();
            $imgNameNew = time() . Auth::user()->id . '.' . $request->logo->extension();
            $uploadUrl = $request->file('logo')->storeAs(('images/logo'), $imgNameNew);

            $company = Company::find('1');
            $company->logo = $uploadUrl;
            $company->save();
        } else {
            if ($request['profile_logo_remove'] == 1) {
                Storage::delete($logo_lama);
                $company = Company::find('1');
                $company->logo = '';
                $company->save();
            } else {
                $company = Company::find('1');
                $company->logo = $logo_lama;
                $company->save();
            }
        }
        return redirect()->route('company.index')->with('status', 'Data company berhasil diubah !');
    }
}
