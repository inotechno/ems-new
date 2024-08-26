<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Site', 'url' => route('site.index')]]])

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <h4 class="card-title mb-4">Filter Site</h4>
                    <div class="d-flex align-content-stretch gap-1 flex-column flex-md-row">
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

                        @can('create:site')
                        <div class="flex-shrink-0">
                            {{-- Create Link Add Site --}}
                            <a href="{{ route('site.create') }}" class="btn btn-primary waves-effect waves-light">Create</a>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>

            @livewire('site.site-list', ['sites' => $sites->getCollection()], key('site-list'))

            {{ $sites->links() }}
        </div>
    </div>

</div>
