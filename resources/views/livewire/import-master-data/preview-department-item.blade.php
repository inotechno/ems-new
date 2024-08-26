<tr @if($is_old_data) class="table-warning" @else class="table-info" @endif>
    <th scope="row">{{ $department['id'] ?? '' }}</th>
    <td>{{ $department['name'] ?? '' }}</td>
    <td>{{ $department['site_id'] ?? '' }}</td>
    <td>{{ $department['supervisor_id'] ?? '' }}</td>
</tr>
