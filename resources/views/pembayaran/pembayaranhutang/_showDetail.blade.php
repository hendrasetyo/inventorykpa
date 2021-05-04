<!-- Modal-->

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pembayaran Hutang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" style="height: 400px;">


                <table class="table">

                    <tbody>
                        <tr>
                            <th scope="row">Tanggal</th>
                            <td>:</td>
                            <td>{{ $pembayaranhutang->tanggal->format("d F Y")  }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Supplier</th>
                            <td>:</td>
                            <td>{{ $pembayaranhutang->suppliers->nama }}</td>
                        </tr>
                        <tr>
                            <th scope="row">No. Faktur</th>
                            <td>:</td>
                            <td>{{ $pembayaranhutang->FakturPO->kode }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Media Pembayaran</th>
                            <td>:</td>
                            <td>{{ $pembayaranhutang->banks->nama }}</td>
                        </tr>

                        <tr>
                            <th scope="row">Jumlah Pembayaran</th>
                            <td>:</td>
                            <td>{{ "Rp. " . number_format($pembayaranhutang->nominal, 0, ',', '.') }}</td>
                        </tr>

                        <tr>
                            <th scope="row">Keterangan</th>
                            <td>:</td>
                            <td>{{ $pembayaranhutang->keterangan }}</td>
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