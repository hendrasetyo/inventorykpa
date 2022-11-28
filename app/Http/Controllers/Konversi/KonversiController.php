<?php

namespace App\Http\Controllers\Konversi;

use App\Http\Controllers\Controller;
use App\Models\InventoryTransaction;
use App\Models\Konversi;
use App\Models\KonversiDetail;
use App\Models\Product;
use App\Models\StokExp;
use App\Models\StokExpDetail;
use App\Models\TempKonversi;
use App\Models\TempKonversiDet;
use App\Traits\CodeTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use function GuzzleHttp\Promise\all;

class KonversiController extends Controller
{
    use CodeTrait;
    public function index()
    {
        $title = "Konversi Produk";
        $konversi = Konversi::with(['product'])->orderByDesc('id');

        if (request()->ajax()) {
            return Datatables::of($konversi)
                ->addIndexColumn()
                ->addColumn('tanggal', function (Konversi $pb) {
                    return $pb->tanggal;
                })
                ->addColumn('kode', function (Konversi $pb) {
                    return $pb->kode;
                })
                ->addColumn('produk', function (Konversi $pb) {
                    return $pb->product->nama;
                })
                ->addColumn('qty', function (Konversi $pb) {
                    return $pb->qty;
                })
                ->addColumn('action', function ($row) {                    
                    $showUrl = route('konversisatuan.show', ['konversisatuan' => $row->id]);                    
                    $id = $row->id;
                    $status = $row->status_pb_id;
                    return view('konversi.modal._form-action', compact('showUrl','id'));
                })
                ->make(true);
        }

        return view('konversi.index', compact('title'));

    }

    public function create()
    {
        $title = "List Produk";

        // hapus temp by buat sekarang dan yang kemarin
        TempKonversiDet::where('created_at', '<', Carbon::today())->delete();
        TempKonversiDet::where('user_id', '=', Auth::user()->id)->delete();
        TempKonversi::where('created_at', '<', Carbon::today())->delete();
        TempKonversi::where('user_id', '=', Auth::user()->id)->delete();
           
        $products = Product::with(['categories', 'subcategories'])->where('status','Aktif');

        $data = $products->get();
        $produk = "";
        
        if (request()->ajax()) {
            return DataTables::of($products)
                ->addIndexColumn()                                
                ->addColumn('action', function (Product $row) {
                    $id = $row->id;
                    return view('konversi.modal._pilihbarang', compact('id'));
                })
                ->make(true);
        }

        return view('konversi.listproduk',compact('title','data'));

    }

    public function pilihExp($id)
    {
        // ambil data expdate dari masing masing produk
        $stokexp = StokExp::with('stokExpDetail')->where('product_id',$id)->where('qty', '<>', 0)->get();        
        $products = Product::where('id',$id)->first();
        // kirim data tersebut ke halaman exp date

        $title = "Stock Exp Produk";
        return view('konversi.setexp',[
            'exp' => $stokexp,
            'title' => $title,
            'products' => $products
        ]);

    }

    public function setQty(Request $request)
    {
            $data = $request->all();             

            if ($request->status == 'exp') {
                $stokexp = StokExp::with('products')->where('id',$request->id)->where('qty', '<>', 0)->first();                                
            }else{
                $stokexp = Product::where('id',$request->id)->first();                
            }
            
        return view('konversi.modal._form-set_qty',[
            'exp' => $stokexp,
            'status' => $request->status
        ]);

    }

    public function inputQty(Request $request)
    {

        TempKonversiDet::where('created_at', '<', Carbon::today())->delete();
        TempKonversiDet::where('user_id', '=', Auth::user()->id)->delete();
        TempKonversi::where('created_at', '<', Carbon::today())->delete();
        TempKonversi::where('user_id', '=', Auth::user()->id)->delete();
        
               
        // get data dari exp date
        if ($request->status =='exp')  {
            $exp  = StokExp::where('id',$request->exp_id)->first();    
            $stok = $exp->qty;            
            $productId = $exp->product_id;
            $expdate = $exp->id;
            $tanggal = $exp->tanggal;
        }else{
            $exp  = Product::where('id',$request->exp_id)->first();                
            $stok = $exp->stok;
            $productId = $exp->id;
            $expdate = null;
            $tanggal = null;
        }        

        if ($stok < $request->qty_konversi) {
            return back()->with('error','jumlah konversi tidak boleh melebihi stok barang');
        }

        $title = "Data Produk Konversi";
        
        // input ke temp_konversi
        $tempKonversi = TempKonversi::create([
            'tanggal' => date('Y-m-d'),
            'user_id' => auth()->user()->id,
            'product_id' => $productId,
            'qty' => $request->qty_konversi,
            'expdate_id' => $expdate,
            'exp_date' => $tanggal,
            'status' => $request->status
        ]);


        return view('konversi.input-product',[
            'temp' => $tempKonversi,
            'title' => $title,
            'status' => $request->status
        ]);
    }

