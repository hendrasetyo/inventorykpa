<?php

namespace App\Http\Controllers\Canvassing;

use App\Http\Controllers\Controller;
use App\Models\CanvassingPengembalian;
use App\Models\CanvassingPesanan;
use App\Models\CanvassingPesananDetail;
use App\Models\Customer;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\Sales;
use App\Models\TempCanvas;
use App\Traits\CodeTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CanvassingPesananController extends Controller
{
    use CodeTrait;
    public function index()
    {
        $title = "Canvassing";
        $konversi = CanvassingPesanan::with(['customer'])->orderByDesc('id');

        if (request()->ajax()) {
            return Datatables::of($konversi)
                ->addIndexColumn()
                ->addColumn('tanggal', function (CanvassingPesanan $pb) {
                    return $pb->tanggal;
                })
                ->addColumn('kode', function (CanvassingPesanan $pb) {
                    return $pb->kode;
                })
                ->addColumn('customer', function (CanvassingPesanan $pb) {
                    return $pb->customer->nama;
                })                
                ->addColumn('action', function ($row) {                    
                    $showUrl = route('canvassing.show', ['canvassing' => $row->id]);                    
                    $id = $row->id;
                    $status = $row->status_pb_id;
                    return view('canvassing.canvassing.modal._form-action', compact('showUrl','id'));
                })
                ->make(true);
        }
    
        return view('Canvassing.canvassing.index',compact('title'));
    }

    public function create()
    {
        $title = "Canvassing";        
        $customers = Customer::get();                
        $tglNow = Carbon::now()->format('d-m-Y');
        $canvassing = new CanvassingPesanan();

        //delete temp
        $deletedTempCanvas = TempCanvas::where('created_at', '<', Carbon::today())->delete();
        $deletedTempCanvas = TempCanvas::where('user_id', '=', Auth::user()->id)->delete();               
    
        return view('Canvassing.canvassing.create', compact('title', 'tglNow','canvassing','customers'));
    }

    public function caribarang()
    {
        $products = Product::with(['categories', 'subcategories']);
        $produk = "";

        if (request()->ajax()) {
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    return view('canvassing.canvassing.partial._pilihBarang', compact('id'));
                })
                ->make(true);
        }
        
        return view('canvassing.canvassing.modal._caribarang', compact('produk'));
    }

    public function setbarang(Request $request)
    {
        $product = Product::where('id', '=', $request->id)->get()->first();                
        $mode = "new";
        return view('canvassing.canvassing.modal._setbarang', compact('product', 'mode'));
    }

    public function inputTempCanvas(Request $request)
    {                
        if ($request->stok < $request->qty) {
            $request->session()->flash('status', 'Qty tidak boleh melebihi stok!');            
        }else{
            
            $temp = TempCanvas::create([
                'product_id' => $request->product_id,
                'qty' => $request->qty,
                'qty_sisa' => $request->qty,
                'keterangan' => $request->keterangan,
                'user_id' => auth()->user()->id
            ]);
        }                               
    }

    public function loadTempCanvas(Request $request)
    {
        $tempcanvas = TempCanvas::with(['product'])
                ->where('user_id', '=', Auth::user()->id)
                ->get();            

        return view('canvassing.canvassing.partial._temptabelcanvas', compact('tempcanvas'));
    }

    public function editbarang(Request $request)
    {
        $item = TempCanvas::where('id', $request->id)->first();                  
        $id_product = $item->product_id;         

        
        $product = Product::where('id', '=', $id_product)->first();         
        $product_name = $product->nama;
        $mode = "edit";

        return view('canvassing.canvassing.modal._setbarang', compact('product_name', 'mode', 'item', 'product'));
    }


    public function updateBarang(Request $request)
    {

        TempCanvas::where('id',$request->id)->update([
            'qty' =>  $request->qty,
            'qty_sisa' => $request->qty,
            'keterangan' => $request->keterangan
        ]);

          
    }

    public function destroy_detail(Request $request)
     {
         $id = $request->id;
         TempCanvas::destroy($id);

         return response()->json($id);
     }  
     
     public function store(Request $request)
     { 
        $temp = TempCanvas::where('user_id',auth()->user()->id)->get();
        $totalqty = TempCanvas::where('user_id',auth()->user()->id)->sum('qty_sisa');
        $kode = $this->getKodeTransaksi('canvassing_pesanans','CV');
        $customer = Customer::where('id',$request->customer_id)->first();

        DB::beginTransaction();
        try {            
            // save dicanvassing 
            $canvassing = CanvassingPesanan::create([
                'kode' => $kode,
                'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
                'customer_id' => $request->customer_id,
                'qty' => $totalqty
                
            ]);
            

            foreach ($temp as $item) {
                // kurangi stock produk sesuai di canvassing               
                // tambah stock_canvas produk 

                $product = Product::where('id',$item->product_id)->first();
                $stok = $product->stok - $item->qty;
                $product->stok = $stok;
                $stokcanvassing = $product->stok_canvassing + $item->qty;
                $product->stok_canvassing = $stokcanvassing;
                $product->save();

                // save di canvassing_detail          
                $canvasdet = CanvassingPesananDetail::create([
                    'canvassing_pesanan_id' => $canvassing->id,
                    'product_id' => $item->product_id,
                    'tanggal' => Carbon::parse($canvassing->tanggal)->format('Y-m-d'),
                    'qty' => $item->qty,
                    'qty_sisa' => $item->qty,
                    'keterangan' => $item->keterangan
                ]);    

                // masukan data di inventory [ minus ]             
                $inv = InventoryTransaction ::create([
                    'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
                    'product_id' => $item->product_id,
                    'qty' => $item->qty * -1,
                    'stok' =>  $stok,
                    'hpp' => $product->hpp,
                    'jenis' => 'CV',
                    'jenis_id' => $kode,
                    'customer' => $customer->nama
                ]);                        
            }

            $temp->each->delete();

            DB::commit();

            return redirect()->route('canvassing.index')->with('sukses', 'Canvassing Berhasil ditambahkan !');
        } catch (Exception $th) {

            return redirect()->route('canvassing.index')->with('gagal', $th->getMessage());
        }               
     }

    

     public function delete(Request $request)
     {        

        $data = CanvassingPesanan::where('id',$request->id)->first();
        $id = $data->id;        
        $can_delete = 'YES';
        return view('canvassing.canvassing.modal._confirmDelete', compact('id', 'can_delete'));
     }

     public function destroy(Request $request)
     {

        // dapatkan data canvassing dan canvassing detail 
        $canvassing = CanvassingPesanan::where('id',$request->id)->first();
        $customer = Customer::where('id',$canvassing->customer_id)->first();
        $canvasdet = CanvassingPesananDetail::where('canvassing_pesanan_id',$request->id)->get();

        $cekPengembalian = CanvassingPengembalian::where('canvassing_pesanan_id')->get();

        if ($cekPengembalian) {
            return back()->with('gagal','Data tidak bisa dihapus karena sudah terpakai dipengembalian');
        }


        DB::beginTransaction();        
        try {            
             // tambah kembali stok produk sesuai dengan det canvassing            
            foreach ($canvasdet as $item ) {

                $product = Product::where('id',$item->product_id)->first();
                $stok = $product->stok + $item->qty;
                $product->stok = $stok;
                $stokcanvassing = $product->stok_canvassing - $item->qty;
                $product->stok_canvassing = $stokcanvassing;
                $product->save();                    

                // masukan data di inventory [ minus ]             
                $inv = InventoryTransaction ::create([
                        'tanggal' => Carbon::parse($canvassing->tanggal)->format('Y-m-d'),
                        'product_id' => $item->product_id,
                        'qty' => $item->qty * 1,
                        'stok' =>  $stok,
                        'hpp' => $product->hpp,
                        'jenis' => 'CV (DEL)',
                        'jenis_id' => $canvassing->kode,
                        'customer' => $customer->nama
                    ]);                  

            }
            
            // 4. hapus canvassing dan canvassing detail 
            $canvasdet->each->delete();
            $canvassing->delete();

            DB::commit();
            return redirect()->route('canvassing.index')->with('sukses', 'Canvassing Berhasil dihapus !');
        } catch (Exception $th) {
            return redirect()->route('canvassing.index')->with('gagal', $th->getMessage());
        }                  
     
     }


     public function show($id)
     {
        $title =  "Canvassing ";
        $canvas = CanvassingPesanan::with(['creator','updater','customer'])->where('id',$id)->first();
        $canvasdet = CanvassingPesananDetail::with(['product','creator','updater'])->where('canvassing_pesanan_id',$id)->get();                

        return view('canvassing.canvassing.show',compact('canvas','canvasdet','title'));
     }


     



}
