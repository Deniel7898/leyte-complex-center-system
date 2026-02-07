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


    {{-- Summary Cards --}}
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Items</h6>
                    <h3>{{ $totalItems }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Quantity</h6>
                    <h3>{{ $totalQuantity }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Remaining</h6>
                    <h3>{{ $totalRemaining }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="card-title">Stock Status</h6>
                    <h3>{{ $totalQuantity > 0 ? round(($totalRemaining / $totalQuantity * 100), 1) : 0 }}%</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-header">
            <h5>Inventory Overview</h5>
        </div>
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Picture</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Remaining</th>
                        <th>Used</th>
                        <th>Availability</th>
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

                            {{-- Used --}}
                            <td>{{ $item->quantity - $item->remaining }}</td>

                            {{-- Availability --}}
                            <td>
                                @if($item->availability)
                                    <span class="badge bg-success">Available</span>
                                @else
                                    <span class="badge bg-danger">Not Available</span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No items found.</td>
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
