<div class="col-md-6 col-lg-4 col-xl-4 col-sm-6">
    <div class="card card-rounded ">
        <div class="card-body">
            <div class="favorite-icon">
                <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
            </div>
            <img src="{{ $site->qrcode_url }}" alt="" height="50" class="mb-3">
            <h5 class="fs-17 mb-2"><a href="{{ route('site.detail', ['uid' => $site->uid]) }}"
                    class="text-dark">{{ $site->name }}</a> <small class="text-muted fw-normal">(0-2 Yrs Exp.)</small>
            </h5>
            <ul class="list-inline mb-0">
                <li class="list-inline-item">
                    <a href="javascript:void(0)" class="text-link waves-effect waves-light" data-bs-toggle="popover"
                        data-bs-trigger="hover focus" title="{{ $site->name }}"
                        data-bs-content="{{ $site->address }}">
                        {{ $site->short_address }}</a>
                </li>
                <li class="list-inline-item mt-2">
                    <p class="text-muted fs-14 mb-0"><i class="mdi mdi-map-marker"></i> {{ $site->longitude }},
                        {{ $site->latitude }}</p>
                </li>
            </ul>
            <div class="mt-3 hstack gap-2">
                <a href="https://www.google.com/maps?q={{ $site->latitude }},{{ $site->longitude }}" target="_blank"
                    class="btn btn-sm btn-soft-primary"><i class="bx bx-map align-middle me-1"></i>
                    {{ __('Lihat Lokasi') }} </a>
                @if ($site->image_url)
                    <a href="https://www.google.com/maps?q={{ $site->latitude }},{{ $site->longitude }}"
                        target="_blank" class="btn btn-sm btn-soft-warning"><i
                            class="bx bx-image align-middle me-1"></i>
                        {{ __('Lihat Gambar') }} </a>
                @endif
            </div>
            <div class="mt-4 hstack gap-2">
                @can('update:site')
                    <a href="{{ route('site.edit', ['uid' => $site->uid]) }}"
                        class="btn btn-soft-primary w-100">{{ __('Edit') }}</a>
                @endcan

                @can('delete:site')
                    <a href="javascript:void(0)" wire:click="deleteConfirm()"
                        class="btn btn-soft-danger w-100">{{ __('Hapus') }}</a>
                @endcan
            </div>
        </div>
    </div>
</div>