    public function caribarang()
    {
        $products = Product::with(['categories', 'subcategories']);
        $produk = "";

        if (request()->ajax()) {
            return Datatables::of($products)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    return view('konversi.modal._pilihkonversi', compact('id'));
                })
                ->make(true);
        }
        
        return view('konversi.modal._caribarang', compact('produk'));
    }

    public function setbarang(Request $request)
    {
        $product = Product::where('id', '=', $request->id)->get()->first();        
        $mode = "new";
        return view('konversi.modal._setbarang', compact('product', 'mode'));
    }

    public function submitItem(Request $request)
    {
        $temp = TempKonversi::where('id',$request->konversi_id)->first();
        $exp = StokExp::where('id',$temp->expdate_id)->first();

        if ($temp->status == 'exp') {
            if ($exp->lot <> null) {
                TempKonversiDet::create([
                    'temp_konversi_id' => $request->konversi_id,
                    'product_id' => $request->product_id,
                    'tanggal'=> date('Y-m-d'),
                    'qty' => $request->qty,
                    'satuan' => $request->satuan,
                    'exp_date' => $temp->exp_date,
                    'user_id' => auth()->user()->id,
                    'lot' => $exp->lot,
                    'keterangan'=> $request->keterangan
                ]);
            }else{
                TempKonversiDet::create([
                    'temp_konversi_id' => $request->konversi_id,
                    'product_id' => $request->product_id,
                    'tanggal'=> date('Y-m-d'),
                    'qty' => $request->qty,
                    'satuan' => $request->satuan,
                    'exp_date' => $temp->exp_date,
                    'user_id' => auth()->user()->id,
                    'keterangan'=> $request->keterangan
                ]);
            }
        }else{
            TempKonversiDet::create([
                'temp_konversi_id' => $request->konversi_id,
                'product_id' => $request->product_id,
                'tanggal'=> date('Y-m-d'),
                'qty' => $request->qty,
                'satuan' => $request->satuan,
                'exp_date' => null,
                'user_id' => auth()->user()->id,
                'keterangan'=> $request->keterangan
            ]);
        }                

    }

    public function loadKonversi()
    {
        $temp = TempKonversiDet::with(['product'])
                            ->where('user_id', '=', Auth::user()->id)
                            ->get();    
                                                      
        return view('konversi.partial.tabelkonversi', compact('temp'));

    }

     // menghapus data temp = done
     public function destroy_detail(Request $request)
     {
         $id = $request->id;
         TempKonversiDet::destroy($id);
         

         return response()->json($id);
     }
 
 
     
     public function editbarang(Request $request)
     {
         $item = TempKonversiDet::where('id', $request->id)->first();                  
         $id_product = $item->product_id;         

         $product = new Product;
         $productx = Product::where('id', '=', $id_product)->first();         
         $product_name = $productx->nama;
         $mode = "edit";

         return view('konversi.modal._setbarang', compact('product_name', 'mode', 'item', 'product'));
     }


     public function updateBarang(Request $request)
     {
        

        TempKonversiDet::where('id',$request->konversi_id)->update([
            'qty' =>  $request->qty,
            'keterangan' => $request->keterangan
        ]);
        
     }

     public function store(Request $request)
     {                
        
        // kurangi stok di master sesuai dengan product id di header        
        $tempkonversi = TempKonversi::where('id',$request->konversi_id)->first();

        // dd($tempkonversi);

        DB::beginTransaction();

        try {
            
            $produk = Product::where('id',$tempkonversi->product_id)->first();
            $stok = $produk->stok - $tempkonversi->qty;
            $produk->stok = $stok;
            $produk->update();

             //  input ke konversi
             $kode =  $this->getKodeTransaksi("konversis", "KV");
             $konversi = Konversi::create([
                 'tanggal' => date('Y-m-d'),
                 'kode' => $kode,
                 'user_id' => auth()->user()->id,
                 'product_id' => $tempkonversi->product_id,
                 'qty' => $tempkonversi->qty,
                 'expdate_id' => $tempkonversi->expdate_id,
                 'exp_date' => $tempkonversi->exp_date,
                 'keterangan' => $request->keterangan
             ]);   

             

    
             if ($tempkonversi->status =="exp") {
                
                // kurangi stok dari exp list sesuai dengan product id dan date
                    $exp = StokExp::where('id',$tempkonversi->expdate_id)->first();
                    $stokexp = $exp->qty - $tempkonversi->qty;
                    $exp->qty = $stokexp;
                    $exp->update();            

                    // input stok minus yang ada di stock_exp_detail                    
                    $expdet = StokExpDetail::create([
                        'tanggal' => $exp->tanggal,
                        'stok_exp_id' => $exp->id,
                        'product_id' => $produk->id,
                        'qty' => $tempkonversi->qty * -1,
                        'konversi_id' => $konversi->id
                    ]);       
                    
                    
             }


            
            
           
            $tempdetail = TempKonversiDet::where('temp_konversi_id',$request->konversi_id)->get();
            
    
            foreach ($tempdetail as $item) {
                
                // tambahi stok di produk dengan looping temp konvert det
                $produkdet = Product::where('id',$item->product_id)->first();
                $stokdet = $produkdet->stok + $item->qty;
                $produkdet->stok = $stokdet;
                $produkdet->save();
    
                // input ke ke konversi_det
               $konversidet =  KonversiDetail::create([
                    'tanggal' => $konversi->tanggal,                
                    'konversi_id' => $konversi->id,
                    'user_id' => auth()->user()->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'satuan' => $item->satuan,
                    'expdate_id' => $item->expdate_id,
                    'exp_date' => $item->exp_date,
                    'keterangan' => $item->keterangan
                ]);
    
                // insert ke inv transaction dengan id product det ditambahin        
                $inv = InventoryTransaction::create([
                    'tanggal' => $item->tanggal,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'stok' =>  $stokdet,
                    'hpp' => $produkdet->hpp,
                    'jenis' => 'KV',
                    'jenis_id' => $kode,
                ]);

                if ($tempkonversi->status == 'exp') {
                         // insert masing-masing exp stok dan exp date sesuai dengan product id dan tanggal 
                            // cek jika ada tanggal yang sama maka ditambah
                            $mainStokExp = StokExp::where('tanggal', '=', $item->tanggal)
                            ->where('product_id', '=', $item->product_id)                    
                            ->where('lot',$item->lot)
                            ->count();                        
                                        
                        if ($mainStokExp > 0) {
                            //ada data, tinggal update stok
                            $stokExp =  StokExp::where('tanggal', '=', $item->tanggal)
                                ->where('product_id', '=', $item->product_id)->first();
                            $id_stokExp = $stokExp->id;
                            $stokExp->qty += $item->qty;
                            $stokExp->save();

                            //insert detail
                            $stokExpDetail = new StokExpDetail;
                            $stokExpDetail->tanggal = $item->exp_date;
                            $stokExpDetail->stok_exp_id = $id_stokExp;
                            $stokExpDetail->product_id = $item->product_id;
                            $stokExpDetail->qty = $item->qty;
                            $stokExpDetail->konversi_id = $konversi->id;
                            $stokExpDetail->konversi_detail_id = $konversidet->id;                  
                            $stokExpDetail->save();

                        } else {
                            //tidak ada data, harus insert stok
                            $datas['tanggal'] = $item->exp_date;
                            $datas['product_id'] = $item->product_id;
                            $datas['qty'] = $item->qty;                    
                            $datas['lot'] = $item->lot;         
                            $id_stokExp = StokExp::create($datas)->id;

                            //insert detail;
                            $stokExpDetail = new StokExpDetail;
                            $stokExpDetail->tanggal = $item->exp_date;
                            $stokExpDetail->stok_exp_id = $id_stokExp;
                            $stokExpDetail->product_id = $item->product_id;
                            $stokExpDetail->qty = $item->qty;                    
                            $stokExpDetail->konversi_id = $konversi->id;
                            $stokExpDetail->konversi_detail_id = $konversidet->id;
                            $stokExpDetail->save();

                        }            
                }
    
    
               
                
            }
                   
            // insert ke inv transaction dengan id product header dikurangi 
            $inv = InventoryTransaction::create([
                'tanggal' => $tempkonversi->tanggal,
                'product_id' => $tempkonversi->product_id,
                'qty' => $tempkonversi->qty * -1,
                'stok' =>  $stok,
                'hpp' => $produk->hpp,
                'jenis' => 'KV',
                'jenis_id' => $kode,
            ]);
    
            // hapus temp_konversi_detail    
            TempKonversiDet::where('created_at', '<', Carbon::today())->delete();
            TempKonversiDet::where('user_id', '=', Auth::user()->id)->delete();
    
            //  hapus temp_konversi
            TempKonversi::where('created_at', '<', Carbon::today())->delete();
            TempKonversi::where('user_id', '=', Auth::user()->id)->delete();

            DB::commit();

            return redirect()->route('konversisatuan.index')->with('sukses', 'Konversi Produk Berhasil ditambahkan !');

        } catch (Exception $th) {

            DB::rollback();
            return redirect()->back()->with('error', $th->getMessage());

        }

       
                
    
     }

     public function delete(Request $request)
     {
        $data = Konversi::where('id',$request->id)->first();
        $id = $data->id;        
        $can_delete = 'YES';

        return view('konversi.modal._confirmDelete', compact('id', 'can_delete'));
     }

     public function destroy(Request $request)
     {

        $konversi = Konversi::with('product')->findOrFail($request->id);        
        DB::beginTransaction();

        try {

            #### utama
            // insert qty di product
            $product = Product::where('id',$konversi->product_id)->first();
            $stok = $product->stok + $konversi->qty;
            $product->stok = $stok;
            $product->update();

            // insert qty pada stock_exp
            $exp = StokExp::where('id',$konversi->expdate_id)->first();
            $stokexp = $exp->qty + $konversi->qty;
            $exp->qty = $stokexp;
            $exp->update();
            
            // insert qty pada stock_exp_det              
            $expdet = StokExpDetail::create([
                'tanggal' => $exp->tanggal,
                'stok_exp_id' => $exp->id,
                'product_id' => $product->id,
                'qty' => $konversi->qty * 1,            
            ]);

            // insert pada inventory             
            $inv = InventoryTransaction::create([
                'tanggal' => $konversi->tanggal,
                'product_id' => $konversi->product_id,
                'qty' => $konversi->qty,
                'stok' =>  $stok,
                'hpp' => $product->hpp,
                'jenis' => 'KV',
                'jenis_id' => $konversi->kode,
            ]);


            ### pecahan
            $konversiDet = KonversiDetail::where('konversi_id',$konversi->id)->get();
            foreach ($konversiDet as $item) {
                    // kurangi stock pada produk
                    $productdet = Product::where('id',$item->product_id)->first();
                    $stokdet = $productdet->stok - $item->qty;
                    $productdet->stok = $stokdet;
                    $productdet->update();                

                    // kurangi stock pada stock_exp                
                    $expdet = StokExp::where('tanggal', $item->tanggal)
                                ->where('product_id', $item->product_id)
                                ->where('lot',$item->lot)
                                ->first();
    
                    $stokexpdet = $expdet->qty - $item->qty;
                    $expdet->qty = $stokexpdet;
                    $expdet->update();                

                    // kurangi stock pada stock_exp_det
                    $expdet = StokExpDetail::create([
                        'tanggal' => $expdet->tanggal,
                        'stok_exp_id' => $expdet->id,
                        'product_id' => $item->product_id,
                        'qty' => $item->qty * -1,            
                    ]);

                    // insert pada inventory (pengurangan)                                
                    $inv = InventoryTransaction::create([
                        'tanggal' => $item->tanggal,
                        'product_id' => $item->product_id,
                        'qty' => $item->qty * -1,
                        'stok' =>  $stokdet,
                        'hpp' => $productdet->hpp,
                        'jenis' => 'KV',
                        'jenis_id' => $konversi->kode,
                    ]);

                    
            }       
            
            // hapus konversi detail
            $konversiDet->each->delete();

            // hapus konversi
            $konversi->delete();

            DB::commit();
            return redirect()->route('konversisatuan.index')->with('status', 'Data Berhasil dihapus !');

        } catch (Exception $th) {
            DB::rollback();            
            return redirect()->route('konversisatuan.index')->with('error', $th->getMessage());
        }

     
     }

     public function show($id)
     {
        $title =  "Konversi Produk";
        $konversi = Konversi::with(['user','product','creator','updater'])->where('id',$id)->first();
        $konversidet = KonversiDetail::with(['user','product','creator','updater'])->where('konversi_id',$id)->get();                

        $listexp = StokExpDetail::with('products')->where('konversi_id',$id)
                                                  ->where('konversi_detail_id','<>',null)->get();
        
        
        return view('konversi.show',compact('konversi','konversidet','title','listexp'));
     }
    


}
