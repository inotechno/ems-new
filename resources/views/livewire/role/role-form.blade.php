<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Role', 'url' => route('role.index')], ['name' => $mode == 'create' ? 'Create Role' : 'Edit Role ' . $role->name]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Form {{ $mode == 'create' ? 'Create Role' : 'Edit Role ' . $role->name }}</h4>

                    <form wire:submit="save" class="needs-validation form-horizontal" wire:ignore.self>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        wire:model="name" id="name" placeholder="Role Name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="form-label">Permissions</label>
                                {{-- Buat Checkbox Permissions --}}
                                <div class="permission-list">
                                    @foreach ($groupedPermissions as $group => $permissions)
                                        <div class="permission-group my-3">
                                            <h4>{{ ucfirst($group) }}</h4>
                                            <div class="row">
                                                @foreach ($permissions as $permission)
                                                    <div class="col-md-3 mb-1">
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input @error('selectedPermissions') is-invalid @enderror"
                                                                type="checkbox" id="{{ $permission }}"
                                                                wire:model.live="selectedPermissions"
                                                                value="{{ $permission }}">
                                                            <label class="form-check-label" for="{{ $permission }}">
                                                                {{ ucfirst(explode(':', $permission)[1]) }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        {{-- Button Clear --}}
                        <button type="button" class="btn btn-danger mt-3" wire:click="resetFormFields()">Clear</button>
                        {{-- Cancel --}}
                        <a href="{{ route('role.index') }}" class="btn btn-secondary mt-3">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
