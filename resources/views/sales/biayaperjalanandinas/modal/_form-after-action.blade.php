<div class="modal fade" id="modalafter" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kas Bon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" style="height: 400px;">
                <form class="form">                    
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" >
                        </div>
                         <div class="form-group">
                            <label for="">Nominal</label>
                            <input type="number" name="number" id="nominal" class="form-control" >
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