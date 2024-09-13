<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Absent Request', 'url' => route('absent-request.index')], ['name' => 'Detail Absent Request ']]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Title</h4>
                    <h4 class="fw-bold">{{ $title }}</h4>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-flex mb-3">
                        <span class="flex-grow-1">Recipients</span>
                        @if($isApproved)
                            <span class="badge bg-success text-white text-end">Approved</span>
                        @else
                            <span class="badge bg-danger text-white text-end">Pending</span>
                        @endif
                    </h4>
                    @foreach ($recipientsWithStatus as $item)
                        <div class="d-flex {{ $item['bgClass'] }} text-white p-2 mb-2 rounded rounded-3 flex-wrap">
                            <div class="flex-grow-1">
                                {{ $item['recipient']->employee->user->name }}
                            </div>
                            <div class="flex-grow-0 text-end">
                                {{ ucfirst($item['status']) }} at
                                {{ $item['created_at'] ?? '-' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Amount</h4>
                    <h3 class="fw-bold">Rp {{ number_format($amount) }} / {{ $financialType->name }}</h3>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Notes</h4>
                    <p>{!! $notes !!}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Detail</h4>
                </div>
            </div>
        </div>

    </div>

</div>
