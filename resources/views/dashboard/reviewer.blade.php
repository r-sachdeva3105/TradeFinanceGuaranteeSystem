@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="content p-4">
        <h1>Welcome to the Reviewer Dashboard, {{ auth()->user()->name }}</h1>

        @if(session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
        @endif

        <!-- Guarantees Table -->
        @if($guarantees->isEmpty())
        <p>No guarantees available for review.</p>
        @else
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Corporate Reference Number</th>
                    <th>Guarantee Type</th>
                    <th>Nominal Amount</th>
                    <th>Applicant Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guarantees as $guarantee)
                <tr>
                    <td>{{ $guarantee->corporate_reference_number }}</td>
                    <td>{{ $guarantee->guarantee_type }}</td>
                    <td>{{ $guarantee->nominal_amount }} {{ $guarantee->nominal_amount_currency }}</td>
                    <td>{{ $guarantee->applicant_name }}</td>
                    <td class="text-capitalize">{{ $guarantee->status }}</td> <!-- Show status -->
                    <td>
                        <a href="{{ route('reviewer.guarantees', $guarantee->id) }}" class="btn btn-primary btn-sm">Review</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection