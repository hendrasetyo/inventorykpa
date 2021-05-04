<!-- Modal-->

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Supplier</h5>
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
                            <td>{{ $supplier->kode }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Nama</th>
                            <td>:</td>
                            <td>{{ $supplier->nama }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Alamat</th>
                            <td>:</td>
                            <td>{{ $supplier->alamat }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Blok / Nomor</th>
                            <td>:</td>
                            <td>{{ $supplier->blok.' / '.$supplier->nomor }}</td>
                        </tr>
                        <tr>
                            <th scope="row">RT/RW</th>
                            <td>:</td>
                            <td>{{ $supplier->rt.' / '.$supplier->rw }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Kelurahan</th>
                            <td>:</td>
                            <td>{{ $supplier->kelurahans->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Kecamatan</th>
                            <td>:</td>
                            <td>{{ $supplier->kecamatans->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Kota</th>
                            <td>:</td>
                            <td>{{ $supplier->namakota->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Provinsi</th>
                            <td>:</td>
                            <td>{{ $supplier->prov->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Kode Pos</th>
                            <td>:</td>
                            <td>{{ $supplier->kodepos }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Tlp.</th>
                            <td>:</td>
                            <td>{{ $supplier->tlp }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td>:</td>
                            <td>{{ $supplier->email }}</td>
                        </tr>
                        <tr>
                            <th scope="row">NPWP</th>
                            <td>:</td>
                            <td>{{ $supplier->npwp }}</td>
                        </tr>

                        <tr>
                            <th scope="row">Keterangan</th>
                            <td>:</td>
                            <td>{{ $supplier->keterangan }}</td>
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