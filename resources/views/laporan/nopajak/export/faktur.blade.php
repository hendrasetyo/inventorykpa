<table>
    <thead class="datatable-head">
        <tr>                 
            <th>No</th>
            <th>Tanggal</th>                                       
            <th>Customer</th>
            <th>Kode Faktur Penjualan</th>
            <th>Kode KPA</th>
            <th>No Faktur Pajak</th>                                                                                                                                                
        </tr>
    </thead>
    <tbody>

        @php
            $no=0;
        @endphp
        @foreach ($nopajak as $item)
            <tr>                
                <td>{{$no++}}</td>
                <td>{{Carbon\Carbon::parse($item->tanggal)->format('d/m/Y')}}</td> 
                <td>{{$item->customers->nama}}</td>                                               
                <td>{{$item->kode}}</td>                                               
                <td>{{$item->no_kpa}}</td>                                               
                <td>{{$item->nopajak ? $item->nopajak->no_pajak : '-'}}</td>
            </tr>
        @endforeach
    </tbody>
</table>