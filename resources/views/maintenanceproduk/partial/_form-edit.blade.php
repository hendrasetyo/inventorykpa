<div class="card-body">
    <div class="form-group row">
        <label class="col-lg-1 col-form-label text-right">LAB/RS:</label>
        <div class="col-lg-4">
            <input type="text" name="nama_lab" class="form-control" value="{{$maintenance->nama_lab}}" placeholder="Masukan Nama Lab/RS">
           
            @error('nama_lab')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <label class="col-lg-2 col-form-label text-right">Pemohon:</label>
        <div class="col-lg-4">
            <div class="input-group date">
                <input type="text" name="pemohon" value="{{$maintenance->pemohon}}" class="form-control" placeholder="Masukan Nama Pemohon">
            </div>   
            
            @error('pemohon')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-1 col-form-label text-right">Telepon:</label>
        <div class="col-lg-4">
            <div class="input-group date">
                <input type="text" name="telepon" value="{{$maintenance->telepon}}" class="form-control" placeholder="Masukan No Telepon">
            </div>            
        </div>
        <label class="col-lg-2 col-form-label text-right">Bagian:</label>
        <div class="col-lg-4">
            <div class="input-group date">
                <input type="text" name="bagian" value="{{$maintenance->bagian}}" class="form-control"  placeholder="Masukan Nama Bagian"/>
            </div>  
            
            @error('bagian')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-1 col-form-label text-right">Tanggal :</label>
        <div class="col-lg-4">
            <div class="input-group date">
                <input type="text" name="tanggal" class="form-control"  readonly value="{{ $maintenance->tanggal ? \Carbon\Carbon::parse($maintenance->tanggal)->format('d-m-Y') :  now()->format('d-m-Y')}}" id="tgl1" required/>
            </div>            
        </div>
        <label class="col-lg-2 col-form-label text-right">Alamat:</label>
        <div class="col-lg-4">
            <textarea name="alamat" class="form-control" id="" cols="30" rows="5">{{$maintenance->alamat}}</textarea>
           
            @error('alamat')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    

    <div class="row justify-content-between">
        <div>
            <button type="button" class="btn btn-sm btn-danger "><i class="fas fa-volume-up"></i> Sebelum Tindakan</button>
        </div>
        <div class=" mb-3">
            <a href="javascript:modalbefore()" class="btn btn-sm btn-primary"><i class="flaticon2-add"></i>Tambah Data</a>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-12">
            <div id="tabel_detil_before" class="table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Alat</th>
                            <th>No Seri</th>
                            <th>Keluhan/Keperluan</th>
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
    <div class="mt-10 form-group row">
        <label class="col-lg-1 col-form-label text-right">Lokasi Pengerjaan</label>
        <div class="col-lg-4">
            <select class="form-control select2"   name="lokasi_pengerjaan" id="kt_select2_1" required>
                <option value="Dikerjakan di Tempat">Dikerjakan di Tempat</option>
                <option value="Dikerjakan di Workshop">Dikerjakan di Workshop</option>
            </select>
            @error('lokasi_pengerjaan')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror          
        </div>
        <label class="col-lg-1 col-form-label text-right">Tanggal Pengerjaan</label>
        <div class="col-lg-4">
            <div class="input-group  date">
                <input type="text" name="tanggal_pengerjaan" class="form-control" placeholder="Top left" id="kt_datepicker_4_1"   value="{{ $maintenance->tanggal_dikerjakan ? \Carbon\Carbon::parse($maintenance->tanggal_dikerjakan)->format('d/m/Y') :  now()->format('d/m/Y')}} " required/>
            </div>            
        </div>
    </div>

    

    <div class=" mb-10 form-group row">
        <label class="col-lg-1 col-form-label text-right"></label>
        <div class="col-lg-4">
        </div>
        <label class="col-lg-1 col-form-label text-right">Tanggal Selesai Pengerjaan</label>
        <div class="col-lg-4">
            <div class="input-group date">        
                <input type="text" name="tanggal_selesai_pengerjaan" class="form-control" placeholder="Top left" id="kt_datepicker_4_2"   value="{{ $maintenance->tanggal_selesai_dikerjakan ? \Carbon\Carbon::parse($maintenance->tanggal_selesai_dikerjakan)->format('d/m/Y') :  now()->format('d/m/Y')}}" required/>
            </div>            
        </div>
    </div>

    <hr>
    <div class="row justify-content-between">
        <div>
            <button type="button" class="btn btn-sm btn-success"><i class="fas fa-volume-up"></i> Setelah Tindakan</button>
        </div>
        <div class=" mb-3">
            <a href="javascript:modalafter()" class="btn btn-sm btn-primary"><i class="flaticon2-add"></i>Tambah Data</a>
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-lg-12">
            <div id="tabel_detil_after" class="table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Sparepart</th>
                            <th>Qty</th>
                            <th>Pekerjaan/Penyeleseian</th>
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
    <div class="form-group row">
        <div class="col-lg-6">
            <label class="">Saran:</label>
            <div class="kt-input-icon kt-input-icon--right">
                <textarea class="form-control" name="saran" id="keterangan">{{$maintenance->saran}}</textarea>
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