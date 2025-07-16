<div class="col-xl-3 col-sm-6">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-truncate font-size-15">
                        <a href="javascript: void(0);"
                            class="text-dark">{{ $template->name }}</a>
                    </h5>
                    <p class="text-muted mb-2">{{ $template->subject }}</p>
                </div>
            </div>
        </div>
        <div class="px-3 py-2 border-top">
            <ul class="list-inline mb-0 d-flex gap-1 flex-wrap">
                @can('update:email-template')
                    <li class="list-inline-item">
                        <a href="{{route('email-template.edit', ['slug' => $template->slug])}}" class="btn btn-primary btn-sm waves-effect waves-light"><i class="mdi mdi-pencil me-1"></i> Edit</a>
                    </li>
                @endcan

                {{-- @can('delete:email-template')
                    <li class="list-inline-item">
                        <button type="button" wire:click="deleteConfirm()"
                            class="btn btn-danger btn-sm waves-effect waves-light">
                            <i class="mdi mdi-delete me-1"></i> Delete
                        </button>
                    </li>
                @endcan --}}
            </ul>
        </div>
    </div>
</div>
