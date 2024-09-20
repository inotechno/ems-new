<div class="col-lg-4 col-xl-3">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-start mb-3">
                <div class="flex-grow-1">
                    @if($isApproved)
                        <span class="badge badge-soft-success">Approved</span>
                    @elseif($isRejected)
                        <span class="badge badge-soft-danger">Rejected</span>
                    @else
                        <span class="badge badge-soft-secondary">Pending</span>
                    @endif
                </div>
                <div class="flex-shrink-0">
                    <span class="badge badge-soft-danger">{{ $financial_request->created_at->diffForHumans() }}</span>
                </div>
            </div>
            <div class="text-center mb-1">
                <div class="avatar-sm mx-auto align-self-center d-xl-block d-none">
                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-16">
                        {{ substr($user->name, 0, 1) }}
                    </span>
                </div>

                <h6 class="font-size-15 mt-3 mb-1">{{ $user->name }}</h6>
                <p class="mb-0 fw-bolder mt-3 text-muted">{{ $financial_request->title }}</p>
                <p class="font-size-24 fw-bold mb-0">Rp {{ number_format($financial_request->amount) }}</p>
            </div>
            <div class="d-flex mb-3 justify-content-center gap-2 text-muted">
                {{-- <p class="mb-0 text-center">{{ $financial_request->start_date->format('d M') }} -
                    {{ $financial_request->end_date->format('d M') }} ( {{ $totalDays }} Hari )</p> --}}
            </div>
            <div class="hstack gap-2 justify-content-center flex-wrap">
                @foreach ($recipientsWithStatus as $item)
                    <span class="badge {{ $item['badgeClass'] }} font-size-12" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="{{ ucfirst($item['status']) }}">
                        {{ $item['recipient']->employee->user->name }}
                    </span>
                @endforeach
            </div>

            <div class="d-flex gap-2 justify-content-center flex-wrap my-3">
                @if ($recipientStatus && !$isApprovedRecipient)
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Action <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu">
                            <!-- item-->
                            <a class="dropdown-item btn btn-soft-danger btn-sm"
                                wire:click="rejectConfirm({{ $financial_request->id }})" href="javascript:void(0);"><i
                                    class="mdi mdi-close"></i> Reject</a>
                            <a class="dropdown-item btn btn-soft-success btn-sm"
                                wire:click="approveConfirm({{ $financial_request->id }})" href="javascript:void(0);"><i
                                    class="mdi mdi-check"></i> Approve</a>
                        </div>
                    </div>
                @endif

                <a href="{{ route('financial-request.detail', ['id' => $financial_request->id]) }}"
                    class="btn btn-soft-warning btn-sm"><i class="mdi mdi-eye-outline"></i> View</a>

                @if (!$disableUpdate && !$disableUpdateApprove)
                    <a href="{{ route('financial-request.edit', ['id' => $financial_request->id]) }}"
                        class="btn btn-soft-primary btn-sm"><i class="mdi mdi-pencil-outline"></i> Edit</a>
                    <a href="javascript:void(0)" class="btn btn-soft-danger btn-sm"
                        wire:click="deleteConfirm({{ $financial_request->id }})"><i class="mdi mdi-delete-outline"></i>
                        Delete</a>
                @endif
            </div>
        </div>
    </div>
</div>
