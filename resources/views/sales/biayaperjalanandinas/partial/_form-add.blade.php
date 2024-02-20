<div class="card-body">
    <div class="form-group row">
        <label class="col-lg-1 col-form-label text-right">Nama Karyawan:</label>
        <div class="col-lg-4">
            <input type="text" name="nama_lab" class="form-control" value="{{ $karyawan->nama }}" readonly>

        </div>
        <label class="col-lg-2 col-form-label text-right">NIK:</label>
        <div class="col-lg-4">
            <div class="input-group date">
                <input type="text" name="pemohon" class="form-control" value="{{ $karyawan->nip }}" readonly>
            </div>

        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-1 col-form-label text-right">Keterangan:</label>
        <div class="col-lg-4">
            <input type="text" name="keterangan" class="form-control" value="{{ $biayadinas->keterangan }}">

            @error('keterangan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <input type="hidden" name="dinas_id" value="{{ $id }}">
    <div class="row justify-content-between">
        <div>
            <button type="button" class="btn btn-sm btn-danger "><i class="fas fa-volume-up"></i> Biaya Akomodasi
            </button>
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
                            <th style="width: 10%">Tanggal</th>
                            <th style="width: 15%">Dari</th>
                            <th style="width: 15%;">Ke</th>
                            <th style="width: 15%">Waktu Mulai - Selesai</th>
                            <th style="width: 15%">Jenis Transportasi</th>
                            <th style="width: 15%">Penyedia Transportasi</th>
                            <th style="width: 10%">Waktu Berangkat</th>
                            <th style="width: 10%">Nama Hotel</th>
                            <th style="width: 5%">Aksi</th>
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
            <button type="button" class="btn btn-sm btn-danger"><i class="fas fa-volume-up"></i> Kas Bon </button>
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
                            <th>Tanggal Kas Bon</th>
                            <th>Nominal</th>
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
            <a href="{{ route('biayaperjalanandinas.print', ['id' => $biayadinas->id]) }}" class="btn btn-primary " target="_blank">
                <i class="flaticon2-print font-weight-bold"></i> Download & Print
            </a>
            <button type="submit" class="btn btn-success font-weight-bold mr-2"><i class="flaticon2-paperplane"></i>
                Save</button>
            <a href="{{ route('perjalanandinas.index') }}" class="btn btn-secondary font-weight-bold mr-2">
                Cancel</a>
        </div>
    </div>
</div>
