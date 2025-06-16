@extends('layouts.app')

@section('content')
    <h2>My Orders</h2>

    @foreach ($licenses as $license)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $license->product->name }}</h5>
                <p>{{ $license->product->description }}</p>
                <p>
    Validity:
    {{ optional($license->start_date)->format('Y-m-d') }} -
    {{ optional($license->end_date)->format('Y-m-d') }}
</p>



                @if (!$license->is_active)
                    <form action="{{ route('licenses.start', $license->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary">Start Using</button>
                    </form>
                @else
                    <form action="{{ route('licenses.stop', $license->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-warning">Stop Using</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
@endsection
