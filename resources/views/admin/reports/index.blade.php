@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Usage Reports</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Product</th>
                <th>Start Using</th>
                <th>Stop Using</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usages as $usage)
                <tr>
                    <td>{{ $usage->user }}</td>
                    <td>{{ $usage->product }}</td>
                    <td>{{ optional($usage->started_at)->format('Y-m-d H:i:s') }}</td>
                    <td>{{ optional($usage->ended_at)->format('Y-m-d H:i:s') }}</td>
                    <td>
                        @if($usage->started_at && $usage->ended_at)
                        @php
                        $start = \Carbon\Carbon::parse($usage->started_at);
                        $end = \Carbon\Carbon::parse($usage->ended_at);
                        $seconds = $start->diffInSeconds($end);
                        $minutes = floor($seconds / 60);
                        $hours = floor($minutes / 60);
                        $remainingMinutes = $minutes % 60;
                        $remainingSeconds = $seconds % 60;
                        echo $hours . ' hour ' . $remainingMinutes . ' min ' . $remainingSeconds . ' sec';
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
