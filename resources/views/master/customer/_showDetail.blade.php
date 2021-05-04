<!-- Modal-->

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" style="height: 400px;">


                <table class="table">

                    <tbody>
                        <tr>
                            <th scope="row">Kode</th>
                            <td>:</td>
                            <td>{{ $customer->kode }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Nama</th>
                            <td>:</td>
                            <td>{{ $customer->nama }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Alamat</th>
                            <td>:</td>
                            <td>{{ $customer->alamat }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Blok / Nomor</th>
                            <td>:</td>
                            <td>{{ $customer->blok.' / '.$customer->nomor }}</td>
                        </tr>
                        <tr>
                            <th scope="row">RT/RW</th>
                            <td>:</td>
                            <td>{{ $customer->rt.' / '.$customer->rw }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Kelurahan</th>
                            <td>:</td>
                            <td>{{ $customer->kelurahans->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Kecamatan</th>
                            <td>:</td>
                            <td>{{ $customer->kecamatans->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Kota</th>
                            <td>:</td>
                            <td>{{ $customer->namakota->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Provinsi</th>
                            <td>:</td>
                            <td>{{ $customer->prov->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Kode Pos</th>
                            <td>:</td>
                            <td>{{ $customer->kodepos }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Tlp.</th>
                            <td>:</td>
                            <td>{{ $customer->tlp }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td>:</td>
                            <td>{{ $customer->email }}</td>
                        </tr>
                        <tr>
                            <th scope="row">NPWP</th>
                            <td>:</td>
                            <td>{{ $customer->npwp }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Salesman</th>
                            <td>:</td>
                            <td>{{ $customer->salesman->nama}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Keterangan</th>
                            <td>:</td>
                            <td>{{ $customer->keterangan }}</td>
                        </tr>
                    </tbody>
                </table>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

</div>
<!-- Modal-->