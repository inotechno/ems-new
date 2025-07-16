<tr @if($is_old_data) class="table-warning" @else class="table-info" @endif>
    <th scope="row">{{ $machine['id'] ?? '' }}</th>
    <td>{{ $machine['name'] ?? '' }}</td>
    <td>{{ $machine['site_id'] ?? '' }}</td>
    <td>{{ $machine['ip_address'] ?? '' }}</td>
    <td>{{ $machine['port'] ?? '' }}</td>
    <td>{{ $machine['comkey'] ?? '' }}</td>
    <td>{{ $machine['is_active'] ?? '' }}</td>
    <td>{{ $machine['password'] ?? '' }}</td>
</tr>
