<div wire:ignore>
    <div class="modal fade" id="modalAddEmployee" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Select Employee</label>
                            {{-- Select Multiple Employee Select2 --}}
                            <select class="form-control select2-multiple" wire:model="employee_id"
                                data-placeholder="Choose ..." multiple>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                @endforeach
                            </select>

                            @error('employee_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div>
                            <button type="button" class="btn btn-primary mt-3" wire:click="store" wire:loading.attr="disabled">Save</button>
                            <button type="button" class="btn btn-danger mt-3"
                                wire:click="$dispatch('close-modal-add-employee')">Clear</button>
                        </div>

                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            document.addEventListener('livewire:init', function() {
                let selectElement = $('.select2-multiple');

                function initSelect2() {
                    selectElement.select2({
                        dropdownParent: $('#modalAddEmployee'),
                        width: '100%',
                    }).on('change', function(e) {
                        let selectedValues = $(this).val();
                        @this.set('employee_id', selectedValues);
                    });
                }

                Livewire.on('open-modal-add-employee', () => {
                    initSelect2();
                    $('#modalAddEmployee').modal('show');
                });

                Livewire.on('close-modal-add-employee', () => {
                    // Clear and hide the modal, and reset Select2
                    selectElement.val(null).trigger('change');
                    $('#modalAddEmployee').modal('hide');
                });
            });
        </script>
    @endpush
</div>
