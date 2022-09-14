<div class="card-body">
    <div class="form-group row">
        <div class="col-lg-6">
            <label>Parent :</label>
            <select class="form-control select2" id="kt_select2_2" name="parent_id" required>
                <option selected disabled>Choose a parent</option>
                @foreach ($parents as $parent)
                @if ($navigation->parent_id == $parent->id)
                <option selected="selected" value="{{ $parent->id }}">{{ $parent->name }}</option>
                @else
                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                @endif

                @endforeach
            </select>
        </div>
        <div class="col-lg-6">
            <label>Permission :</label>
            <select class="form-control select2" id="kt_select2_1" name="permission_name" required>
                <option selected disabled>Choose a permission</option>
                @foreach ($permissions as $permission)
                @if ($navigation->permission_name == $permission->name)
                <option selected="selected" value="{{ $permission->name }}">{{ $permission->name }}</option>
                @else
                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                @endif

                @endforeach
            </select>
            @error('permission_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <span class="form-text text-muted">Please enter permission</span>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-6">
            <label>Name :</label>
            <div class="input-group">
                <input type="text" name="name" class="form-control" value="{{ old('name') ?? $navigation->name }}"
                    placeholder="Enter Name"  required />
            </div>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <span class="form-text text-muted">Please enter your name</span>

        </div>
        <div class="col-lg-6">
            <label>URL:</label>
            <div class="input-group">
                <input type="text" name="url" value="{{ old('url') ?? $navigation->url }}" class="form-control"
                    placeholder="Enter your URL" />
                <div class="input-group-append"><span class="input-group-text"><i class="la la-bookmark-o"></i></span>
                </div>
            </div>
            <span class="form-text text-muted">Please enter your URL</span>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-6">
            <label>Menu Icon :</label>
            <div class="input-group">
                <input type="text" name="icon" value="{{ old('icon') ?? $navigation->icon }}" class="form-control"
                    placeholder="Enter Icon" required />
            </div>
            @error('icon')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <span class="form-text text-muted">Please enter your icon</span>

        </div>
        <div class="col-lg-6">
            <label>No. Priority :</label>
            <div class="input-group">
                <input type="number" name="urut" value="{{ old('urut') ?? $navigation->urut }}" class="form-control"
                    placeholder="Enter Number" required />
            </div>
            @error('urut')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <span class="form-text text-muted">This is for sorting navigations</span>

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
            <a href="{{ route('navigation.index') }}" class="btn btn-secondary font-weight-bold mr-2">
                Cancel</a>
        </div>
    </div>
</div>