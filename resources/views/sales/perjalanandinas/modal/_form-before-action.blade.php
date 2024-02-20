<div class="modal fade" id="modalbefore" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Transportasi & Hotel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" style="height: 600px;">
                <form class="form">
                    <div class="form-group">
                        <label for="">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control"
                            placeholder="Masukan Nama Alat">
                    </div>
                    <div class="form-group">
                        <label for="">Dari</label>
                        <input type="text" name="asal_mana" id="asal_mana" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Ke</label>
                        <input type="text" name="tujuan" id="tujuan" class="form-control">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Waktu Mulai</label>
                                <input type="time" name="waktu_mulai" id="waktu_mulai" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Waktu Selesai</label>
                                <input type="time" name="waktu_selesai" id="waktu_selesai" class="form-control">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="">Jenis Transportasi</label>
                        <input type="text" name="jenis_transportasi" id="jenis_transportasi" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Penyedia Transportasi</label>
                        <input type="text" name="penyedia_transportasi" id="penyedia_transportasi" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Waktu Berangkat</label>
                        <input type="time" name="waktu_berangkat" id="waktu_berangkat" class="form-control"
                            >
                    </div>

                    <div class="form-group">
                        <label for="">Nama Hotel</label>
                        <input type="text" name="nama_hotel" id="nama_hotel" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="javascript:submitBefore();"
                    class="btn btn-primary font-weight-bold">Simpan</button>
                <button type="button" class="btn btn-light-primary font-weight-bold"
                    data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
