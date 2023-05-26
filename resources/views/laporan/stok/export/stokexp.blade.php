<table >
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Produk</th>
            <th>Kode Barang</th>
            <th>Lot</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no=1;
        @endphp
        @foreach ($stok as $item)
            <tr>
                <td>{{$no++}}</td>
                <td>{{ date('d/m/Y', strtotime($item->tanggal)) }}</td>
                <td>{{$item->nama_produk}}</td>
                <td>{{$item->kode}}</td>
                <td>{{$item->lot}}</td>                                            
                <td>{{$item->qty}}</td>                                                                                
            </tr>
        @endforeach
    </tbody>
</table>