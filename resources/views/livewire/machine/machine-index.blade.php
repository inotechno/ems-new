<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Machine', 'url' => route('machine.index')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">

            <div class="card" id="form-machine">
                <div class="card-body" wire:ignore>
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h4 class="card-title mb-4">Machine Form</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="#!" class="btn btn-sm btn-primary" wire:click="changeStatusForm()"
                                data-bs-toggle="collapse" data-bs-target="#showForm" aria-expanded="true"
                                aria-controls="showForm">{{ $showForm ? 'Hide' : 'Show' }}</a>
                        </div>
                    </div>

                    <div class="collapse @if ($showForm) show @endif" wire:click="changeStatusForm()"
                        id="showForm">
                        @livewire('machine.machine-form', key('machine-form'))
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-content-stretch gap-1 flex-column flex-md-row">
                        <div class="flex-grow-1 me-3">
                            <input type="search" class="form-control" id="searchInput" wire:model.live="search"
                                placeholder="Search for ...">
                        </div>
                        <div class="flex-shrink-0 me-3">
                            <select class="form-control select2" wire:model.live="is_active">
                                <option>Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
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

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg">
            @livewire('machine.machine-list', ['machines' => $machines->getCollection()], key('machine-list'))

            {{ $machines->links() }}
        </div>
    </div>

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
                        scrollTop: $('#form-machine').offset().top
                    }, 500); // 500ms untuk animasi scroll
                } else {
                    $('#showForm').collapse('hide');
                }
            })
        </script>
    @endscript
</div>
