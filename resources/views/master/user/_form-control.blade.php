<div class="card-body">

    <div class="separator separator-dashed my-5"></div>
    <div class="form-group">
        <label>Nama *:</label>
        <input type="text" name="name" value="{{ old('name') ?? $user->name }}"
            class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan name user" />
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="separator separator-dashed my-5"></div>
    <div class="form-group">
        <label>Email *:</label>
        <input type="text" @if($submit=="Update" ) disabled="disabled" @endif name="email"
            value="{{ old('email') ?? $user->email }}" class="form-control @error('email') is-invalid @enderror"
            placeholder="Masukkan email user" />
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    @if($submit <> "Update")
        <div class="separator separator-dashed my-5"></div>
        <div class="form-group">
            <label>Password *:</label>
            <input type="text" name="password" value="{{ old('password') ?? $user->password }}"
                class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password user" />
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="separator separator-dashed my-5"></div>
        <div class="form-group">
            <label>Password Confirmation *:</label>
            <input type="text" name="password_confirmation"
                value="{{ old('password_confirmation') ?? $user->password_confirmation }}"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                placeholder="Masukkan password confirmation user" />
            @error('password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @endif
        <div class="separator separator-dashed my-5"></div>
        <div class="form-group">
            <label>Role *:</label>
            <select class="form-control select2" id="select2" name="role_id">
                <option value="">Pilih Role</option>
                @foreach ($roles as $cg)
                @if($cg->name == $role)
                <option selected="selected" value="{{ $cg->id }}">{{ $cg->name }}</option>
                @else
                <option value="{{ $cg->id }}">{{ $cg->name }}</option>
                @endif

                @endforeach
            </select>
            @error('password_confirmation')
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
            <a href="{{ route('user.index') }}" class="btn btn-secondary font-weight-bold mr-2">
                Cancel</a>
        </div>
    </div>
</div>