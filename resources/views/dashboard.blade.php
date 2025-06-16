@extends('layouts.app')

@section('content')
    <h1>Hi, {{ auth()->user()->email }}!</h1>
    <p>Welcome to Control Panel</p>
@endsection
