<!-- Modal-->
<div class="modal fade" id="setPpnModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PPN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" style="height: 400px;">

                <form class="form">
                    <div class="card-body">

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">PPN(%)</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" id="ppn_persen" name="ppn_persen"
                                    value="{{ $persen }}" />
                                <input type="hidden" id="id_ppn" name="id_ppn" value="{{ $id_ppn }}" />
                            </div>
                        </div>

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" onclick="javascript:updatePPN();" class="btn btn-success mr-2">Update</button>

            </div>
        </div>
    </div>

</div>
<!-- Modal-->