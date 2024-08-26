<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Department', 'url' => route('department.index')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">

            @can('create:department')
                <div class="card" id="form-department">
                    <div class="card-body" wire:ignore>
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h4 class="card-title mb-4">Department Form</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="#!" class="btn btn-sm btn-primary" wire:click="changeStatusForm()"
                                    data-bs-toggle="collapse" data-bs-target="#showForm" aria-expanded="true"
                                    aria-controls="showForm">{{ $showForm ? 'Hide' : 'Show' }}</a>
                            </div>
                        </div>

                        <div class="collapse @if ($showForm) show @endif" wire:click="changeStatusForm()"
                            id="showForm">
                            @livewire('department.department-form', ['sites' => $sites, 'employees' => $employees], key('department-form'))
                        </div>
                    </div>
                </div>
            @endcan

            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-content-stretch gap-1 flex-column flex-md-row">
                        <div class="flex-grow-1 me-3">
                            <input type="search" class="form-control" id="searchInput" wire:model.live="search"
                                placeholder="Search for ...">
                        </div>
                        <div class="flex-shrink-0 me-3" wire:ignore>
                            <select class="form-control select2 select-site-index" data-placeholder="Select Site"
                                wire:model.live="site_id">
                                <option></option>
                                @foreach ($sites as $site)
                                    <option value="{{ $site->id }}">{{ $site->name }}</option>
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
                            <button class="btn  btn-warning" wire:click="resetFilter">Reset Filter</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg">
            @livewire('department.department-list', ['departments' => $departments->getCollection()], key('department-list'))

            {{ $departments->links() }}
        </div>
    </div>

    {{-- @livewire('department.department-modal-add-employee',['employees' => $employees], key('department-modal-add-employee')) --}}

    @script
        <script>
            $wire.on('collapse-form', () => {
                let showForm = $wire.get('showForm');
                console.log('showForm', showForm);
                if (showForm) {
                    $('#showForm').collapse('show');
                    // Fokus pada elemen input dengan id "name"
                    $('#name').focus();
                    $('html, body').animate({
                        scrollTop: $('#form-department').offset().top
                    }, 500); // 500ms untuk animasi scroll
                } else {
                    $('#showForm').collapse('hide');
                }
            })
        </script>
    @endscript

    @push('styles')
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

        <script>
            document.addEventListener('livewire:init', function() {
                $('.select2').select2();
                $('.select-site-index').on('change', function() {
                    @this.set('site_id', this.value);
                });

                Livewire.on('reset-select2', () => {
                    $('.select-site-index').val(null).trigger('change');
                })
            });
        </script>
    @endpush
</div>
