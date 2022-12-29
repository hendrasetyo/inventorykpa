<table >
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kode Adjustment</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Qty</th>
            
        </tr>
    </thead>
    <tbody>
        @php
            $no=1;
        @endphp
        @foreach ($data as $item)
            <tr>
                <td>{{$no++}}</td>
                <td>{{ date('d/m/Y, strtotime($item->tanggal_adjustment)) }}</td>
                <td>{{$item->kode_adjustment}}</td>
                <td>{{$item->kode}}</td>
                <td>{{$item->nama}}</td>                                            
                <td>{{$item->qty_adjustment}}</td>                                                                                
            </tr>
        @endforeach
    </tbody>
</table>