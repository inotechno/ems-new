<div>
    <div class="table-responsive">
        <table class="table table-centered table-nowrap mb-0">
                <tr>
                    <th class="align-middle">ID</th>
                    <th class="align-middle">Name</th>
                    <th class="align-middle">Department ID</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($positions))
                    @foreach ($positions as $position)
                        @livewire('import-master-data.preview-position-item', ['position' => $position], key($position['id']))
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center">No data</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
