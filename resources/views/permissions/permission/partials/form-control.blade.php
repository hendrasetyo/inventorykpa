<div class="card-body">
    <div class="form-group">
        <label>Permissions Name:</label>
        <input type="text" name="name" id="name" value="{{ old('name') ?? $permission->name }}" required
            class="form-control  @error('name') ? is-invalid @enderror" placeholder="Enter permission name" />
        <span class="form-text text-muted">Please enter permission name</span>
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label>Guard Name:</label>
        <input type="text" value="{{ old('guard_name') ?? $permission->guard_name }}" id="guard_name" name="guard_name"
            class="form-control " placeholder="Enter Guard Name" />
        <span class="form-text text-muted">Please enter guard name, default guard name is :
            'web'</span>
    </div>

</div>
<div class="card-footer text-right">
    <button type="submit" class="btn btn-primary mr-2">{{ $submit }}</button>
    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
</div>