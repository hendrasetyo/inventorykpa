<table >
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Satuan</th>
            <th>Stok EXP</th>
            <th>Stok Master</th>
            <th>Status</th>            
        </tr>
    </thead>
    <tbody>
        @php
            $no=1;
        @endphp
        @foreach ($data as $item)
          
            <tr>
                <td>{{$no++}}</td>
                <td>{{$item['nama_product']}}</td>
                <td>{{$item['satuan']}}</td>
                <td>{{$item['qty_exp']}}</td>
                <td>{{$item['stok']}}</td>                                            
                <td style="background-color: red">Error</td>                                                                                
            </tr>
        @endforeach
    </tbody>
</table>