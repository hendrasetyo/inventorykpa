<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jenis Biaya</th>
            <th>Nominal</th>
            <th>Sumber Dana</th>
            <th>Request</th>
            <th>Keterangan</th>
            
        </tr>
    </thead>
    <tbody>
        {{-- @dd($data) --}}
        @php
            $no=1;
        @endphp
        @foreach ($data as $item)
            <tr>
                <td>{{$no++}}</td>
                <td>{{ date('d/m/Y', strtotime($item->tanggal)) }}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->nominal}}</td>
                <td>{{$item->nama_bank}}</td>                                            
                <td>{{$item->request}}</td>  
                <td>{{$item->keterangan}}</td>                                                                                
            </tr>
        @endforeach
    </tbody>
</table>