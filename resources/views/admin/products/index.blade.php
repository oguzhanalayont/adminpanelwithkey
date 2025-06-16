@extends('layouts.app')

@section('content')
    <h2>Products</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success mb-3">New Product</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Operations</th>
        </tr>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->price }} ₺</td>
            <td>
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary btn-sm">Edit</a>

                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure Want to Delete?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection
