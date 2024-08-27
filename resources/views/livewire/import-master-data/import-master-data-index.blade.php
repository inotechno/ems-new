<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Import Master Data', 'url' => route('import.index')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="form-machine">
                <div class="card-body" wire:ignore>
                    <h4 class="card-title mb-4">IMPORT MASTER DATA</h4>

                    <div class="d-flex gap-3">
                        <div class="flex-grow-1">
                            <label for="type_data" class="form-label">Type Data</label>
                            <select name="" class="form-control" class="type_data" wire:model="type_data"
                                id="">
                                <option value="">Select Type</option>
                                <option value="Employee">Employee</option>
                                <option value="Position">Position</option>
                                <option value="Department">Department</option>
                                <option value="Site">Site</option>
                                <option value="Machine">Machine</option>
                                <option value="Role">Role</option>
                            </select>
                        </div>
                        <div class="flex-grow-1">
                            <label for="file" class="form-label">File</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror"
                                wire:model="file">

                            @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button class="btn btn-primary" wire:click="preview" wire:loading.attr="disabled"
                            wire:target="preview">Preview
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

    @if ($previewData)
        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Preview {{ $type_data }}</h4>
                        @if ($type_data == 'Employee')
                            @livewire('import-master-data.preview-employee', ['employees' => $previewData])
                        @elseif ($type_data == 'Position')
                            @livewire('import-master-data.preview-position', ['positions' => $previewData])
                        @elseif ($type_data == 'Department')
                            @livewire('import-master-data.preview-department', ['departments' => $previewData])
                        @elseif ($type_data == 'Site')
                            @livewire('import-master-data.preview-site', ['sites' => $previewData])
                        @elseif ($type_data == 'Machine')
                            @livewire('import-master-data.preview-machine', ['machines' => $previewData])
                        @elseif ($type_data == 'Role')
                            @livewire('import-master-data.preview-role', ['roles' => $previewData])
                        @endif

                        <div class="mt-3">
                            <!-- Tombol Import -->
                            <button class="btn btn-primary" wire:click="import" wire:loading.attr="disabled" wire:target="import">
                                Import
                            </button>
                            <!-- Indikator Loading -->
                            <div wire:loading wire:target="import">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Importing...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
