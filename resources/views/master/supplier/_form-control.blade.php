<div class="card-body">

    <div class="form-group">
        <label>Kategori Supplier *:</label>
        <select class="form-control select2" id="kategori_id" name="kategori_id">
            <option value="">Pilih Kategori supplier</option>
            @foreach ($suppliercategory as $cg)
            @if ($supplier->kategori_id == $cg->id)
            <option selected="selected" value="{{ $cg->id }}">{{ $cg->nama }}</option>
            @else
            <option value="{{ $cg->id }}">{{ $cg->nama }}</option>
            @endif

            @endforeach
        </select>
        @error('kategori_id')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="separator separator-dashed my-5"></div>
    <div class="form-group">
        <label>Nama *:</label>
        <input type="text" name="nama" value="{{ old('nama') ?? $supplier->nama }}"
            class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan Nama Kategori supplier" />
        @error('nama')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="separator separator-dashed my-5"></div>
    <div class="form-group">
        <label>Alamat *:</label>
        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"
            placeholder="Masukkan Alamat supplier">{{ old('alamat') ?? $supplier->alamat }}</textarea>
        @error('alamat')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="separator separator-dashed my-5"></div>

    <div class="form-group row">
        <div class="col-lg-3">
            <label>Blok :</label>
            <input type="text" name="blok" class="form-control @error('blok') is-invalid @enderror"
                value="{{ old('blok') ?? $supplier->blok }}" />
            @error('blok')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-lg-3">
            <label>Nomor :</label>
            <input type="text" class="form-control @error('nomor') is-invalid @enderror" name="nomor"
                value="{{ old('nomor') ?? $supplier->nomor }}" />
            @error('nomor')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-lg-3">
            <label>RT :</label>
            <input type="text" class="form-control @error('rt') is-invalid @enderror" name="rt"
                value="{{ old('rt') ?? $supplier->rt }}" />
            @error('rt')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-lg-3">
            <label>RW :</label>
            <input type="text" class="form-control @error('rw') is-invalid @enderror" name="rw"
                value="{{ old('rw') ?? $supplier->rw }}" />
            @error('rw')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="separator separator-dashed my-5"></div>
    <div class="form-group row">
        <div class="col-lg-3">
            <label>Provinsi *:</label>
            <select class="form-control select2" id="provinsi" name="provinsi">
                <option value="">Pilih Provinsi</option>
                @foreach ($provinces as $id => $name)
                @if ($supplier->provinsi == $id)
                <option selected="selected" value="{{ $id }}">{{ $name }}</option>
                @else
                <option value="{{ $id }}">{{ $name }}</option>
                @endif
                @endforeach
            </select>
            @error('provinsi')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-lg-3">
            <label>Kota *:</label>
            <select class="form-control select2" id="kota" name="kota">
                <option value="">Pilih Kota/Kabupaten</option>
                @foreach ($kota as $kotax)
                @if ($supplier->kota == $kotax->id)
                <option selected="selected" value="{{ $kotax->id }}">{{ $kotax->name }}</option>
                @else
                <option value="{{ $kotax->id }}">{{ $kotax->name }}</option>
                @endif
                @endforeach
            </select>
            @error('kota')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-lg-3">
            <label>Kecamatan *:</label>
            <select class="form-control select2" id="kecamatan" name="kecamatan">
                @foreach ($kecamatan as $kec)
                @if ($supplier->kecamatan == $id)
                <option selected="selected" value="{{ $kec->id }}">{{ $kec->name }}</option>
                @else
                <option value="{{ $kec->id }}">{{ $kec->name }}</option>
                @endif
                @endforeach
            </select>
            @error('kecamatan')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-lg-3">
            <label>Kelurahan *:</label>
            <select class="form-control select2" id="kelurahan" name="kelurahan">
                @foreach ($kelurahan as $kel)
                @if ($supplier->kelurahan == $kel->id)
                <option selected="selected" value="{{ $kel->id }}">{{ $kel->name }}</option>
                @else
                <option value="{{ $kel->id }}">{{ $kel->name }}</option>
                @endif
                @endforeach
            </select>
            @error('kelurahan')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="separator separator-dashed my-5"></div>
    <div class="form-group row">
        <div class="col-lg-3">
            <label>Kode Pos :</label>
            <input type="text" name="kodepos" class="form-control @error('kodepos') is-invalid @enderror"
                value="{{ old('kodepos') ?? $supplier->kodepos }}" />
            @error('kodepos')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-lg-3">
            <label>Email :</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') ?? $supplier->email }}" />
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-lg-3">
            <label>Telepon :</label>
            <input type="text" class="form-control @error('tlp') is-invalid @enderror" name="tlp"
                value="{{ old('tlp') ?? $supplier->telepon }}" />
            @error('tlp')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-lg-3">
            <label>NPWP *:</label>
            <input type="text" class="form-control @error('npwp') is-invalid @enderror" name="npwp"
                value="{{ old('npwp') ?? $supplier->npwp }}" />
            @error('npwp')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="separator separator-dashed my-5"></div>
    <div class="form-group">
        <label>Keterangan :</label>
        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3"
            placeholder="Masukkan keterangan supplier">{{ old('keterangan') ?? $supplier->keterangan }}</textarea>
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
            <a href="{{ route('supplier.index') }}" class="btn btn-secondary font-weight-bold mr-2">
                Cancel</a>
        </div>
    </div>
</div>