<table>
    <thead class="datatable-head">
        <tr>                 
            <th>No</th>
            <th>Kode</th>
            <th>Kategori Supplier</th>
            <th>Nama</th>                                       
            <th>Alamat</th>
            <th>Blok</th>
            <th>Nomor</th>
            <th>RT</th>
            <th>RW</th>
            <th>Kelurahan</th>
            <th>Kecamatan</th>
            <th>Kota</th>
            <th>Provinsi</th>
            <th>Kode Pos</th>
            <th>Telp</th>
            <th>Email</th>
            <th>Npwp</th>
                                                                                                                                                            
        </tr>
    </thead>
    <tbody>

        @php
            $no=0;
        @endphp
        @foreach ($customer as $item)
            <tr>                
                <td>{{$no++}}</td>
                <td>{{$item->kode}}</td>
                <td>{{$item->kategori ? $item->kategori->nama : '-' }}</td> 
                <td>{{$item->nama}}</td>                                               
                <td>{{$item->alamat}}</td>                                               
                <td>{{$item->blok}}</td>                                               
                <td>{{$item->nomor}}</td>
                <td>{{$item->RT}}</td>
                <td>{{$item->RW}}</td>
                <td>{{$item->kelurahans->name}}</td>
                <td>{{$item->kecamatans->name}}</td>
                <td>{{$item->namaKota->name}}</td>
                <td>{{$item->prov->name}}</td>
                <td>{{$item->kodepos}}</td>
                <td>{{$item->tlp}}</td>
                <td>{{$item->email}}</td>
                <td>{{$item->npwp}}</td>
            </tr>
        @endforeach
    </tbody>
</table>