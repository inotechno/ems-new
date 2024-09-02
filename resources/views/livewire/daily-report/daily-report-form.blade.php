<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'],
     ['name' => 'Daily Report', 'url' => route('daily-report.index')],
     ['name' => $mode == 'Create' ? 'Create' : 'Edit Daily Report ']]], key('breadcrumb'))


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ $mode == 'Create' ? 'Create Daily Report' : 'Edit Daily Report' }}</h4>

                    <form action="" wire:submit.prevent="save" wire:ignore class="needs-validation"
                        id="daily-report-form">
                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input id="date-daily-report" name="date" wire:model="date" type="date"
                                        class="form-control @error('date') is-invalid @enderror"
                                        placeholder="Enter date ...">
                                    @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="recipients" class="form-label">To Recipients</label>
                                    <select name="recipients" wire:model="recipients" class="form-select select2-multiple" id="" multiple data-placeholder="Select recipients">
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
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
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
                                        <textarea id="description" wire:model.defer="description" class="d-none"></textarea>
                                    </div>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                            wire:target="save">Save</button>
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
        <!-- Include the highlight.js library -->
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
                                                description: formData
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
                var descriptionContent = document.getElementById('description').value;
                if (descriptionContent) {
                    quill.root.innerHTML = descriptionContent;
                }

                // Update Livewire property on Quill editor content change
                quill.on('text-change', function() {
                    @this.set('description', quill.root.innerHTML);

                    Livewire.dispatch('previewContent', {
                        content: quill.root.innerHTML
                    });
                });

                Livewire.on('contentChanged', (description) => {
                    quill.root.innerHTML = description;
                });

                selectElement.select2({
                    width: '100%',
                }).on('change', function() {
                    let selectedValues = $(this).val();
                    Livewire.dispatch('changeSelectForm', ['recipients', selectedValues]);

                    // @this.set('recipients', selectedValues);
                });

                Livewire.on('change-select-form', () => {
                    var recipients = @json($recipients);
                    selectElement.val(recipients).trigger('change');
                });
            });
        </script>
    @endpush
</div>
