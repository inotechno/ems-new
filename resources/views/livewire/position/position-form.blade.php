<div>
    <form wire:submit="save" class="needs-validation form-horizontal" wire:ignore.self>
        <div class="row">
            <div class="col-md">
                <label for="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name"
                    id="name" placeholder="Position Name">

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md" wire:ignore>
                <label for="form-label">department</label>
                <select class="form-select select2 select-department" wire:model="department_id" data-placeholder="Select Department">
                    <option></option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }} | {{ $department->site->name }}</option>
                    @endforeach
                </select>

                @error('department_id')
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
                $('.select-department').on('change', function() {
                    @this.set('department_id', this.value);
                });

                Livewire.on('change-status-form', () => {
                    $('.select-department').val(@this.department_id).trigger('change');
                });

                Livewire.on('refreshIndex', () => {
                    $('.select-department').val(null).trigger('change');
                })
            });
        </script>
    @endpush
</div>
