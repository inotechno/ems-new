<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Configuration', 'url' => '/'], ['name' => 'Setting', 'url' => route('setting.edit')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-md-12">
            <form action="" wire:submit.prevent="save" class="needs-validation" id="setting-form">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">General</h4>

                        @foreach (['app_title', 'app_name', 'app_description', 'app_version', 'app_author', 'app_author_url', 'app_copyright'] as $key)
                            <div class="mb-3">
                                <label for="{{ $key }}"
                                    class="form-label">{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                                <input type="text" class="form-control" id="{{ $key }}"
                                    wire:model.defer="settings.{{ $key }}">
                                @error('settings.' . $key)
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Logo</h4>

                        <div class="row">
                            @foreach (['app_logo_full_dark', 'app_logo_full_light', 'app_logo_small_dark', 'app_logo_small_light'] as $key)
                                <div class="mb-3 col-md-6">
                                    <label for="{{ $key }}"
                                        class="form-label">{{ ucwords(str_replace('_', ' ', $key)) }}</label>

                                    <div class="d-flex mt-3">
                                        <div class="flex-shrink-0 me-3">
                                            <!-- Loading indicator -->
                                            <div wire:loading wire:target="uploaded_{{ $key }}"
                                                class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>

                                            @if (${"uploaded_$key"})
                                                <img class="rounded avatar-sm w-100"
                                                    src="{{ ${"uploaded_$key"}->temporaryUrl() }}"
                                                    alt="New {{ ucwords(str_replace('_', ' ', $key)) }}">
                                            @else
                                                <!-- Image preview (only show when not loading) -->
                                                <img wire:loading.remove wire:target="uploaded_{{ $key }}"
                                                    class="rounded avatar-sm w-100" src="{{ $settings[$key] }}"
                                                    alt="Current {{ ucwords(str_replace('_', ' ', $key)) }}">
                                            @endif
                                        </div>

                                        <div class="flex-grow-1">
                                            <input type="file" class="form-control"
                                                wire:model.live="uploaded_{{ $key }}">

                                            @error("uploaded_{{ $key }}")
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Contact</h4>

                        @foreach (['contact_email', 'contact_phone', 'contact_address', 'contact_city', 'contact_country', 'contact_zip', 'contact_map'] as $key)
                            <div class="mb-3">
                                <label for="{{ $key }}"
                                    class="form-label">{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                                <input type="{{ $key === 'contact_email' ? 'email' : 'text' }}" class="form-control"
                                    id="{{ $key }}" wire:model.defer="settings.{{ $key }}">
                                @error('settings.' . $key)
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Floating Save Button -->
                <button type="submit" wire:loading.attr="disabled" wire:target="save" class="floating-save-btn">
                    <div wire:loading class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>

                    <div class="btn-content" wire:loading.remove>
                        <i class='bx bx-save'></i>
                        <span class="save-text">SAVE</span>
                    </div>

                </button>
            </form>
        </div>
    </div>

    @push('styles')
        <style>
            .floating-save-btn {
                position: fixed;
                bottom: 80px;
                right: 30px;
                width: 45px;
                height: 45px;
                border-radius: 8px;
                background-color: #007bff;
                border: none;
                color: white;
                cursor: pointer;
                overflow: hidden;
                transition: all 0.3s ease;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                padding: 0;
            }

            .btn-content {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 100%;
            }

            .floating-save-btn i {
                font-size: 24px;
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
                transition: left 0.3s ease;
            }

            .save-text {
                white-space: nowrap;
                margin-left: 25px;
                opacity: 0;
                transition: opacity 0.3s ease;
                visibility: hidden;
                font-size: 16px;
            }

            .floating-save-btn:hover {
                width: 110px;
                border-radius: 25px;
            }

            .floating-save-btn:hover i {
                left: 25px;
            }

            .floating-save-btn:hover .save-text {
                opacity: 1;
                visibility: visible;
            }

            /* Hover effect */
            .floating-save-btn:hover {
                background-color: #0056b3;
            }
        </style>
    @endpush

</div>
