<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Tanggal</th>
            <th>Supplier</th>
            <th>Kode SO</th>
            <th>Kode SJ</th>
            <th>Kode Faktur</th>
            <th>DPP</th>                                        
            <th>PPN</th>
            <th>Total</th>                                        
            <th>Telah Dibayar</th>
            <th>Sisa</th>
            <th>Status</th>                                                                                
        </tr>
    </thead>
    <tbody>
        @php
            $no=1;
        @endphp
        @foreach ($hutang as $item)
            <tr>
                <td>{{$no++}}</td>
                <td>{{ date('d/m/Y', strtotime($item->tanggal)) }}</td>
                <td>{{$item->nama_supplier}}</td>
                <td>{{$item->kode_pp}}</td>
                <td>{{$item->kode_pb}}</td>
                <td>{{$item->kode_fp}}</td>                                            
                <td>{{$item->dpp}}</td>
                <td>{{$item->ppn}}</td>
                <td>{{$item->total}}</td>
                <td>{{$item->dibayar}}</td>
                <td>{{$item->total - $item->dibayar}}</td>                                            
                <td>
                    @if ($item->status == 1)
                        Belum Lunas
                    @else
                        Lunas
                    @endif
                </td>                                        
            </tr>
        @endforeach
    </tbody>
</table>