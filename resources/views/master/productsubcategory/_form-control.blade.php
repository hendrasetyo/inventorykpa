<div class="card-body">

    <div class="form-group">
        <label>Nama :</label>
        <input type="text" name="nama" value="{{ old('nama') ?? $productsubcategory->nama }}"
            class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan Nama Kategori Customer" />
        @error('nama')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Kategori :</label>
        <select class="form-control select2" id="select2" name="productcategory_id">
            <option value="">Pilih Kategori</option>
            @foreach ($productcategories as $cg)
            @if ($productsubcategory->productcategory_id == $cg->id)
            <option selected="selected" value="{{ $cg->id }}">{{ $cg->nama }}</option>
            @else
            <option value="{{ $cg->id }}">{{ $cg->nama }}</option>
            @endif

            @endforeach
        </select>
        @error('productcategory')
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
            <a href="{{ route('productsubcategory.index') }}" class="btn btn-secondary font-weight-bold mr-2">
                Cancel</a>
        </div>
    </div>
</div>