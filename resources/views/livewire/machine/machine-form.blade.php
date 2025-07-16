<div>
    <form wire:submit="save" class="needs-validation form-horizontal" wire:ignore.self>
        <div class="row">
            <div class="col-md">
                <label for="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name"
                    id="name" placeholder="Machine Name">

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md" wire:ignore>
                <label for="form-label">Site Name</label>
                <select class="form-select select2 select-site" wire:model="site_id"
                    data-placeholder="Select Site">
                    <option></option>
                    @foreach ($sites as $site)
                        <option value="{{ $site->id }}">{{ $site->name }}</option>
                    @endforeach
                </select>

                @error('site_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md">
                <label for="form-label">IP Address</label>
                <input type="text" class="form-control @error('ip_address') is-invalid @enderror"
                    wire:model="ip_address" placeholder="IP Address">

                @error('ip_address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-1">
                <label for="form-label">Port</label>
                <input type="text" class="form-control @error('port') is-invalid @enderror" wire:model="port"
                    placeholder="Port">

                @error('port')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-1">
                <label for="form-label">COM Key</label>
                <input type="text" class="form-control @error('comkey') is-invalid @enderror" wire:model="comkey"
                    placeholder="COM Key">

                @error('comkey')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md">
                <label for="form-label">Password</label>
                <input type="text" class="form-control @error('password') is-invalid @enderror" wire:model="password"
                    placeholder="Password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md" wire:ignore>
                <label for="form-label">Machine Type</label>
                <select class="form-select select2 select-machine-type" wire:model="machine_type_id"
                    data-placeholder="Select Machine Type">
                    <option></option>
                    @foreach ($machineTypes as $machine_type)
                        <option value="{{ $machine_type->id }}">{{ $machine_type->name }}</option>
                    @endforeach
                </select>

                @error('machine_type_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-sm btn-primary mt-3">Submit</button>
        {{-- Button Clear --}}
        <button type="button" class="btn btn-sm btn-danger mt-3" wire:click="resetFormFields()">Clear</button>
    </form>
</div>

@push('styles')
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js')
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script>
        document.addEventListener('livewire:init', function() {
            $('.select2').select2();
            $('.select-machine-type').on('change', function() {
                @this.set('machine_type_id', this.value);
            });

            $('.select-site').on('change', function() {
                @this.set('site_id', this.value);
            });

            Livewire.on('change-status-form', () => {
                $('.select-machine-type').val(@this.machine_type_id).trigger('change');
                $('.select-site').val(@this.site_id).trigger('change');
            });

            Livewire.on('refreshIndex', () => {
                $('.select-machine-type').val(null).trigger('change');
                $('.select-site').val(null).trigger('change');
            })
        });
    </script>
@endpush
