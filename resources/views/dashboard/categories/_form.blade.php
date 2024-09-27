@if ($errors->any())
    <div class="alert alert-danger">
        <h3>Error Occured</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <label for="name">Category Name</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $category->name) }}">
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="form-group">
    <label for="parent_id">Category Parent</label>
    <select name="parent_id" class="form-control form-select " id="parent_id">
        <option value="" disabled >No Category </option>
        @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name }}</option>
        @endforeach
    </select>
    @error('parent_id')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description">{{ old('description', $category->description) }}</textarea>
    @error('description')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="form-group">
    <label for="image">Image</label>
    <input type="file" name="image" class="form-control" id="image" accept="image/*">
    @if ($category->image)
        <img src="{{ asset('storage/'.$category->image) }}" alt="" height="80">
    @endif
    @error('image')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Status</label>
    <div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" value="active" id="active" @checked(old('status', $category->status) == 'active')>
            <label class="form-check-label" for="active">Active</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" value="archived" id="archived" @checked(old('status', $category->status) == 'archived')>
            <label class="form-check-label" for="archived">Archived</label>
        </div>
    </div>
    @error('status')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? "Save" }}</button>
</div>
