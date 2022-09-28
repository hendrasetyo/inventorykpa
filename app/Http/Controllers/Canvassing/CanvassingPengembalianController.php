<?php

namespace App\Http\Controllers\Canvassing;

use App\Http\Controllers\Controller;
use App\Models\CanvassingPengembalian;
use App\Models\CanvassingPengembalianDetail;
use App\Models\CanvassingPesanan;
use App\Models\CanvassingPesananDetail;
use App\Models\Customer;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\TempCanvasPengembalian;
use App\Traits\CodeTrait;
use Carbon\Carbon;
use Dompdf\Canvas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CanvassingPengembalianController extends Controller
{
    use CodeTrait;

    function __construct()
    {
        $this->middleware('permission:canvassingpengembalian-list');
        $this->middleware('permission:canvassingpengembalian-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:canvassingpengembalian-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:canvassingpengembalian-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = "Canvassing Pengembalian";
        $konversi = CanvassingPengembalian::with(['customer'])->orderByDesc('id');

        if (request()->ajax()) {
            return Datatables::of($konversi)
                ->addIndexColumn()
                ->addColumn('tanggal', function (CanvassingPengembalian $pb) {
                    return $pb->tanggal;
                })
                ->addColumn('kode', function (CanvassingPengembalian $pb) {
                    return $pb->kode;
                })
                ->addColumn('customer', function (CanvassingPengembalian $pb) {
                    return $pb->customer->nama;
                })                
                ->addColumn('action', function ($row) {                    
                    $showUrl = route('canvassingpengembalian.show', ['canvassingpengembalian' => $row->id]);                    
                    $id = $row->id;
                    $status = $row->status_pb_id;
                    return view('canvassing.canvassingpengembalian.modal._form-action', compact('showUrl','id'));
                })
                ->make(true);
        }
            

        return view('canvassing.canvassingpengembalian.index',compact('title','konversi'));
    }

    public function listcanvas()
    {
        $deletedTempCanvas = TempCanvasPengembalian::where('created_at', '<', Carbon::today())->delete();
        $deletedTempCanvas = TempCanvasPengembalian::where('user_id', '=', Auth::user()->id)->delete(); 

        $title = "List Canvassing Pembelian";
        $konversi = CanvassingPesanan::with(['customer'])->where('qty','<>',0)->orderByDesc('id');

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
                    $pilihUrl = route('canvassingpengembalian.create', ['canvassingpengembalian' => $row->id]);
                    $id = $row->id;
                    return view('canvassing.canvassingpengembalian.partial._pilihAction', compact('pilihUrl', 'id'));
                })
                ->make(true);
        }
    
        return view('canvassing.canvassingpengembalian.listcanvas',compact('title'));
    }

    
    public function create($id)
    {
        // hapus temp

           //delete temp
        $deletedTempCanvas = TempCanvasPengembalian::where('created_at', '<', Carbon::today())->delete();
        $deletedTempCanvas = TempCanvasPengembalian::where('user_id', '=', Auth::user()->id)->delete(); 

        $title = 'Canvassing Pengembalian';

        $canvas = CanvassingPesanan::with('customer')->where('id',$id)->first();
        $canvasdet = CanvassingPesananDetail::with('product')->where('canvassing_pesanan_id',$id)->get();            
        $tglNow = Carbon::now()->format('d-m-Y');

        return view('canvassing.canvassingpengembalian.create',compact('canvas','canvasdet','title','tglNow'));
        
    }

    public function setbarang(Request $request)
    {
        $canvas = CanvassingPesananDetail::where('id', '=', $request->id)->get()->first();                
        $product = Product::where('id',$canvas->product_id)->first();

        $mode = "new";

        return view('canvassing.canvassingpengembalian.modal._setbarang', compact('product', 'mode','canvas'));
    }

    public function inputTempCanvas(Request $request)
    {   

            // return response()->json($request->all());

            $canvas = CanvassingPesanan::where('id',$request->canvassing_id)->first();
            
            

            $temp = TempCanvasPengembalian::create([
                'canvassing_pesanan_id' => $request->canvassing_id,
                'product_id' => $request->product_id,
                'tanggal' => Carbon::parse($canvas->tanggal)->format('Y-m-d'),
                'qty' => $request->qty,
                'qty_sisa' => $request->qty - $request->qty_kembali ,
                'qty_kirim' =>  $request->qty_kembali,
                'user_id'=> auth()->user()->id,
                'keterangan' => $request->keterangan
            ]);        
    }

    public function loadTempCanvas(Request $request)
    {
        $tempcanvas = TempCanvasPengembalian::with(['product'])
                ->where('user_id', '=', Auth::user()->id)
                ->get();            

        return view('canvassing.canvassingpengembalian.partial._temptabelcanvas', compact('tempcanvas'));
    }

    public function editbarang(Request $request)
    {

        $canvas = TempCanvasPengembalian::where('id', $request->id)->first();                  
        $id_product = $canvas->product_id;         

        
        $product = Product::where('id', '=', $id_product)->first();         
        $product_name = $product->nama;
        $mode = "edit";

        return view('canvassing.canvassingpengembalian.modal._setbarang', compact('product_name', 'mode', 'canvas', 'product'));
    }


    public function updateBarang(Request $request)
    {

        TempCanvasPengembalian::where('id',$request->id)->update([
            'qty' =>  $request->qty,
            'qty_sisa' => $request->qty - $request->qty_kembali,
            'qty_kirim' => $request->qty_kembali,
            'keterangan' => $request->keterangan
        ]);
         
    }

    public function destroy_detail(Request $request)
     {
         $id = $request->id;
         TempCanvasPengembalian::destroy($id);

         return response()->json($id);
     }  

     public function store(Request $request)
     {
        $canvassing = CanvassingPesanan::where('id',$request->canvassing_id)->first();
        $customer = Customer::where('customer_id',$canvassing->customer_id)->first();

        DB::beginTransaction();

        try {
                 // 0. save di canvassing pengembalian
                 $kode = $this->getKodeTransaksi('canvassing_pengembalians','CVB');
                 $canvaspengembalian = CanvassingPengembalian::create([
                     'kode' => $kode,
                     'canvassing_pesanan_id' => $canvassing->id,
                     'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
                     'customer_id' => $canvassing->customer_id,
                     'keterangan' => $request->keterangan
                 ]);
 
                 $temp = TempCanvasPengembalian::where('user_id',auth()->user()->id)->get();
 
                 foreach ($temp as $item) {
                     
                     // 1. tambah stock produk sesuai di canvassing
                     $product = Product::where('id',$item->product_id)->first();
                     $stok = $product->stok + $item->qty_kirim;
                     $product->stok = $stok;
                     $stokcanvas = $product->stok_canvassing - $item->qty_kirim;
                     $product->stok_canvassing = $stokcanvas;
                     $product->save();
                                                     
                     // save di canvassing pengembalian detail
                     $canvasPengembalian = CanvassingPengembalianDetail::create([
                         'canvassing_kembali_id' => $canvassing->id,
                         'product_id' => $item->product_id,
                         'tanggal' => Carbon::parse($item->tanggal)->format('Y-m-d'),
                         'qty' => $item->qty,
                         'qty_sisa' => $item->qty_sisa,
                         'qty_kirim' => $item->qty_kirim,     
                     ]);
 
                     // 3. masukan data di inventory [ tambah ]
                                 
                     $inv = InventoryTransaction ::create([
                         'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
                         'product_id' => $item->product_id,
                         'qty' => $item->qty_kirim,
                         'stok' =>  $stok,
                         'hpp' => $product->hpp,
                         'jenis' => 'CVB',
                         'jenis_id' => $kode,
                         'customer' => $customer->nama
                     ]);        
 
                     // kurangi qty_sisa pada canvassing_pesanan
                     $canvasdet = CanvassingPesananDetail::where('canvassing_pesanan_id',$item->canvassing_pesanan_id)
                                 ->where('product_id',$item->product_id)->first();
                     $sisa = $canvasdet->qty_sisa - $item->qty_kirim;
                     $canvasdet->qty_sisa = $sisa;
                     $canvasdet->save();
 
                 }        
                 
                 // total qty pada canvassing pesanan dengan menjumlahkan qty sisa
                 $qtycanvas = CanvassingPesananDetail::where('canvassing_pesanan_id',$item->canvassing_pesanan_id)
                             ->where('product_id',$item->product_id)->sum('qty_sisa');
                 $canvassing->qty = $qtycanvas;
                 $canvassing->save();

                DB::commit();
                return redirect()->route('canvassingpengembalian.index')->with('suskes','Data Canvassing Pengembalian berhasil ditambahkan');

           
            
        } catch (Exception $th) {

            DB::rollBack();
            return redirect()->route('canvassingpengembalian.index')->with('gagal', $th->getMessage());
        }                    
        
     }

     public function delete(Request $request)
     {        

        $data = CanvassingPengembalian::where('id',$request->id)->first();
        $id = $data->id;        
        $can_delete = 'YES';
        return view('canvassing.canvassingpengembalian.modal._confirmDelete', compact('id', 'can_delete'));
     }


     public function destroy(Request $request)
     {
        $canvaspengembalian = CanvassingPengembalian::where('id',$request->id)->first();
        $canvaspengembaliandetail = CanvassingPengembalianDetail::where('canvassing_kembali_id',$request->id)->get();

        $canvas = CanvassingPesanan::where('id',$canvaspengembalian->canvassing_pesanan_id)->first();        
        $customer = Customer::where('id',$canvas->custome_id)->first();

      
        foreach ($canvaspengembaliandetail as $item ) {
              // 1. kurangi stok product dan tambah pada stok canvas sesuai dengan canvaspemb detail    
              $product = Product::where('id',$item->product_id)->first();
              $stok = $product->stok - $item->qty_kirim;
              $stok_canvassing = $product->stok_canvassing + $item->qty_kirim;
              $product->stok = $stok;
              $product->stok_canvassing = $stok_canvassing;
              $product->save();         

              // 2. tambah stok canvas pesanan detail dan tidak
              $canvasdet = CanvassingPesananDetail::where('canvassing_pesanan_id',$canvas->id)
                                                    ->where('product_id',$item->product_id)
                                                    ->first();

              $stoksisa =   $canvasdet->qty_sisa + $item->qty_kirim;
              $canvasdet->qty_sisa = $stoksisa;
              $canvasdet->save();

              // 3. insert inv transaction                                                        
                $inv = InventoryTransaction ::create([
                    'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
                    'product_id' => $item->product_id,
                    'qty' => $item->qty_sisa * -1,
                    'stok' =>  $stok,
                    'hpp' => $product->hpp,
                    'jenis' => 'CVB (DEL)',
                    'jenis_id' => $canvaspengembalian->kode,
                    'customer' => $customer->nama
                ]);                
            
        }
        
        $qty = CanvassingPesananDetail::where('canvassing_pesanan_id',$canvas->id)->sum('qty_sisa');
        $canvas->qty = $qty;
        $canvas->save();

        $canvaspengembaliandetail->each->delete();
        $canvaspengembalian->delete();

        return redirect()->route('canvassingpengembalian.index')->with('sukses','Data Canvassing Pengembalian berhasil dihapus');
       
     }

     public function show($id)
     {
        $title =  "Canvassing Pengembalian";
        $canvas = CanvassingPengembalian::with(['creator','updater','customer'])->where('id',$id)->first();
        $canvasdet = CanvassingPengembalianDetail::with(['product','creator','updater'])->where('canvassing_kembali_id',$id)->get();                

        return view('canvassing.canvassingpengembalian.show',compact('canvas','canvasdet','title'));
     }


    




}
