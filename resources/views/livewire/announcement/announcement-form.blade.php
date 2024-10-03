<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Announcement', 'url' => route('announcement.index')]]], key('breadcrumb'))


    <form action="" wire:submit.prevent="save" wire:ignore.self class="needs-validation" id="announcement-form">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            {{ $type == 'create' ? 'Create Announcement' : 'Edit Announcement' }}</h4>

                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input id="title" name="title" wire:model="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Enter Title ...">

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3" wire:ignore>
                                    <label for="recipients" class="form-label">To Recipients</label>
                                    <select name="recipients" wire:model="recipients"
                                        class="form-select select2-multiple" id="" multiple
                                        data-placeholder="Select recipients">
                                        <option value="all">Select All</option>

                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
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

                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card mb-5">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Placeholder Title</h4>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="javascript:void(0)" class="placeholder-item-title text-muted text-decoration"
                                data-placeholder="name"><u>name</u></a>
                            <a href="javascript:void(0)" class="placeholder-item-title text-muted text-decoration"
                                data-placeholder="email"><u>email</u></a>
                            <a href="javascript:void(0)" class="placeholder-item-title text-muted text-decoration"
                                data-placeholder="username"><u>username</u></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Placeholders</h4>
                        <p class="card-title-desc">Select placeholder to add in body of email</p>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#user" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">User</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="user" role="tabpanel">
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($placeholders_user as $user)
                                        <a href="javascript:void(0)" data-prefix="$user"
                                            class="placeholder-item text-muted text-decoration"
                                            data-placeholder="{{ $user }}"><u>{{ $user }}</u></a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-body">

                        <div class="row" wire:ignore>
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
                    </div>
                </div>
            </div>
        </div>
    </form>

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
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

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
        <script src="https://unpkg.com/quill-html-edit-button@2.2.7/dist/quill.htmlEditButton.min.js"></script>
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
                        htmlEditButton: {
                            debug: true, // logging, default:false
                            msg: "Edit the content in HTML format", //Custom message to display in the editor, default: Edit HTML here, when you click "OK" the quill editor's contents will be replaced
                            okText: "Ok", // Text to display in the OK button, default: Ok,
                            cancelText: "Cancel", // Text to display in the cancel button, default: Cancel
                            buttonHTML: "&lt;&gt;", // Text to display in the toolbar button, default: <>
                            buttonTitle: "Show HTML source", // Text to display as the tooltip for the toolbar button, default: Show HTML source
                            syntax: false, // Show the HTML with syntax highlighting. Requires highlightjs on window.hljs (similar to Quill itself), default: false
                            prependSelector: 'div#myelement', // a string used to select where you want to insert the overlayContainer, default: null (appends to body),
                            editorModules: {} // The default mod
                        }
                    }
                });

                // Tambahkan event listener pada setiap elemen placeholder
                const placeholderItems = document.querySelectorAll('.placeholder-item');
                placeholderItems.forEach(item => {
                    item.addEventListener('click', function() {
                        const placeholderText = item.getAttribute(
                            'data-placeholder'); // Ambil placeholder dari atribut data
                        var prefix = item.getAttribute('data-prefix');

                        if (placeholderText) {
                            const range = quill.getSelection(true); // Ambil posisi kursor saat ini
                            // var user = "$user";

                            if (range) {
                                const formattedPlaceholder = `{ ${prefix}->${placeholderText} }`;
                                quill.insertText(range.index,
                                    '{' + formattedPlaceholder + '}'); // Insert placeholder ke editor
                                quill.setSelection(range.index + formattedPlaceholder
                                    .length + 2); // Pindahkan kursor setelah placeholder
                            } else {
                                console.error('Selection range is undefined');
                            }
                        }
                    });
                });

                // Handle placeholders for title field
                const titlePlaceholderItems = document.querySelectorAll('.placeholder-item-title');
                titlePlaceholderItems.forEach(item => {
                    item.addEventListener('click', function() {
                        const placeholderText = item.getAttribute('data-placeholder');
                        var user = "$user";

                        if (placeholderText) {
                            const titleInput = document.getElementById('title');
                            if (titleInput) {
                                const currentValue = titleInput.value;
                                const formattedPlaceholder = `{ ${user}->${placeholderText} }`;
                                titleInput.value = currentValue + '{' + formattedPlaceholder + '}';
                            } else {
                                console.error('Title input element is undefined');
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
                    // @this.set('body', quill.getSemanticHTML());

                    Livewire.dispatch('setContent', {
                        content: quill.getSemanticHTML()
                    });
                });

                function convertListToQuillFormat(content) {
                    // console.log(content);
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(content, 'text/html');

                    // Mengubah semua <ul> menjadi <li data-list="bullet">
                    doc.querySelectorAll('ul').forEach(ul => {
                        ul.querySelectorAll('li').forEach(li => {
                            li.setAttribute('data-list', 'bullet');
                        });
                    });

                    // Mengubah semua <ol> menjadi <li data-list="ordered">
                    doc.querySelectorAll('ol').forEach(ol => {
                        ol.querySelectorAll('li').forEach(li => {
                            li.setAttribute('data-list', 'ordered');
                        });
                    });

                    return doc.body.innerHTML;
                }

                Livewire.on('contentChanged', (body) => {
                    const convertedContent = convertListToQuillFormat(body);
                    // console.log(convertedContent);
                    quill.clipboard.dangerouslyPasteHTML(0, convertedContent);

                });


                selectElement.select2({
                    width: '100%',
                }).on('change', function() {
                    let selectedValues = $(this).val();
                    // console.log(selectedValues);
                    Livewire.dispatch('change-input-form', ['recipients', selectedValues]);
                });

                selectElement.on("select2:select", function(e) {
                    var data = e.params.data.text;
                    if (data == 'Select All') {
                        $(".select2-multiple > option").prop("selected", "selected");
                        $('.select2-multiple > option[value="all"]').prop("selected", false);
                        $(".select2-multiple").trigger("change");
                    }
                });

                Livewire.on('set-default-form', () => {
                    var recipients = @json($recipients);
                    selectElement.val(recipients).trigger('change');
                })

            });
        </script>
    @endpush
</div>
