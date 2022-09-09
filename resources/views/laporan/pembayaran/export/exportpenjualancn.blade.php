<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Tanggal</th>
            <th>Kode Faktur</th>
            <th>Kode SO</th>
            <th>Kode SJ</th>
            <th>No Pajak</th>
            <th>Customer</th>                                        
            <th>Diskon Rupiah Faktur</th>
            <th>Diskon Persen Faktur</th>
            <th>Subtotal Faktur</th>
            <th>Total Diskon Detail Faktur</th>
            <th>Total Diskon Header Faktur</th>
            <th>Total Faktur</th>
            <th>PPN Faktur</th>
            <th>Ongkir Faktur</th>                                                                                
            <th>Grand Total Faktur</th>                    
            <th>Nama Produk</th> 
            <th>Kode Produk</th>   
            <th>Qty</th>
            <th>Satuan</th>
            <th>Harga Jual Produk</th>
            <th>Diskon Persen Produk</th>
            <th>Diskon Rupiah Produk</th>
            <th>Subtotal Produk</th>
            <th>Total Diskon Produk</th>
            <th>Total Produk</th>
            <th>Ongkir Produk</th>
            <th>CN Persen</th>
            <th>CN Rupiah</th>
            <th>CN Total</th>
            <th>Sales</th>
            <th>Pembuat</th>                                        
            <th>Keterangan</th>                                          
            <th>Keterangan Produk</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no=1;
        @endphp
        @foreach ($penjualan as $item)
            <tr>
                <td>{{$no++}}</td>
                <td>{{ date('d F Y', strtotime($item->tanggal)) }}</td>
                <td>{{$item->kode}}</td>
                <td>{{$item->kode_SP}}</td>
                <td>{{$item->kode_SJ}}</td>
                <td>{{$item->no_pajak}}</td>
                <td>{{$item->nama_customer}}</td>
                <td>{{$item->diskon_rupiah}}</td>
                <td>{{$item->diskon_persen}}</td>
                <td>{{$item->subtotal}}</td>
                <td>{{$item->total_diskon_detail}}</td>
                <td>{{$item->total_diskon_header}}</td>
                <td>{{$item->total}}</td>       
                <td>{{$item->ppn}}</td>         
                <td>{{$item->ongkir}}</td>                            
                <td>{{$item->grandtotal}}</td>                  
                <td>{{$item->nama_produk}}</td>
                <td>{{$item->kode_produk}}</td>
                <td>{{$item->qty_det}}</td>
                <td>{{$item->satuan_det}}</td>
                <td>{{$item->hargajual_det}}</td>
                <td>{{$item->dikson_persen_det}}</td>
                <td>{{$item->diskon_rp_det}}</td>
                <td>{{$item->subtotal_det}}</td>
                <td>{{$item->total_diskon_det}}</td>
                <td>{{$item->total_det}}</td>
                <td>{{$item->ongkir_det}}</td>
                <td>{{$item->cn_persen ? $item->cn_persen : 0}}%</td>
                <td>{{$item->cn_rupiah ? $item->cn_rupiah : 0}}</td>
                <td>{{$item->cn_total ? $item->cn_total : 0}}</td>
                <td>{{$item->nama_sales}}</td>
                <td>{{$item->nama_pembuat}}</td>
                <td>{{$item->keterangan}}</td>                                            
                <td>{{$item->keterangan_det}}</td>
            </tr>
        @endforeach
    </tbody>
</table>