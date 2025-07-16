<div>
    <div class="table-responsive">
        <table class="table table-centered table-nowrap mb-0">
            <thead >
                <tr>
                    <th class="align-middle">ID</th>
                    <th class="align-middle">Name</th>
                    <th class="align-middle">Site ID</th>
                    <th class="align-middle">IP Address</th>
                    <th class="align-middle">Port</th>
                    <th class="align-middle">Comkey</th>
                    <th class="align-middle">Is Active</th>
                    <th class="align-middle">Password</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($machines))
                    @foreach ($machines as $machine)
                        @livewire('import-master-data.preview-machine-item', ['machine' => $machine], key($machine['id']))
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">No data</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
