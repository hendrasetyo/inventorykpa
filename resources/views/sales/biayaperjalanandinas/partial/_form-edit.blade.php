<div class="card-body">
    <div class="form-group row">
        <label class="col-lg-1 col-form-label text-right">Nama Karyawan:</label>
        <div class="col-lg-4">
            <input type="text" name="nama_lab" class="form-control" value="{{ $karyawan->nama }}" readonly>

            @error('nama_lab')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <label class="col-lg-2 col-form-label text-right">NIK:</label>
        <div class="col-lg-4">
            <div class="input-group date">
                <input type="text" name="pemohon" class="form-control" value="{{ $karyawan->nip }}" readonly>
            </div>

            @error('pemohon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-1 col-form-label text-right">Tujuan Perjalanan :</label>
        <div class="col-lg-4"> 
            <input type="text" name="tujuan_perjalanan" class="form-control" value="{{$dinas->tujuan_dinas}}" required>

            @error('tujuan_perjalanan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <label class="col-lg-2 col-form-label text-right">Jabatan:</label>
        <div class="col-lg-4">
            <div class="input-group date">
                <input type="text" name="bagian" class="form-control" value="{{ $karyawan->jabatan->nama }}"
                    readonly />
            </div>

            @error('bagian')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-1 col-form-label text-right">Keterangan :</label>
        <div class="col-lg-4">
            <div class="input-group date">
                <input type="text" name="keterangan" class="form-control" value="{{$dinas->keterangan}}" required />
            </div>
        </div>
    </div>


    <div class="row justify-content-between">
        <div>
            <button type="button" class="btn btn-sm btn-danger "><i class="fas fa-volume-up"></i> Transportasi dan
                Hotel </button>
        </div>
        <div class=" mb-3">
            <a href="javascript:modalbefore()" class="btn btn-sm btn-primary"><i class="flaticon2-add"></i>Tambah
                Data</a>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-12">
            <div id="tabel_detil" class="table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Dari</th>
                            <th>Ke</th>
                            <th>Waktu</th>
                            <th>Jenis Transportasi</th>
                            <th>Penyedia Transportasi</th>
                            <th>Waktu Keberangkatan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>  

    <hr>
    <div class="row justify-content-between">
        <div>
            <button type="button" class="btn btn-sm btn-danger"><i class="fas fa-volume-up"></i> Entertaintment
                Perjalanan Dinas</button>
        </div>
        <div class=" mb-3">
            <a href="javascript:modalafter()" class="btn btn-sm btn-primary"><i class="flaticon2-add"></i>Tambah
                Data</a>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-12">
            <div id="tabel_detil_after" class="table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>Perusahaan/Institusi</th>
                            <th>Nama</th>
                            <th>Jenis Entertainment</th>
                            <th>Tujuan Entertainment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

</div>
<!--end::Form-->
<div class="card-footer text-right">
    <div class="row">
        <div class="col-lg-12 ">
            <button type="submit" class="btn btn-success font-weight-bold mr-2"><i class="flaticon2-paperplane"></i>
                Save</button>
            <a href="{{ route('maintenanceproduk.index') }}" class="btn btn-secondary font-weight-bold mr-2">
                Cancel</a>
        </div>
    </div>
</div>
