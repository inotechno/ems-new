<div>
    <div class="table-responsive">
        <table class="table table-centered table-nowrap mb-0">
            <thead >
                <tr>
                    <th class="align-middle">ID</th>
                    <th class="align-middle">Username</th>
                    <th class="align-middle">Name</th>
                    <th class="align-middle">Email</th>
                    <th class="align-middle">Password</th>
                    <th class="align-middle">Citizen ID</th>
                    <th class="align-middle">Join Date</th>
                    <th class="align-middle">Birth Date</th>
                    <th class="align-middle">Place of Birth</th>
                    <th class="align-middle">Gender</th>
                    <th class="align-middle">Marital Status</th>
                    <th class="align-middle">Religion</th>
                    <th class="align-middle">Leave Remaining</th>
                    <th class="align-middle">Role</th>
                    <th class="align-middle">Position ID</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($employees))
                    @foreach ($employees as $employee)
                        @livewire('import-master-data.preview-employee-item', ['employee' => $employee], key($employee['id']))
                    @endforeach
                @else
                    <tr>
                        <td colspan="15" class="text-center">No data</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
