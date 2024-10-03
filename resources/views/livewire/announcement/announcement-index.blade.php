<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Announcement', 'url' => route('announcement.index')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <label for="form-label">Search</label>
                            <input type="text" class="form-control" wire:model.live="search"
                                placeholder="Search Title ...">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">

                            <label for="form-label">Date</label>
                            <div class="input-daterange input-group" id="announcement-inputgroup"
                                data-provide="datepicker" data-date-format="yyyy-mm-dd"
                                data-date-container='#announcement-inputgroup' data-date-autoclose="true">
                                <input type="text" class="form-control @error('startDate') is-invalid @enderror"
                                    wire:model="startDate" placeholder="Start Date" name="start" />
                                @error('startDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="text" class="form-control @error('endDate') is-invalid @enderror"
                                    wire:model="endDate" placeholder="End Date" name="end" />
                                @error('endDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-12 text-end mb-3">
                    <button class="btn btn-warning mt-2" wire:click="resetFilter" wire:loading.attr="disabled">Reset
                        Filter</button>
                        @can('create:announcement')
                        <a href="{{ route('announcement.create') }}" class="btn btn-primary mt-2">Create</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{ $announcements->links() }}

        <div class="col-lg-12">
            @livewire('announcement.announcement-list', ['announcements' => $announcements->getCollection()], key('announcement-list'))
        </div>

        {{ $announcements->links() }}
    </div>

    @push('styles')
        <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
         @endpush

    @push('js')
        <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
       <script>
            document.addEventListener('livewire:init', function() {
                initDatePicker();

                function initDatePicker() {
                    $('#announcement-inputgroup').datepicker({
                        format: 'yyyy-mm-dd',
                        autoclose: true,
                        todayHighlight: true,
                        inputs: $('#announcement-inputgroup').find('input')
                    }).on('changeDate', function(e) {
                        // Update the Livewire property when date is selected
                        let startDate = $('#announcement-inputgroup').find('input[name="start"]').val();
                        let endDate = $('#announcement-inputgroup').find('input[name="end"]').val();

                        @this.set('startDate', startDate);
                        @this.set('endDate', endDate);
                    });
                }

            });
        </script>
    @endpush
</div>
