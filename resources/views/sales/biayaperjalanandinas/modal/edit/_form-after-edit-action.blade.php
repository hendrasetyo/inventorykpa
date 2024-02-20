<div class="modal fade" id="modalafteredit" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Entertainment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" style="height: 400px;">
                <form class="form">
                    <div class="form-group">
                        <label for="">Nama Perusahaan / Institusi</label>
                        <input type="text" name="nama_perusahaaan" value="{{$entertain->nama_perusahaan}}" id="nama_perusahaan" class="form-control" >
                    </div>
                     <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="nama" id="nama" value="{{$entertain->nama}}" class="form-control" >
                    </div>
                     <div class="form-group">
                        <label for="">Jenis Entertainment</label>
                        <input type="text" name="jenis_entertainment" value="{{$entertain->jenis_entertainment}}" id="jenis_entertainment" class="form-control" >
                    </div>   
                    <div class="form-group">
                        <label for="">Tujuan Entertainment</label>
                        <input type="text" name="tujuan_entertainment" value="{{$entertain->tujuan_entertainment}}" id="tujuan_entertainment" class="form-control">
                    </div>        
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="javascript:updateAfter({{$entertain->id}});" class="btn btn-primary font-weight-bold"
                >Simpan</button>
                <button type="button" class="btn btn-light-primary font-weight-bold"
                    data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>