<div class="card-body">
   <div class="form-group row">
        <label class="col-lg-1 col-form-label text-right">Customer:</label>
        <div class="col-lg-4">
            <select class="form-control select2" id="customer_id" name="customer_id" required>
                <option value="">Pilih Customer</option>
                @foreach ($customers as $cg)
                @if ($canvassing->customer_id == $cg->id)
                <option selected="selected" value="{{ $cg->id }}">{{ $cg->nama }}</option>
                @else
                <option value="{{ $cg->id }}">{{ $cg->nama }}</option>
                @endif
                @endforeach
            </select>
            @error('customer_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <label class="col-lg-2 col-form-label text-right">Tanggal:</label>
        <div class="col-lg-4">
            <div class="input-group date">              
                  <input type="text" class="form-control" name="tanggal" readonly value="{{ $tglNow }}" id="tgl1" required/>                    
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="la la-calendar"></i>
                    </span>
                </div>
            </div>            
        </div>
    </div>

    {{-- <div class="form-group row">
        <label class="col-lg-1 col-form-label text-right">No. SO:</label>
        <div class="col-lg-4">
            <input type="text" name="no_so" id="no_so" readonly="readonly" class="form-control"
                value="{{ $canvassing->kode }}" />
        </div>
    </div> --}}

    <div class="text-right mb-3">
        <a href="javascript:caribarang()" class="btn btn-sm btn-primary"><i class="flaticon2-add"></i>Tambah Barang</a>
    </div>
    <div class="form-group row">
        <div class="col-lg-12">
            <div id="tabel_detil" class="table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>Kode barang</th>
                            <th>Nama Barang</th>
                            <th style="width: 5%">Satuan</th>
                            <th style="width: 5%">Qty Canvassing</th>
                            <th style="width: 5%">Qty Sisa</th>
                            <th style="width: 5%">Qty Kirim</th>
                            <th>Keterangan</th>
                            <th>-</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="separator separator-dashed my-5"></div>
    <div class="form-group row">
        <div class="col-lg-6">
            <label class="">Keterangan:</label>
            <div class="kt-input-icon kt-input-icon--right">
                <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
            </div>

        </div>
        <div class="col-lg-6">


        </div>

    </div>


</div>

</div>
<!--end::Form-->
<div class="card-footer text-right">
    <div class="row">
        <div class="col-lg-12 ">
            <button type="submit" class="btn btn-success font-weight-bold mr-2"><i class="flaticon2-paperplane"></i>
                {{ $submit }}</button>
            <a href="{{ route('pengirimanbarang.listso') }}" class="btn btn-secondary font-weight-bold mr-2">
                Cancel</a>
        </div>
    </div>
</div>