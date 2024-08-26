<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Employee', 'url' => route('employee.index')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-content-stretch gap-1 flex-column flex-md-row">
                        <div class="flex-grow-1 me-3">
                            <input type="search" class="form-control" id="searchInput" wire:model.live="search"
                                placeholder="Search for ...">
                        </div>

                        <div class="flex-shrink-0 me-3" wire:ignore>
                            <select class="form-control select2 select-position-index"
                                data-placeholder="Select Position" wire:model.live="position_id">
                                <option></option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex-shrink-0 me-3">
                            <select class="form-control select2" wire:model.live="perPage">
                                <option>Per Page</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="flex-shrink-0">
                            <button class="btn btn-warning" wire:click="resetFilter">Reset Filter</button>
                        </div>

                        @can('create:employee')
                            <div class="flex-shrink-0">
                                {{-- Create Link Add Site --}}
                                <a href="{{ route('employee.create') }}"
                                    class="btn btn-primary waves-effect waves-light">Create</a>
                            </div>
                        @endcan

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg">
            @livewire('employee.employee-list', ['employees' => $employees->getCollection()], key('employee-list'))
            {{ $employees->links() }}
        </div>
    </div>

    @push('styles')
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

        <script>
            document.addEventListener('livewire:init', function() {
                $('.select2').select2();
                $('.select-position-index').on('change', function() {
                    @this.set('position_id', this.value);
                });

                Livewire.on('reset-select2', () => {
                    $('.select-position-index').val(null).trigger('change');
                })
            });
        </script>
    @endpush
</div>
