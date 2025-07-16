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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="title">Title <span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('title') is-invalid @enderror" id="title"
                                                name="title" wire:model="title">

                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="amount">Amount <span class="text-danger">*</span></label>
                                            <input type="number"
                                                class="form-control @error('amount') is-invalid @enderror"
                                                id="amount" name="amount" wire:model="amount">

                                            @error('amount')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="financial_type_id" class="mb-3">Request Type <span
                                            class="text-danger">*</span></label>

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
                                    <label for="notes" class="form-label">Notes</label>
                                    <div id="toolbar-container">
                                        <span class="ql-formats">
                                            <select class="ql-font"></select>
                                            <select class="ql-size"></select>
                                        </span>
                                        <span class="ql-formats">
                                            <button class="ql-bold"></button>
                                            <button class="ql-italic"></button>
                                            <button class="ql-underline"></button>
                                            <button class="ql-strike"></button>
                                        </span>
                                        <span class="ql-formats">
                                            <select class="ql-color"></select>
                                            <select class="ql-background"></select>
                                        </span>
                                        <span class="ql-formats">
                                            <button class="ql-script" value="sub"></button>
                                            <button class="ql-script" value="super"></button>
                                        </span>
                                        <span class="ql-formats">
                                            <button class="ql-header" value="1"></button>
                                            <button class="ql-header" value="2"></button>
                                            <button class="ql-blockquote"></button>
                                            <button class="ql-code-block"></button>
                                        </span>
                                        <span class="ql-formats">
                                            <button class="ql-list" value="ordered"></button>
                                            <button class="ql-list" value="bullet"></button>
                                            <button class="ql-indent" value="-1"></button>
                                            <button class="ql-indent" value="+1"></button>
                                        </span>
                                        <span class="ql-formats">
                                            <button class="ql-direction" value="rtl"></button>
                                            <select class="ql-align"></select>
                                        </span>
                                        <span class="ql-formats">
                                            <button class="ql-link"></button>
                                            <button class="ql-image"></button>
                                            <button class="ql-video"></button>
                                            <button class="ql-formula"></button>
                                        </span>
                                        <span class="ql-formats">
                                            <button class="ql-clean"></button>
                                        </span>
                                    </div>

                                    <div wire:ignore>
                                        <div id="editor-container"></div>
                                        <textarea id="notes" wire:model.defer="notes" class="d-none"></textarea>
                                    </div>

                                    @error('notes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3" wire:ignore>
                                    <label for="recipients" class="form-label">To Recipients <span class="text-danger">*</span></label>
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

                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="mb-3">Receipt Image</label>

                                        <input type="file"
                                            class="form-control @error('image') is-invalid @enderror" id="image"
                                            wire:model="image">
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
                                                    class="border rounded" style="object-fit: cover" width="100%"
                                                    height="350">
                                            @else
                                                <img src="{{ $previewImage }}" alt="Preview Image" img-fluid
                                                    class="border rounded" width="100%"
                                                    height="350">
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
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css"
            rel="stylesheet">
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

        <script>
            document.addEventListener('livewire:init', function() {
                let selectElement = $('.select2-multiple');

                const quill = new Quill('#editor-container', {
                    theme: 'snow',
                    modules: {
                        syntax: true,
                        toolbar: {
                            container: '#toolbar-container',
                            handlers: {
                                image: function() {
                                    const range = quill.getSelection();
                                    const input = document.createElement('input');
                                    input.setAttribute('type', 'file');
                                    input.setAttribute('accept', 'image/*');
                                    input.click();

                                    input.onchange = () => {
                                        const file = input.files[0];
                                        const formData = new FormData();
                                        formData.append('image', file);
                                        formData.append('_token', document.querySelector(
                                            'meta[name="csrf_token"]').getAttribute('value'));

                                        fetch('/upload-image', {
                                                method: 'POST',
                                                notes: formData
                                            })
                                            .then(response => response.json())
                                            .then(result => {
                                                const url = result.url;
                                                quill.insertEmbed(range.index, 'image', url);
                                            })
                                            .catch(error => {
                                                console.error('Error:', error);
                                            });
                                    };
                                },
                            },
                        },
                    }
                });

                // Set initial content if available
                var notesContent = document.getElementById('notes').value;
                if (notesContent) {
                    quill.root.innerHTML = notesContent;
                }

                // Update Livewire property on Quill editor content change
                quill.on('text-change', function() {
                    @this.set('notes', quill.root.innerHTML);

                    Livewire.dispatch('previewContent', {
                        content: quill.root.innerHTML
                    });
                });

                Livewire.on('contentChanged', (notes) => {
                    quill.root.innerHTML = notes;
                });

                selectElement.select2({
                    width: '100%',
                }).on('change', function() {
                    let selectedValues = $(this).val();
                    // console.log(selectedValues);
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
