<div>
    <form wire:submit="save" class="needs-validation form-horizontal" wire:ignore.self>
        <div class="row">
            <div class="col-md">
                <label for="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name"
                    id="name" placeholder="Department Name">

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md" wire:ignore>
                <label for="form-label">Site</label>
                <select class="form-select select2 select-site" wire:model="site_id" data-placeholder="Select Site">
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

            <div class="col-md" wire:ignore>
                <label for="form-label">Supervisor</label>
                <select class="form-select select2 select-supervisor" wire:model="supervisor_id"
                    data-placeholder="Select Supervisor">
                    <option></option>
                    @foreach ($employees as $supervisor)
                        <option value="{{ $supervisor->id }}">{{ $supervisor->user->name }}</option>
                    @endforeach
                </select>

                @error('supervisor_id')
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


    @push('js')
        <script>
            document.addEventListener('livewire:init', function() {
                $('.select2').select2();
                $('.select-supervisor').on('change', function() {
                    @this.set('supervisor_id', this.value);
                });

                $('.select-site').on('change', function() {
                    @this.set('site_id', this.value);
                });

                Livewire.on('change-status-form', () => {
                    $('.select-site').val(@this.site_id).trigger('change');
                    $('.select-supervisor').val(@this.supervisor_id).trigger('change');
                });

                Livewire.on('refreshIndex', () => {
                    $('.select-supervisor').val(null).trigger('change');
                    $('.select-site').val(null).trigger('change');
                })
            });
        </script>
    @endpush
</div>
