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
                        <label for="">Perjalanan</label>
                        <select name="perjalanan" id="perjalanan" class="form-control" >
                            @foreach ($perjalanan as $item)
                                @if ($akomodasi->perjalanandinas_id == $item->id)
                                    <option value="{{$item->id}}" selected>{{$item->asal_mana}} - {{$item->tujuan}}</option>                                        
                                @else
                                    <option value="{{$item->id}}">{{$item->asal_mana}} - {{$item->tujuan}}</option>                                        
                                @endif                                                
                            @endforeach                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Biaya Hotel</label>
                        <input type="number" name="biaya_hotel" id="biaya_hotel" value="{{$akomodasi->biaya_hotel}}" class="form-control" required> 
                    </div>
                    <div class="form-group">
                        <label for="">Biaya Transportasi</label>
                        <input type="number" name="biaya_transportasi" id="biaya_transportasi" value="{{$akomodasi->biaya_transportasi}}" class="form-control" required>
                    </div>                   

                    <div class="form-group">
                        <label for="">Biaya Makan</label>
                        <input type="number" name="biaya_makan" id="biaya_makan" value="{{$akomodasi->biaya_makan}}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="">Biaya Laundry</label>
                        <input type="number" name="biaya_laundry" id="biaya_laundry" value="{{$akomodasi->biaya_laundry}}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="">Biaya Entertainment</label>
                        <input type="number" name="biaya_entertainment" id="biaya_entertainment" value="{{$akomodasi->biaya_entertainment}}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="">Biaya Lainya </label>
                        <input type="number" name="biaya_lainya" id="biaya_lainya" value="{{$akomodasi->biaya_lainya}}" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="javascript:updateBefore({{$akomodasi->id}});"
                    class="btn btn-primary font-weight-bold">Simpan</button>
                <button type="button" class="btn btn-light-primary font-weight-bold"
                    data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
