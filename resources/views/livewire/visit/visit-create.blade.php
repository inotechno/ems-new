<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Visit', 'url' => route('attendance.index')], ['name' => 'Create Visit ']]], key('breadcrumb'))

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="submit" class="needs-validation form-horizontal">
                        <div id="visit-wizard">

                            <div class="mb-3">
                                <label for="step" class="form-label">Selesaikan Step</label>

                                <div class="btn-group d-grid gap-2 d-md-flex" role="group"
                                    aria-label="Basic radio toggle button group">

                                    <input type="radio" class="btn-check" name="activeCamera" id="activateQRScanner"
                                        value="qr" autocomplete="off" wire:click="activateQRScanner"
                                        @if ($activeCamera === 'qr') checked @endif>
                                    <label class="btn btn-outline-primary" for="activateQRScanner"
                                        data-tg-tour="Scan QR yang ada pada site" data-tg-group="visit-create" data-tg-title="Step Create Visit">
                                        Step 1: Activate QR Scanner
                                    </label>

                                    <input type="radio" class="btn-check" name="activeCamera"
                                        id="activateSelfieCamera" value="selfie" autocomplete="off"
                                        wire:click="activateSelfieCamera"
                                        @if ($activeCamera === 'selfie') checked @endif>
                                    <label class="btn btn-outline-primary" for="activateSelfieCamera"
                                        data-tg-tour="Ambil gambar dari kamera" data-tg-group="visit-create" data-tg-title="Step Create Visit">
                                        Step 2: Activate Selfie Camera
                                    </label>

                                </div>
                            </div>

                            @if ($activeCamera === 'qr')
                                <section class="mb-3" data-tg-group="visit-create" data-tg-title="Step Create Visit" data-tg-tour="Tampilan Kamera untuk scan QR">
                                    @if ($content)
                                        <div class="text-center">
                                            <div class="mb-4">
                                                <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                            </div>
                                            <div>
                                                <h3>{{ $site_name }}</h3>
                                                <h4>{{ $site_longitude }}, {{ $site_latitude }}</h4>
                                            </div>
                                        </div>
                                    @endif

                                    @livewire('component.qr-camera', key('qr-scanner'))
                                </section>

                            @endif

                            @if ($activeCamera === 'selfie')
                                <section class="mb-3" data-tg-group="visit-create" data-tg-title="Step Create Visit" data-tg-tour="Tampilan Kamera untuk mengambil gambar dari kamera">
                                    @livewire('component.camera', key('selfie-camera'))
                                </section>
                            @endif

                            <section class="mb-3">
                                <div class="mb-3" data-tg-group="visit-create" data-tg-title="Step Create Visit" data-tg-tour="Pilih Kategori Visit">
                                    <label for="visit_category_id">Visit Category</label>
                                    <div class="btn-group d-grid gap-2 d-md-flex" role="group"
                                        aria-label="Basic radio toggle button group">
                                        @foreach ($visit_categories as $category)
                                            <input type="radio" class="btn-check" name="visit_category_id"
                                                id="{{ $category->name }}{{ $category->id }}"
                                                value="{{ $category->id }}" autocomplete="off"
                                                wire:model.live="visit_category_id">
                                            <label
                                                class="btn btn-outline-primary  @error('visit_category_id') btn-outline-danger @enderror"
                                                for="{{ $category->name }}{{ $category->id }}">
                                                {{ $category->name }}
                                                @error('visit_category_id')
                                                    (<strong>{{ $message }}</strong>)
                                                @enderror
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-3" data-tg-group="visit-create" data-tg-title="Step Create Visit" data-tg-tour="Catatan Visit">
                                    <label for="notes">Notes</label>
                                    <textarea wire:model="notes" id="notes" class="form-control" rows="3"></textarea>
                                    @error('notes')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                @livewire(
                                    'component.map',
                                    [
                                        'site_name' => $site_name,
                                        'site_latitude' => $site_latitude,
                                        'site_longitude' => $site_longitude,
                                    ],
                                    key('map')
                                )
                            </section>
                        </div>

                        @if ($activeCamera === 'selfie')
                            <div class="mb-3 d-flex justify-content-end gap-2">
                                <button id="submit" type="submit" class="btn btn-primary w-md col-md"
                                    wire:submit.prevent="submit" wire:loading.attr="disabled" wire:target="submit">
                                    <i wire:loading.class="spinner-border spinner-border-sm" wire:target="submit"></i>
                                    {{ __('Save') }}
                                </button>

                                <button id="cancel" type="button" class="btn btn-light w-md col-md"
                                    wire:click="$dispatch('close-modal')" wire:loading.attr="disabled"
                                    wire:target="submit">{{ __('Cancel') }}</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

    </div>

    @push('js')
        <script>
            document.addEventListener('livewire:init', function() {
                const tg = new TourGuideClient({
                    group: 'visit-create', // opsional: tentukan grup jika tur terkait dengan halaman tertentu
                    autoplay: false, // agar pengguna bisa mengontrol kapan tur dimulai
                    steps: [] // opsional jika menggunakan data attribute
                });

                $('#start-tour').on('click', function() {
                    tg.start();
                });
            });
        </script>
    @endpush

</div>
