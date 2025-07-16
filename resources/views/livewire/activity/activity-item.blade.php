<tr class="align-middle">
    <td>
        {{ $iteration }}
    </td>
    <td>
        <span>{{ $activity->causer->name }}</span>
    </td>
    <td>
        <div class="d-flex flex-column">
            <span>{{ $activity->created_at->format('d M, Y H:i:s') }}</span>
        </div>
    </td>
    <td>
        <span>{{ $activity->description }}</span>
    </td>
</tr>
