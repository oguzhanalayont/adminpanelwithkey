@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Ürün Kullanım Yetkisi Ver</h3>

    <form action="{{ route('manager.give.permission') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Kullanıcı Seç</label>
            <select name="email" class="form-select" required>
                <option value="" disabled selected>Kullanıcı seçin</option>
                @foreach($users as $user)
                    <option value="{{ $user->email }}">{{ $user->name }} - {{ $user->email }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="license_id" class="form-label">Ürün Seç</label>
            <select name="license_id" class="form-select" required>
                <option value="" disabled selected>Ürün seçin</option>
                @foreach($licenses as $license)
                    <option value="{{ $license->id }}">
                        {{ $license->product->name }} (Geçerlilik: {{ $license->end_date }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Kullanım Yetkisi Ver</button>
    </form>
</div>
@endsection
