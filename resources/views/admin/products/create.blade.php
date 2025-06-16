@extends('layouts.app')

@section('content')
    <h2>Yeni Ürün Ekle</h2>

    <form method="POST" action="{{ route('admin.products.store') }}">
        @csrf
        <div class="mb-3">
            <label>Ad</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Açıklama</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Fiyat (₺)</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <button class="btn btn-success">Kaydet</button>
    </form>
@endsection
