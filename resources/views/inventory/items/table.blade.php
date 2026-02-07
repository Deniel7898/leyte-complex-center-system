@forelse($items as $item)
<tr>
    <td>
        @if($item->picture)
            <img src="{{ asset('storage/' . $item->picture) }}"
                 width="50"
                 height="50"
                 style="object-fit:cover;">
        @else
            -
        @endif
    </td>

    <td>{{ $item->name }}</td>

    <td>{{ $item->category->name ?? '-' }}</td>

    <td>{{ $item->unit->name ?? '-' }}</td>

    <td>{{ $item->quantity }}</td>

    <td>
        @if($item->availability)
            <span class="badge bg-success">Available</span>
        @else
            <span class="badge bg-danger">Not Available</span>
        @endif
    </td>

    <td>
        <button class="btn btn-sm btn-warning edit-item"
                data-url="{{ route('items.edit', $item->id) }}">
            Edit
        </button>

        <button class="btn btn-sm btn-danger delete-item"
                data-url="{{ route('items.destroy', $item->id) }}">
            Delete
        </button>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center">
        No items found.
    </td>
</tr>
@endforelse
