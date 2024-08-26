<tr @if($is_old_data) class="table-warning" @else class="table-info" @endif>
    <th scope="row">{{ $employee['id'] ?? '' }}</th>
    <td>{{ $employee['username'] ?? '' }}</td>
    <td>{{ $employee['name'] ?? '' }}</td>
    <td>{{ $employee['email'] ?? '' }}</td>
    <td>{{ $employee['password'] ?? '' }}</td>
    <td>{{ $employee['citizen_id'] ?? '' }}</td>
    <td>{{ $employee['join_date'] ?? '' }}</td>
    <td>{{ $employee['birth_date'] ?? '' }}</td>
    <td>{{ $employee['place_of_birth'] ?? '' }}</td>
    <td>{{ $employee['gender'] ?? '' }}</td>
    <td>{{ $employee['marital_status'] ?? '' }}</td>
    <td>{{ $employee['religion'] ?? '' }}</td>
    <td>{{ $employee['leave_remaining'] ?? '' }}</td>
    <td>{{ $employee['role'] ?? '' }}</td>
    <td>{{ $employee['position_id'] ?? '' }}</td>
</tr>
