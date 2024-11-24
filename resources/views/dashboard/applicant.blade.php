@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome to Your Dashboard, {{ auth()->user()->name }}</h1>

    @if(isset($message))
    <div class="alert alert-info">
        {{ $message }}
    </div>
    @endif

    <h2>Your Guarantees</h2>

    @if ($guarantees->isEmpty())
    <p>No guarantees found. Start creating your guarantees now!</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>Corporate Reference Number</th>
                <th>Guarantee Type</th>
                <th>Nominal Amount</th>
                <th>Expiry Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guarantees as $guarantee)
            <tr>
                <td>{{ $guarantee->corporate_reference_number }}</td>
                <td>{{ $guarantee->guarantee_type }}</td>
                <td>{{ $guarantee->nominal_amount }}</td>
                <td>{{ $guarantee->expiry_date }}</td>
                <td>
                    <a href="{{ route('guarantees.edit', $guarantee->id) }}">Edit</a>
                    <form action="{{ route('guarantees.destroy', $guarantee->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <a href="{{ route('guarantees.create') }}" class="btn btn-primary">Create New Guarantee</a>
</div>
@endsection