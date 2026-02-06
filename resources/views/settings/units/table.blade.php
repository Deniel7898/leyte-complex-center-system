@foreach($units as $unit)
    <tr>
        <td>{{ $unit->id }}</td>
        <td>{{ $unit->name }}</td>
        <td>{{ $unit->description }}</td>
        <td>
            <button 
                class="btn btn-sm btn-primary edit" 
                data-url="{{ route('units.edit', $unit->id) }}">
                Edit
            </button>

            <button 
                class="btn btn-sm btn-danger delete" 
                data-url="{{ route('units.destroy', $unit->id) }}">
                Delete
            </button>
        </td>
    </tr>
@endforeach
