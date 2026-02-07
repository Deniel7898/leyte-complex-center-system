<form action="{{ isset($item) ? route('items.update', $item->id) : route('items.store') }}" 
      method="POST" 
      enctype="multipart/form-data">

    <div class="modal-header">
        <h1 class="modal-title fs-5">
            {{ isset($item) ? 'Edit' : 'Add' }} Item
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        @csrf
        @if(isset($item))
            @method('PUT')
        @endif

        {{-- Name --}}
        <div class="mb-3">
            <label class="col-form-label">Name:</label>
            <input type="text" class="form-control" name="name"
                value="{{ old('name', $item->name ?? '') }}" required>
        </div>

        {{-- Category --}}
        <div class="mb-3">
            <label class="col-form-label">Category:</label>
            <select class="form-control" name="category_id" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ (isset($item) && $item->category_id == $category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Unit --}}
        <div class="mb-3">
            <label class="col-form-label">Unit:</label>
            <select class="form-control" name="unit_id" required>
                <option value="">Select Unit</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}"
                        {{ (isset($item) && $item->unit_id == $unit->id) ? 'selected' : '' }}>
                        {{ $unit->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Quantity (only when creating) --}}
        @if(!isset($item))
            <div class="mb-3">
                <label class="col-form-label">Quantity:</label>
                <input type="number" class="form-control" name="quantity" required>
            </div>
        @else
            <input type="hidden" name="quantity" value="{{ $item->quantity }}">
        @endif

        {{-- Availability --}}
        <div class="mb-3">
            <label class="col-form-label">Availability:</label>
            <select class="form-control" name="availability" required>
                <option value="1" {{ isset($item) && $item->availability ? 'selected' : '' }}>Available</option>
                <option value="0" {{ isset($item) && !$item->availability ? 'selected' : '' }}>Not Available</option>
            </select>
        </div>

        {{-- Picture --}}
        <div class="mb-3">
            <label class="col-form-label">Picture:</label>
            <input type="file" class="form-control" name="picture">
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label class="col-form-label">Description (Optional):</label>
            <textarea class="form-control" name="description">
                {{ old('description', $item->description ?? '') }}
            </textarea>
        </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>

</form>
