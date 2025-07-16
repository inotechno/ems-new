<div>
    <div wire:ignore.self class="modal fade" id="employeeChartModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Working Hours - {{ $employeeName }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4 ms-auto">
                            <div class="input-group input-group-sm">
                                <select wire:model.live="selectedMonth" class="form-select form-select-sm">
                                    @foreach ($months as $num => $name)
                                        <option value="{{ $num }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                <label class="input-group-text">Month</label>
                            </div>
                        </div>
                    </div>
                    {{--
                    <div wire:loading>
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div> --}}

                    <div wire:ignore.self>
                        <div id="{{ $chartId }}" class="apex-charts w-100" data-colors='["--bs-primary"]'
                            wire:key="chart-{{ $chartId }}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            let employeeChart = null;

            document.addEventListener('livewire:init', function() {
                Livewire.on('refresh-employee-chart', ({
                    series,
                    labels,
                    chartId
                }) => {
                    const modalEl = document.getElementById('employeeChartModal');
                    let modalInstance = bootstrap.Modal.getInstance(modalEl);

                    const renderChart = () => {
                        requestAnimationFrame(() => {
                            const container = document.getElementById(chartId);
                            if (!container) return;

                            if (employeeChart) employeeChart.destroy();

                            const options = {
                                series: series,
                                chart: {
                                    height: 250,
                                    type: "line",
                                    toolbar: false
                                },
                                labels: labels,
                                stroke: {
                                    curve: "smooth",
                                    width: 3
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                colors: ['#556ee6', '#f46a6a'], // warna this month & last month
                            };

                            employeeChart = new ApexCharts(container, options);
                            employeeChart.render();
                        });
                    };


                    if (!modalEl.classList.contains('show')) {
                        if (!modalInstance) modalInstance = new bootstrap.Modal(modalEl);
                        modalInstance.show();
                        modalEl.addEventListener('shown.bs.modal', renderChart, {
                            once: true
                        });
                    } else {
                        renderChart();
                    }

                    modalEl.addEventListener('hidden.bs.modal', () => {
                        if (employeeChart) {
                            employeeChart.destroy();
                            employeeChart = null;
                        }
                        Livewire.dispatch('resetChartId');
                    });
                });
            });
        </script>
    @endpush
</div>
