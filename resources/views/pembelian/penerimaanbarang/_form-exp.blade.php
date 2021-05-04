<div class="card-body">
    <div class="form-group ">
        <label>Tanggal :</label>
        <div class="input-group date">
            <input type="text" class="form-control col-lg-3" name="tanggal" readonly value="" id="tgl1" />
            <div class="input-group-append">
                <span class="input-group-text">
                    <i class="la la-calendar"></i>
                </span>
            </div>
        </div>
        @error('tanggal')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label>Qty :</label>
        <input type="number" name="qty" value="" class="form-control @error('qty') is-invalid @enderror" />
        @error('qty')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>

</div>
<!--end::Form-->
<div class="card-footer text-right">
    <div class="row">
        <div class="col-lg-12 ">
            <button type="submit" class="btn btn-success font-weight-bold mr-2"><i class="flaticon2-paperplane"></i>
                {{ $submit }}</button>
            <a href="{{ route('penerimaanbarang.setexp', $penerimaanbarangdetail) }}"
                class="btn btn-secondary font-weight-bold mr-2">
                Cancel</a>
        </div>
    </div>
</div>