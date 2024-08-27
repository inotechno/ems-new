<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Project', 'url' => route('project.index')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <h4 class="card-title mb-4">Filter Site</h4>
                    <div class="d-flex align-content-stretch gap-3 flex-column flex-md-row">
                        <div class="flex-grow-1">
                            <input type="search" class="form-control" id="searchInput" wire:model.live="search"
                                placeholder="Search for ...">
                        </div>
                        <div class="flex-shrink-0" wire:ignore>
                            <select class="form-control select2 select-status" wire:model.live="status"
                                data-placeholder="Select Status">
                                <option>Select Status</option>
                                <option value="not_started">Not Started</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="on_hold">On Hold</option>
                            </select>
                        </div>
                        <div class="flex-shrink-0" wire:ignore>
                            <select class="form-control select2 select-per-page" wire:model.live="perPage"
                                data-placeholder="Select Per Page">
                                <option>Select Per Page</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="flex-shrink-0">
                            <button type="button" class="btn btn-warning waves-effect waves-light"
                                wire:click="resetFilter">
                                Reset
                            </button>
                        </div>

                        @can('create:project')
                            <div class="flex-shrink-0">
                                {{-- Create Link Add Site --}}
                                <a href="{{ route('project.create') }}"
                                    class="btn btn-primary waves-effect waves-light">Create</a>
                            </div>
                        @endcan

                    </div>
                </div>
            </div>

            @livewire('project.project-list', ['projects' => $projects->getCollection()], key('project-list'))

            {{ $projects->links() }}
        </div>
    </div>

    @push('styles')
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

        <script>
            document.addEventListener('livewire:init', function() {
                $('.select2').select2({
                    placeholder: 'Select an option',
                    width: 'resolve'
                });
                $('.select-status').on('change', function() {
                    @this.set('status', this.value);
                });

                $('.select-per-page').on('change', function() {
                    @this.set('perPage', this.value);
                });

                Livewire.on('reset-select2', () => {
                    $('.select-status').val(null).trigger('change');
                    $('.select-per-page').val(null).trigger('change');
                })
            });
        </script>
    @endpush
</div>
