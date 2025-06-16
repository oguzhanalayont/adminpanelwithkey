@extends('layouts.app')
<script>
    function changeYears(button, diff) {
        const input = button.parentElement.querySelector('input[name="years"]');
        let val = parseInt(input.value) || 1;
        val = Math.max(1, val + diff);
        input.value = val;
    }
</script>

@section('content')
    <h2>Products</h2>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="text-muted">{{ $product->price }} ₺</p>
                        <form action="{{ route('licenses.purchase') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <div class="input-group mb-2">
        <button type="button" class="btn btn-secondary" onclick="changeYears(this, -1)">−</button>
        <input type="number" name="years" class="form-control text-center" value="1" min="1">
        <button type="button" class="btn btn-secondary" onclick="changeYears(this, 1)">+</button>
    </div>

    <button type="submit" class="btn btn-success w-100">Buy</button>
</form>

                    </div>
                </div>
            </div>
        @empty
            <p>Not Have Products Yet.</p>
        @endforelse
    </div>
@endsection
