<div class="col-md-6 col-lg-4">
    <div class="card blog-stats-wid">
        <div class="card-body">
            <div class="d-flex flex-wrap">

                <div class="me-3 flex-grow-1">
                    <p class="text-muted mb-2">{{ $machine->name }}</p>
                    <h5 class="mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="IP Address">
                        {{ $machine->ip_address }}</h5>
                    <p class="text-muted mb-0">{{ $machine->port }}</p>
                </div>

                <div class="avatar-sm mx-auto align-self-center d-xl-block d-none">
                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-16">
                        {{ substr($machine->name, 0, 1) }}
                    </span>
                </div>

            </div>

            <div class="d-flex gap-2 justify-content-center mt-3">
                <button type="button" class="btn btn-primary btn-sm waves-effect waves-light"
                    wire:click="$dispatch('set-machine', {machine_id: {{ $machine->id }}})"><i class="mdi mdi-pencil me-1"></i> Edit
                </button>

                <button type="button" class="btn btn-danger btn-sm waves-effect waves-light"
                    wire:click="deleteConfirm()"><i class="mdi mdi-delete me-1"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>
