<div class="card-body">
    <div class="form-group">
        <label>Role Name:</label>
        <input type="text" name="name" id="name" value="{{ old('name') ?? $role->name }}" required
            class="form-control  @error('name') ? is-invalid @enderror" placeholder="Enter role name" />
        <span class="form-text text-muted">Please enter role name</span>
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label>Guard Name:</label>
        <input type="text" value="{{ old('guard_name') ?? $role->guard_name }}" id="guard_name" name="guard_name"
            class="form-control " placeholder="Enter Guard Name" />
        <span class="form-text text-muted">Please enter guard name, default guard name is :
            'web'</span>
    </div>

</div>
<div class="card-footer text-right">
    <button type="submit" class="btn btn-primary mr-2">{{ $submit }}</button>
    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
</div>