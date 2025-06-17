@extends('layouts.app')

@section('content')
    <h3>Ürün Kullanım Yetkisi Ver</h3>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <form method="POST" action="{{ route('manager.give.permission') }}">
        @csrf
        <div class="mb-3">
            <label>Email Adresi</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Ürün (Lisans)</label>
            <select name="license_id" class="form-control">
                @foreach(auth()->user()->licenses as $license)
                    <option value="{{ $license->id }}">{{ $license->product->name }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary">Yetki Ver</button>
    </form>
@endsection
