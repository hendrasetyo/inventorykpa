<div class="card-body">

    <div class="form-group">
        <label>Nama :</label>
        <input type="text" name="nama" value="{{ old('nama') ?? $sales->nama }}"
            class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan Nama Salesman" />
        @error('nama')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class=" form-group">
        <label>Email :</label>
        <input type="email" name="email" value="{{ old('email') ?? $sales->email }}"
            class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email Salesman" />
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <span class="form-text text-muted">Email digunakan untuk notifikasi.</span>
    </div>

    <div class="form-group">
        <label>No. HP :</label>
        <input type="text" name="hp" value="{{ old('hp') ?? $sales->hp }}" class="form-control"
            placeholder="Masukkan No. HP Salesman" />
        @error('hp')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label>NIP :</label>
        <input type="text" name="nip" value="{{ old('nip') ?? $sales->nip }}" class="form-control"
            placeholder="Masukkan NIP Salesman" />
        @error('nip')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label>Keterangan :</label>
        <input type="text" name="keterangan" value="{{ old('keterangan') ?? $sales->keterangan }}" class="form-control"
            placeholder="Keterangan" />
        @error('keterangan')
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
            <a href="{{ route('sales.index') }}" class="btn btn-secondary font-weight-bold mr-2">
                Cancel</a>
        </div>
    </div>
</div>