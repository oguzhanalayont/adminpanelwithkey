@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Kullanıcılara Manager Yetkisi Ver</h3>

    <form action="{{ route('admin.assign.manager') }}" method="POST">
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

        <button type="submit" class="btn btn-primary">Yetki Ver</button>
    </form>
</div>
@endsection
