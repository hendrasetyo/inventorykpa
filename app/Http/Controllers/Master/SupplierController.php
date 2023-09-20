<?php

namespace App\Http\Controllers\Master;

use App\Exports\ExportSupplier;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Supplier_category;
use Illuminate\Support\Facades\DB;
use Laravolt\Indonesia\Models\City;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use App\Traits\CodeTrait;
use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
{
    use CodeTrait;

    function __construct()
    {
        $this->middleware('permission:supplier-list');
        $this->middleware('permission:supplier-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:supplier-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:supplier-delete', ['only' => ['destroy']]);
    }

    public function index()
    {

        $title = "SUPPLIER";
        $suppliers = Supplier::with(['kategori', 'namakota', 'prov']);

        if (request()->ajax()) {
            return Datatables::of($suppliers)
                ->addIndexColumn()
                ->addColumn('kategori', function (Supplier $sups) {
                    return $sups->kategori->nama;
                })

                ->addColumn('kota', function (Supplier $supsk) {
                    return $supsk->namakota->name;
                })
                ->addColumn('provinsi', function (Supplier $subsp) {
                    return $subsp->prov->name;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('supplier.edit', ['supplier' => $row->id]);
                    $id = $row->id;
                    return view('master.supplier._formAction', compact('editUrl', 'id'));
                })
                ->make(true);
        }


        return view('master.supplier.index', compact('title'));
    }

    public function create()
    {
        $title = "Supplier";
        $supplier = new supplier;
        $provinces = Province::pluck('name', 'id');
        $suppliercategory = Supplier_category::get();
        $kecamatan = [];
        $kelurahan = [];
        $kota = [];
        return view('master.supplier.create', compact('title', 'supplier', 'provinces', 'suppliercategory', 'kecamatan', 'kota', 'kelurahan'));
    }

    public function getkota(Request $request)
    {
        $cities = City::where('province_id', $request->get('id'))
            ->pluck('name', 'id');

        return response()->json($cities);
    }

    public function getkecamatan(Request $request)
    {
        $district = District::where('city_id', $request->get('id'))
            ->pluck('name', 'id');

        return response()->json($district);
    }

    public function getkelurahan(Request $request)
    {
        $kelurahan = Village::where('district_id', $request->get('id'))
            ->pluck('name', 'id');

        return response()->json($kelurahan);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => ['required'],
            'nama' => ['required', 'max:255'],
            'alamat' => ['required', 'max:255'],
            'provinsi' => ['required'],
            'kota' => ['required'],
            'kecamatan' => ['required'],
            'kelurahan' => ['required'],
            'npwp' => ['required'],
        ]);
        $datas = $request->all();
        $datas['kode'] = $this->getKodeData("suppliers", "S");

        Supplier::create($datas);
        return redirect()->route('supplier.index')->with('status', 'Supplier baru berhasil ditambahkan !');
    }



    public function edit(supplier $supplier)
    {
        $title = "Supplier";
        $provinces = Province::pluck('name', 'id');
        $suppliercategory = Supplier_category::get();
        $id_provinsi = $supplier->provinsi;
        $id_kota = $supplier->kota;
        $id_kecamatan = $supplier->kecamatan;
        $id_kelurahan = $supplier->kelurahan;

        $kecamatan = District::where('city_id', $id_kota)->get();
        $kelurahan = Village::where('district_id', $id_kecamatan)->get();
        $kota = City::where('province_id', $id_provinsi)->get();
        //dd($kota);
        return view('master.supplier.edit', compact('title', 'supplier', 'provinces', 'suppliercategory', 'kecamatan', 'kota', 'kelurahan'));
    }


    public function update(Request $request, supplier $supplier)
    {
        $request->validate([
            'kategori_id' => ['required'],
            'nama' => ['required', 'max:255'],
            'alamat' => ['required', 'max:255'],
            'provinsi' => ['required'],
            'kota' => ['required'],
            'kecamatan' => ['required'],
            'kelurahan' => ['required'],
            'npwp' => ['required'],
        ]);

        $supplier->update($request->all());
        return redirect()->route('supplier.index')->with('status', 'Data supplier berhasil diubah !');
    }

    public function detail(Request $request)
    {
        $supplier = Supplier::where('id', '=', $request->id)->get()->first();

        return view('master.supplier._showDetail', compact('supplier'));
    }

    public function delete(Request $request)
    {
        $data = Supplier::where('id', '=', $request->id)->get(['nama'])->first();
        $id = $request->id;
        $name = $data->nama;

        return view('master.supplier._confirmDelete', compact('name', 'id'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $supplier = Supplier::find($id);
        $supplier->deleted_by = Auth::user()->id;
        $supplier->save();

        Supplier::destroy($request->id);

        return redirect()->route('supplier.index')->with('status', 'Data Supplier Berhasil Dihapus !');
    }


    public function print()
    {
        return Excel::download(new ExportSupplier(), 'supplier.xlsx');  
    }
}
