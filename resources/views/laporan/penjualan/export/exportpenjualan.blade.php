<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kode Faktur</th>
            <th>No KPA</th>
            <th>Kode SO</th>
            <th>Kode SJ</th>
            <th>No Pajak</th>
            <th>Customer</th>                                        
            <th>Diskon Rupiah</th>
            <th>Diskon Persen</th>
            <th>Subtotal</th>
            <th>Total Diskon Detail</th>
            <th>Total Diskon Header</th>
            <th>Total</th>
            <th>Ongkir</th>
            <th>PPN</th>            
            <th>Grand Total</th>                                                    
            <th>Sales</th>
            <th>Pembuat</th>
            <th>Keterangan</th>                                        
        </tr>
    </thead>
    <tbody>
        @php
            $no=1;
        @endphp
        @foreach ($penjualan as $item)
            <tr>
                <td>{{$no++}}</td>
                <td>{{ date('d/m/Y', strtotime($item->tanggal)) }}</td>
                <td>{{$item->kode}}</td>
                <td>{{$item->no_kpa}}</td>
                <td>{{$item->kode_SP}}</td>
                <td>{{$item->kode_SJ}}</td>
                <td>{{$item->no_seri_pajak .'-'. $item->no_pajak}}</td>
                <td>{{$item->nama_customer}}</td>
                <td>{{$item->diskon_rupiah}}</td>
                <td>{{$item->diskon_persen}}</td>
                <td>{{$item->subtotal}}</td>
                <td>{{$item->total_diskon_detail}}</td>
                <td>{{$item->total_diskon_header}}</td>
                <td>{{$item->total}}</td>       
                <td>{{$item->ongkir}}</td>
                <td>{{$item->ppn}}</td>                                                     
                <td>{{$item->grandtotal}}</td>                  
                <td>{{$item->nama_sales}}</td>
                <td>{{$item->nama_pembuat}}</td>
                <td>{{$item->keterangan}}</td>                                            
            </tr>
        @endforeach
    </tbody>
</table>