@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Give Authorization to User for Product</h3>

    <form action="{{ route('manager.give.permission') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Choose User</label>
            <select name="email" class="form-select" required>
                <option value="" disabled selected>Click for Users</option>
                @foreach($users as $user)
                    <option value="{{ $user->email }}">{{ $user->name }} - {{ $user->email }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="license_id" class="form-label">Choose Product</label>
            <select name="license_id" class="form-select" required>
                <option value="" disabled selected>Click for Products</option>
                @foreach($licenses as $license)
                    <option value="{{ $license->id }}">
                        {{ $license->product->name }} (Validity: {{ $license->end_date }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Give Authorization</button>
    </form>
</div>
@endsection
