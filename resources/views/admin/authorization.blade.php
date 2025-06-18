@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Give Manager Statue to Users</h3>

    <form action="{{ route('admin.assign.manager') }}" method="POST">
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

        <button type="submit" class="btn btn-primary">Give Authorize</button>
    </form>

    <hr>

    <h4 class="mt-4">Current Managers</h4>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Assigned At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($managers as $manager)
                <tr>
                    <td>{{ $manager->name }}</td>
                    <td>{{ $manager->email }}</td>
                    <td>{{ $manager->updated_at->format('Y-m-d H:i') }}</td>
                    <td>
    <form action="{{ route('admin.revoke.manager', $manager->id) }}" method="POST" onsubmit="return confirm('Yetkiyi geri almak istediğinize emin misiniz?')">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-danger btn-sm">Revoke</button>
    </form>
</td>

                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No managers assigned yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
