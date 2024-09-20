<tr @if($is_old_data) class="table-warning" @else class="table-info" @endif>
    <th scope="row">{{ $site['id'] ?? '' }}</th>
    <td>{{ $site['uid'] ?? '' }}</td>
    <td>{{ $site['name'] ?? '' }}</td>
    <td>{{ $site['longitude'] ?? '' }}</td>
    <td>{{ $site['latitude'] ?? '' }}</td>
</tr>
