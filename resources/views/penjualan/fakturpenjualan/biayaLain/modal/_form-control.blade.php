<div class="modal fade" id="tambahdata" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form" method="post" action="{{ route('fakturpenjualan.biayalain.store') }}">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Biaya Lain - Lain</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">            
                    @csrf
                    <div class="card-body">    
                        <div class="form-group">
                            <label>Jenis Biaya :</label> <br>
                            
                            <select class="form-control " name="jenisbiaya_id" id="jenisbiaya_id" >
                    
                                @foreach ($jenisbiaya as $item)
                                    <option value="{{$item->id}}">{{$item->nama}}</option>          
                                @endforeach
                    
                            </select>                            
                            
                            @error('jenisbiaya_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" id="fakturpenjualan_id" name="fakturpenjualan_id" value="{{$fakturId}}">
                        
                        <div class="form-group">
                            <label>Nominal :</label>
                            <input type="number" name="nominal" id="nominal" value="{{ old('nominal') ? $biayalain->nominal : ''}}"
                                class="form-control @error('nominal') is-invalid @enderror" placeholder="Masukkan Nominal Biaya" />
                            @error('nominal')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <label>Keterangan :</label>
                            <input type="text" name="keterangan" id="keterangan" value="{{ old('keterangan') ? $biayalain->keterangan : ''}}"
                                class="form-control" placeholder="Keterangan" />
                            @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    </div>
                    
                    <div class="card-footer text-right">
                        <div class="row">
                            <div class="col-lg-12 ">
                                <button type="button" onclick="javascript:store();" class="btn btn-success font-weight-bold mr-2"><i class="flaticon2-paperplane"></i>
                                   Submit</button>
                                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
          </form>
      </div>
    </div>
  </div>