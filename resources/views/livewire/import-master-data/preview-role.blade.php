<div>
    <div class="table-responsive">
        <table class="table table-centered table-nowrap mb-0">
                <tr>
                    <th class="align-middle">ID</th>
                    <th class="align-middle">Name</th>
                    <th class="align-middle">Guard Name</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($roles))
                    @foreach ($roles as $role)
                        @livewire('import-master-data.preview-role-item', ['role' => $role], key($role['id']))
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
