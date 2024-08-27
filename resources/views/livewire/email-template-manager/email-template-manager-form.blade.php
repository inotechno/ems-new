<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Email Template', 'url' => route('email-template.index')]]], key('breadcrumb'))


    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $type == 'create' ? 'Create Email Template' : 'Edit Email Template' }}</h4>

                    <form action="" wire:submit.prevent="save" wire:ignore class="needs-validation"
                        id="email-template-form">
                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input id="name" name="name" wire:model="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter Name ...">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input id="subject" name="subject" wire:model="subject" type="text"
                                        class="form-control @error('subject') is-invalid @enderror"
                                        placeholder="Enter Subject ...">

                                    @error('subject')
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
                                    <label for="body" class="form-label">Body</label>
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
                                        <textarea id="body" wire:model.defer="body" class="d-none"></textarea>
                                    </div>

                                    @error('body')
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

        <div class="col-md-3">
            <div class="card mb-5">
                <div class="card-body">
                    <h4 class="card-title mb-3">Placeholder Subject</h4>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="javascript:void(0)" class="placeholder-item-subject text-muted text-decoration"
                            data-placeholder="name"><u>name</u></a>
                        <a href="javascript:void(0)" class="placeholder-item-subject text-muted text-decoration"
                            data-placeholder="email"><u>email</u></a>
                        <a href="javascript:void(0)" class="placeholder-item-subject text-muted text-decoration"
                            data-placeholder="username"><u>username</u></a>
                    </div>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-body">
                    <h4 class="card-title mb-3">Placeholder Body</h4>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($placeholders as $column)
                            <a href="javascript:void(0)" class="placeholder-item text-muted text-decoration"
                                data-placeholder="{{ $column }}"><u>{{ $column }}</u></a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Preview</h4>

                    <div class="preview-container">
                        <div id="preview" class="preview-content">
                            {!! $preview !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css"
            rel="stylesheet">
        <style>
            .preview-container {
                display: flex;
                justify-content: center;
                /* Center horizontally */
                align-items: top;
                /* Center vertically */
                height: 50vh;
                /* Full viewport height for vertical centering */
            }

            .preview-content {
                max-width: 100%;
                /* Prevents the preview from being wider than its container */
                max-height: 100%;
                /* Prevents the preview from being taller than its container */
                overflow: auto;
                /* Allows scrolling if content is too large */
            }
        </style>
    @endpush

    @push('js')
        <!-- Include the highlight.js library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>

        <script>
            document.addEventListener('livewire:init', function() {

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
                                                body: formData
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

                // Tambahkan event listener pada setiap elemen placeholder
                const placeholderItems = document.querySelectorAll('.placeholder-item');
                placeholderItems.forEach(item => {
                    item.addEventListener('click', function() {
                        const placeholderText = item.getAttribute(
                            'data-placeholder'); // Ambil placeholder dari atribut data

                        if (placeholderText) {
                            const range = quill.getSelection(true); // Ambil posisi kursor saat ini
                            var user = "$user";
                            if (range) {
                                const formattedPlaceholder = `{ ${user}->${placeholderText} }`;
                                quill.insertText(range.index,
                                    '{' + formattedPlaceholder + '}'); // Insert placeholder ke editor
                                quill.setSelection(range.index + formattedPlaceholder
                                    .length); // Pindahkan kursor setelah placeholder
                            } else {
                                console.error('Selection range is undefined');
                            }
                        }
                    });
                });

                // Handle placeholders for subject field
                const subjectPlaceholderItems = document.querySelectorAll('.placeholder-item-subject');
                subjectPlaceholderItems.forEach(item => {
                    item.addEventListener('click', function() {
                        const placeholderText = item.getAttribute('data-placeholder');
                        var user = "$user";

                        if (placeholderText) {
                            const subjectInput = document.getElementById('subject');
                            if (subjectInput) {
                                const currentValue = subjectInput.value;
                                const formattedPlaceholder = `{ ${user}->${placeholderText} }`;
                                subjectInput.value = currentValue + '{' + formattedPlaceholder + '}';
                            } else {
                                console.error('Subject input element is undefined');
                            }
                        }
                    });
                });

                // Set initial content if available
                var bodyContent = document.getElementById('body').value;
                if (bodyContent) {
                    quill.root.innerHTML = bodyContent;
                }

                // Update Livewire property on Quill editor content change
                quill.on('text-change', function() {
                    @this.set('body', quill.root.innerHTML);

                    Livewire.dispatch('previewContent', {
                        content: quill.root.innerHTML
                    });
                });

                Livewire.on('contentChanged', (body) => {
                    quill.root.innerHTML = body;
                });
            });
        </script>
    @endpush
</div>
