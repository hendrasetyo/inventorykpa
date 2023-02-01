<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Sales</th>
            <th>Customer</th>
            <th>Aktivitas</th>
            <th>Foto</th>
            <th>TTD</th>                                
        </tr>
    </thead>
    <tbody>
        @php
            $no=1;
        @endphp
        @foreach ($data as $item)
            <tr>
                <td>{{$no++}}</td>
                <td>{{ date('d/m/Y', strtotime($item->tanggal)) }}</td>
                <td>{{$item->nama_sales}}</td>
                <td>{{$item->customer}}</td>
                <td>{{$item->aktifitas}}</td>   
            </tr>
        @endforeach
    </tbody>
</table>