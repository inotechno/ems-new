<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Email Template', 'url' => route('email-template.index')]]], key('breadcrumb'))


    <div class="row">
        <div class="col-lg-12">
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
    </div>

    @push('styles')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css"
            rel="stylesheet">
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
                            container: [
                                [{
                                    header: [1, 2, 3, false]
                                }],
                                ['bold', 'italic', 'underline'],
                                ['link', 'image', 'code-block'],
                                [{
                                    list: 'ordered'
                                }, {
                                    list: 'bullet'
                                }],
                                ['clean']
                            ],
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
                                }
                            }
                        }
                    }
                });

                // Set initial content if available
                var bodyContent = document.getElementById('body').value;
                if (bodyContent) {
                    quill.root.innerHTML = bodyContent;
                }

                // Update Livewire property on Quill editor content change
                quill.on('text-change', function() {
                    @this.set('body', quill.root.innerHTML);
                });

                Livewire.on('contentChanged', (body) => {
                    quill.root.innerHTML = body;
                });
            });
        </script>
    @endpush
</div>
