<div>
    <div class="table-responsive">
        <table class="table table-centered table-nowrap mb-0">
            <thead >
                <tr>
                    <th class="align-middle">ID</th>
                    <th class="align-middle">Name</th>
                    <th class="align-middle">Site ID</th>
                    <th class="align-middle">Supervisor ID</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($departments))
                    @foreach ($departments as $department)
                        @livewire('import-master-data.preview-department-item', ['department' => $department], key($department['id']))
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">No data</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
