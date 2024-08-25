<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Import Master Data', 'url' => route('import.index')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="form-machine">
                <div class="card-body" wire:ignore>
                    <h4 class="card-title mb-4">IMPORT MASTER DATA</h4>

                    <div class="d-flex gap-3">
                        <div class="flex-grow-1">
                            <input type="file" class="form-control @error('file') is-invalid @enderror"
                                wire:model="file">

                            @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button class="btn btn-primary" wire:click="import" wire:loading.attr="disabled"
                            wire:target="import">Import
                        </button>
                        <button class="btn btn-warning" wire:click="download" wire:loading.attr="disabled"
                            wire:target="download">Download Template
                        </button>
                    </div>

                    <!-- Show loading spinner while processing the file -->
                    <div class="d-flex align-items-center mt-3" wire:loading wire:target="file" wire:target="import">
                        <div class="spinner-border text-primary" role="status" wire:loading wire:target="file"
                            wire:target="import">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <span class="ms-2" wire:loading wire:target="file" wire:target="import">Processing...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
