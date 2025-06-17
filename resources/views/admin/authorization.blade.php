@extends('layouts.app')

@section('content')
    <h3>Manager Yetkilendirme</h3>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <form method="POST" action="{{ route('admin.assign.manager') }}">
        @csrf
        <div class="mb-3">
            <label>Email Adresi</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button class="btn btn-primary">Yetkilendir</button>
    </form>
@endsection
