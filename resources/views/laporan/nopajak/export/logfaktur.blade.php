<table >
    <thead >
        <tr>     
            <th>ID</th>                                       
            <th>Tanggal</th>                                             
            <th>No Faktur Pajak</th>                                                                                                                                    
            <th>Jenis</th>
            <th>Kode Faktur</th>
            <th>Pembuat</th>            
        </tr>
    </thead>
    <tbody>
        @foreach ($logfaktur as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>{{Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</td>                                                
                <td>{{$item->nofaktur->no_pajak}}</td>
                <td>{{$item->jenis}}</td>
                <td>{{$item->jenis_id}}</td>
                <td>{{$item->creator->name}}</td>              
            </tr>
        @endforeach
    </tbody>
</table>