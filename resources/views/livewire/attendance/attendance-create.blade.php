<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Attendance', 'url' => route('attendance.index')], ['name' => 'Create Attendance ']]], key('breadcrumb'))

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Attendance</h4>
                    <form wire:submit.prevent="submit" class="needs-validation form-horizontal">

                        <div class="mb-3">
                            <label for="attendance_method_id" class="form-label">Attendance Method</label>

                            <div class="btn-group d-grid gap-2 d-md-flex" role="group"
                                aria-label="Basic radio toggle button group">
                                @foreach ($attendance_methods as $method)
                                    <input type="radio" class="btn-check" name="attendance_method_id"
                                        id="{{ $method->name }}{{ $method->id }}" value="{{ $method->id }}"
                                        autocomplete="off" wire:model.live="attendance_method_id">
                                    <label
                                        class="btn btn-outline-primary  @error('attendance_method_id') btn-outline-danger @enderror"
                                        for="{{ $method->name }}{{ $method->id }}">
                                        {{ $method->name }}
                                        @error('attendance_method_id')
                                            (<strong>{{ $message }}</strong>)
                                        @enderror
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        @if ($attendance_method_id == 2)
                            <section class="mb-3">
                                @livewire('component.camera', key('selfie-camera-tag'))
                            </section>
                        @elseif($attendance_method_id == 3)
                            <div class="mb-3">
                                <label for="step" class="form-label">Selesaikan Step</label>

                                <div class="btn-group d-grid gap-2 d-md-flex" role="group"
                                    aria-label="Basic radio toggle button group">

                                    <input type="radio" class="btn-check" name="activeCamera" id="activateQRScanner"
                                        value="qr" autocomplete="off" wire:click="activateQRScanner"
                                        @if ($activeCamera === 'qr') checked @endif>
                                    <label class="btn btn-outline-primary" for="activateQRScanner">
                                        Step 1: Activate QR Scanner
                                    </label>

                                    <input type="radio" class="btn-check" name="activeCamera"
                                        id="activateSelfieCamera" value="selfie" autocomplete="off"
                                        wire:click="activateSelfieCamera"
                                        @if ($activeCamera === 'selfie') checked @endif>
                                    <label class="btn btn-outline-primary" for="activateSelfieCamera">
                                        Step 2: Activate Selfie Camera
                                    </label>

                                </div>
                            </div>

                            @if ($activeCamera === 'qr')
                                <section class="mb-3">
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
                                <section class="mb-3">
                                    @livewire('component.camera', key('selfie-camera-qr'))
                                </section>
                            @endif
                        @endif

                        <div class="mb-3">
                            <label for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" wire:model="notes">
                            </textarea>

                            @error('notes')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
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
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
