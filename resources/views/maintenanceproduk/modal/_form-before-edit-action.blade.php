<div class="modal fade" id="modalbeforeedit" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sebelum Perawatan Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" style="height: 400px;">
                <form class="form">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama Alat</label>
                            <input type="text" name="nama_alat" id="nama_alat" class="form-control" value="{{$tempBefore->nama_alat}}" placeholder="Masukan Nama Alat">
                        </div>
                         <div class="form-group">
                            <label for="">No Seri</label>
                            <input type="text" name="no_seri" id="no_seri" class="form-control" value="{{$tempBefore->no_seri}}" placeholder="Masukan No Seri">
                        </div>
                         <div class="form-group">
                            <label for="">Keluhan</label>
                            <textarea name="keluhan" id="keluhan" class="form-control" id="" cols="30" rows="5">{{$tempBefore->keluhan}}</textarea>
                        </div>                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="javascript:updateBefore({{$tempBefore->id}});" class="btn btn-primary font-weight-bold"
                         >Simpan</button>
                <button type="button" class="btn btn-light-primary font-weight-bold"
                    data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>