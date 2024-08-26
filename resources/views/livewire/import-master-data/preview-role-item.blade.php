<tr @if($is_old_data) class="table-warning" @else class="table-info" @endif>
    <th scope="row">{{ $role['id'] ?? '' }}</th>
    <td>{{ $role['name'] ?? '' }}</td>
    <td>{{ $role['guard_name'] ?? '' }}</td>
</tr>
