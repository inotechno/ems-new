<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Financial Request', 'url' => route('financial-request.index')], ['name' => $mode == 'Create' ? 'Create' : 'Edit Financial Request ']]], key('breadcrumb'))


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">
                        {{ $mode == 'Create' ? 'Create Financial Request' : 'Edit Financial Request' }}
                    </h4>

                    <form wire:submit.prevent="save" class="needs-validation" id="financial-request-form">
                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="notes" class="mb-3">Note</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" wire:model="notes"
                                        rows="3"></textarea>

                                    @error('notes')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="financial_type_id" class="mb-3">Request Type</label>

                                    <div class="d-flex gap-3">
                                        @foreach ($financial_types as $type)
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="financial_type_id"
                                                    id="financial_type_id{{ $type->id }}" checked=""
                                                    wire:model="financial_type_id" value="{{ $type->id }}">
                                                <label class="form-check-label"
                                                    for="financial_type_id{{ $type->id }}">
                                                    {{ $type->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    @error('type_financial')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3" wire:ignore>
                                    <label for="recipients" class="form-label">To Recipients</label>
                                    <select name="recipients" wire:model="recipients"
                                        class="form-select select2-multiple" id="" multiple
                                        data-placeholder="Select recipients">
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('recipients')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="mb-3">Receipt Image</label>

                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                            id="image" wire:model="image">
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row" wire:ignore.self>
                                    <div class="col-md-12">
                                        <label for="previewImage"
                                            class="form-label mt-3">{{ __('Preview Image') }}</label>

                                        <span wire:loading wire:target="image"
                                            class="spinner-border spinner-border-sm"></span>
                                        <div class="text-center">
                                            @if ($image)
                                                <img src="{{ $image->temporaryUrl() }}" alt="Preview Image"
                                                    class="object-fit-scale border rounded" width="100%"
                                                    height="250">
                                            @else
                                                <img src="{{ $previewImage }}" alt="Preview Image" img-fluid
                                                    class="object-fit-scale border rounded" width="100%"
                                                    height="250">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                                    wire:target="save">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

        <script>
            document.addEventListener('livewire:init', function() {
                let selectElement = $('.select2-multiple');

                selectElement.select2({
                    width: '100%',
                }).on('change', function() {
                    let selectedValues = $(this).val();
                    Livewire.dispatch('change-input-form', ['recipients', selectedValues]);
                });

                Livewire.on('set-default-form', () => {
                    var recipients = @json($recipients);
                    selectElement.val(recipients).trigger('change');
                })
            });
        </script>
    @endpush
</div>
