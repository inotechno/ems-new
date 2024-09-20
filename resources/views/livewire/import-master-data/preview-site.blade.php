<div>
    <div class="table-responsive">
        <table class="table table-centered table-nowrap mb-0">
            <thead >
                <tr>
                    <th class="align-middle">ID</th>
                    <th class="align-middle">UID</th>
                    <th class="align-middle">Name</th>
                    <th class="align-middle">Longitude</th>
                    <th class="align-middle">Latitude</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($sites))
                    @foreach ($sites as $site)
                        @livewire('import-master-data.preview-site-item', ['site' => $site], key($site['id']))
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
