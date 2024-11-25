@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reviewer Dashboard</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($guarantees->isEmpty())
        <p>No guarantees available for review.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Corporate Reference Number</th>
                    <th>Guarantee Type</th>
                    <th>Nominal Amount</th>
                    <th>Applicant Name</th>
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
                        <td>
                            <a href="{{ route('reviewer.guarantees') }}" class="btn btn-primary">Review</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
