<tr @if($is_old_data) class="table-warning" @else class="table-info" @endif>
    <th scope="row">{{ $position['id'] ?? '' }}</th>
    <td>{{ $position['name'] ?? '' }}</td>
    <td>{{ $position['department_id'] ?? '' }}</td>
</tr>
