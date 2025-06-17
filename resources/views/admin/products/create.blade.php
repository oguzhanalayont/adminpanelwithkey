@extends('layouts.app')

@section('content')
    <h2>Add New Product</h2>

    <form method="POST" action="{{ route('admin.products.store') }}">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Desciption</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Price (₺)</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <button class="btn btn-success">Save</button>
    </form>
@endsection
