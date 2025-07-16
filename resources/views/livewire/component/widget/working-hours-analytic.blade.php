<div class="card">
    <div class="card-body">
        <div class="clearfix">
            <div class="float-end">
                <div class="input-group input-group-sm" wire:loading.remove>
                    <select class="form-select form-select-sm" wire:model.live="selectedMonth">
                        @foreach ($months as $month => $monthName)
                            <option value="{{ $month }}">{{ $monthName }}</option>
                        @endforeach
                    </select>
                    <label class="input-group-text">Month</label>
                </div>

                <div wire:loading>
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <h4 class="card-title mb-4">Working Hours Analytic</h4>
        </div>


        <div class="row">
            <div class="col-lg-4">
                <div class="text-muted">
                    <div class="mb-4">
                        <p>This Month <b><i>({{ $start_date }} s/d {{ $end_date }})</i></b></p>
                        <h4>{{ number_format(collect($this_month)->sum(), 2) }} Hours</h4>
                        <div><span
                                class="badge @if ($percentage_based_on_last_month > 0) badge-soft-success @else badge-soft-danger @endif font-size-12 me-1">
                                {{ $percentage_based_on_last_month }}% </span> From previous period</div>
                    </div>

                    <div class="mt-4">
                        <p class="mb-2">Last Month <b><i>({{ $start_date_last_month }} s/d
                                    {{ $end_date_last_month }})</i></b></p>
                        <h5>{{ number_format(collect($last_month)->sum(), 2) }} Hours</h5>
                    </div>

                </div>
            </div>

            <div class="col-lg-8" wire:ignore>
                <div id="line-chart" class="apex-charts" wire:key="chart-{{ $chartKey }}"></div>
            </div>

            {{-- <div class="col-lg-8" wire:ignore>
                <div id="line-chart" class="apex-charts" data-colors='["--bs-primary"]' dir="ltr"
                    wire:key="chart-{{ $chartKey }}"></div>
            </div> --}}
        </div>
    </div>

    @push('js')
        <script>
            var chart;

            function renderChart(series, labels) {
                const options = {
                    series: series,
                    chart: {
                        height: 200,
                        type: "line",
                        toolbar: false,
                    },
                    labels: labels,
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: "smooth",
                        width: 3
                    },
                    colors: ['#556ee6', '#f46a6a'],
                    tooltip: {
                        shared: true,
                        intersect: false,
                        x: {
                            formatter: function(val) {
                                return "Date " + val;
                            }
                        },
                        y: {
                            formatter: function(val) {
                                return val.toFixed(2) + " Hours";
                            }
                        }
                    }
                };

                if (chart) {
                    chart.destroy(); // ⛔ penting: hapus chart sebelumnya
                }

                chart = new ApexCharts(document.getElementById("line-chart"), options);
                chart.render();
            }

            document.addEventListener("livewire:init", function() {
                renderChart(@json($series), @json($labels));
                Livewire.on("refresh-chart", function(event) {
                    console.log('refreshing chart'); // ⛔ penting: hapus chart sebelumnya
                    console.log(event.labels);
                    console.log(event.series);
                    renderChart(event.series, event.labels);

                    // chart.updateOptions({
                    //     labels: event.labels,
                    // });
                    // chart.updateSeries([{
                    //     data: event.series,
                    // }]);
                });
            });
        </script>
    @endpush
</div>
