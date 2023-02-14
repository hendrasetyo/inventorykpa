<div class="modal fade" id="modalafter" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Setelah Perawatan Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" style="height: 400px;">
                <form class="form">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama Sparepart</label>
                            <input type="text" name="nama_sparepart" id="nama_sparepart" class="form-control" placeholder="Masukan Nama Sparepart">
                        </div>
                         <div class="form-group">
                            <label for="">Qty</label>
                            <input type="text" name="qty" id="qty" class="form-control" placeholder="Masukan Qty">
                        </div>
                         <div class="form-group">
                            <label for="">Pekerjaan</label>
                            <textarea name="pekerjaan" id="pekerjaan" class="form-control" id="" cols="30" rows="5"></textarea>
                        </div>                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="javascript:submitAfter();" class="btn btn-primary font-weight-bold"
                >Simpan</button>
                <button type="button" class="btn btn-light-primary font-weight-bold"
                    data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>