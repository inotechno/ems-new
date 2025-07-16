<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Email Template', 'url' => route('email-template.index')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-content-stretch gap-2 flex-column flex-md-row">
                        <div class="flex-grow-1 me-3">
                            <input type="search" class="form-control" id="searchInput" wire:model.live="search"
                                placeholder="Search for ...">
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
                        {{-- <div class="flex-shrink-0">
                            <a href="{{ route('email-template.create') }}" class="btn btn-primary waves-effect waves-light">Create</a>
                        </div> --}}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg">
            @livewire('email-template-manager.email-template-manager-list', ['templates' => $templates->getCollection()], key('email-template-manager-list'))
            {{ $templates->links() }}
        </div>
    </div>
</div>
