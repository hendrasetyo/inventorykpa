
<table>
    <tr>
        <th>Produk : </th>
        <td>{{$kartustok[0]->product->nama}}</td>

    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Qty</th>
            <th>Stok</th>
            <th>Transaksi</th>
            <th>Kode Transaksi</th>
            <th>Customer</th>
            <th>Supplier</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
            @php
                $no =1;
            @endphp
            @foreach ($kartustok as $item)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{ Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}</td>
                    <td>{{$item->qty}}</td>
                    <td>{{$item->stok}}</td>
                    <td>{{$item->jenis}}</td>
                    <td>{{$item->jenis_id}}</td>
                    <td>{{$item->customer}}</td>
                    <td>{{$item->supplier}}</td>
                </tr>
            @endforeach
    </tbody>    
</table>