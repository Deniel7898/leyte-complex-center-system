@extends('layouts.app')

@section('content')

<!-- ========== title-wrapper start ========== -->
<div class="title-wrapper pt-30"></div>

<!-- Modern Navigation -->
<nav class="nav-modern mb-4">
    <a href="{{ route('inventory.index') }}"
       class="{{ request()->routeIs('inventory.*') ? 'active' : '' }}">
        {{ __('Inventory') }}
    </a>

    <a href="{{ route('items.index') }}"
       class="{{ request()->routeIs('items.*') ? 'active' : '' }}">
        {{ __('Items') }}
    </a>
</nav>

<!-- ========== title-wrapper end ========== -->


        {{-- Add Item Button --}}
        <button class="btn btn-primary add-item"
                data-url="{{ route('items.create') }}">
            <i class="lni lni-plus"></i> Add Item
        </button>

    </div>

    {{-- Total Items --}}
    <div class="mb-3">
        <span class="badge bg-success total-items">
            {{ $items->total() }} Items
        </span>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body table-responsive">

            <table id="items_table" class="table table-bordered table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Picture</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Remaining</th>
                        <th>Availability</th>
                        <th>Description</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($items as $index => $item)
                        <tr>

                            <td>{{ $items->firstItem() + $index }}</td>

                            {{-- Picture --}}
                            <td>
                                @if($item->picture)
                                    <img src="{{ asset('storage/'.$item->picture) }}"
                                         width="50"
                                         class="rounded">
                                @else
                                    N/A
                                @endif
                            </td>

                            {{-- Name --}}
                            <td>{{ $item->name }}</td>

                            {{-- Category --}}
                            <td>{{ $item->category->name ?? '-' }}</td>

                            {{-- Unit --}}
                            <td>{{ $item->unit->name ?? '-' }}</td>

                            {{-- Quantity --}}
                            <td>{{ $item->quantity }}</td>

                            {{-- Remaining --}}
                            <td>{{ $item->remaining }}</td>

                            {{-- Availability --}}
                            <td>
                                @if($item->availability)
                                    <span class="badge bg-success">Available</span>
                                @else
                                    <span class="badge bg-danger">Not Available</span>
                                @endif
                            </td>

                            {{-- Description --}}
                            <td>{{ $item->description ?? '-' }}</td>

                            {{-- Actions --}}
                            <td>
                                <button class="btn btn-sm btn-primary edit-item"
                                        data-url="{{ route('items.edit', $item->id) }}">
                                    Edit
                                </button>

                                <button type="button"
                                        class="btn btn-sm btn-danger delete-item"
                                        data-url="{{ route('items.destroy', $item->id) }}">
                                    Delete
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No items found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $items->links() }}
            </div>

        </div>
    </div>

</div>

{{-- Modal --}}
<div class="modal fade" id="items_modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>

@endsection


@push('scripts')
<script>
const inventoryToggle = document.getElementById('inventoryToggle');
if (inventoryToggle) {
    inventoryToggle.addEventListener('change', function () {
        if (this.checked) {
            window.location.href = "{{ route('items.index') }}";
        } else {
            window.location.href = "{{ route('inventory.index') }}";
        }
    });
}
</script>
@endpush
