@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Usage Reports</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Product</th>
                <th>Validity</th>
                <th>Start Using</th>
                <th>Stop Using</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usages as $usage)
                <tr>
                    <td>{{ $usage->license->user->email }}</td>
                    <td>{{ $usage->license->product->name }}</td>
                    <td>
                        {{ optional($usage->license->start_date)->format('Y-m-d') }}
                        -
                        {{ optional($usage->license->end_date)->format('Y-m-d') }}
                    </td>
                    <td>{{ optional($usage->started_at)->format('Y-m-d H:i:s') }}</td>
                    <td>{{ optional($usage->ended_at)->format('Y-m-d H:i:s') }}</td>
                    <td>
                        @if($usage->started_at && $usage->ended_at)
                            @php
                                $diff = $usage->started_at->diff($usage->ended_at);
                                echo $diff->h . ' hour ' . $diff->i . ' min';
                            @endphp
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
